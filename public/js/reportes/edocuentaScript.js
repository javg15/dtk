/**======================================================================
 * Función que carga jExcel con algunos datos por default y los formatea
 * @author Emmanuel Hernández Díaz
 * ======================================================================
 */
 var renglonconceldasvacias=[];
var $encabezado='';

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function(){
    
	$('#id_cliente').selectpicker().on('change', function(){
	   //Limpiar el control
       $("#id_contrato").html('');
       
        $.ajax({
    		url     : routes.urlJS+'/reportes/get_contratos',
    		type    : 'POST',
    		dataType: 'JSON',
            data    :{
                    id_cliente  : $('#id_cliente').val()
            },
    		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
    		success : function (data) { 
    		  
    			if (data['status'] == 'success')
    			{
    				/* Llena el combo de contratos */
                    
                    $("#id_contrato").append('<option id=""></option>');
                    for(var i=0;i<data.datos.length;i++)
    				    $("#id_contrato").append('<option value="' + data.datos[i]["id"] + '">' + data.datos[i]["idesc"] + '</option>');
            
                    $("#id_contrato").selectpicker('refresh');
    			/* Si hubo algún error se muestra al usuario para su correción */
    			} else {
    				swal({
    					type : 'error',
    					title: 'Oops...',
    					text : data.msg,
    				});
    			}	
    		},
    		error: function(data) {
    			/* Si existió algún otro tipo de error se muestra en la consola */
    			console.log(data)
    		}
    	});
    });
    
    //Mostrar reporte
    $("#btnmostrar").on("click",function(){
        var msg=validarForms_cliente();
        if(msg==true){
            cargar_reporte()
        }
    });
    
    
    
    $('#id_contrato').selectpicker();
});

function cargar_reporte(){
    $.ajax({
		url     : routes.urlJS+'/reportes/get_edocuenta',
		type    : 'POST',
		dataType: 'JSON',
        data    :{
                id_contrato  : $('#id_contrato').val(),
        },
		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
		success : function (data) { 
		  
			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
			if (data['status'] == 'success')
			{
				/* Muestra jExcel con los datos recibidos */
                if(data.datos.length)
				    $("#tablareporte").html(pintaReporte(data));
                else
                    $("#tablareporte").html("NO EXISTE INFORMACIÓN RELACIONADA CON LOS DATOS PROPORCIONADOS")
			/* Si hubo algún error se muestra al usuario para su correción */
			} else {
				swal({
					type : 'error',
					title: 'Oops...',
					text : data.msg,
				});
			}	
		},
		error: function(data) {
			/* Si existió algún otro tipo de error se muestra en la consola */
			console.log(data)
		}
	});
}
/** ============
 * 
 *  ====================
 */
function pintaReporte(data){
    
    var datos=Object.keys(data.datos).map(function(j){
        return data.datos[j]
    });
    var header=JSON.parse(data.headers[0]["cabeceras"].replace(/(?:\r\n|\r|\n|\s)/g, ''));
    
    for(var i=0;i<header.length;i++){
        if(header[i]["render"]!=undefined){
            switch(header[i]["render"]){
                case "status":header[i]["render"]=function ( data, type, full, meta ) {
                    
                        if(full.State=="A")
                            return '<span class="label bg-green">Activo</span>'
                    }
                    break;
                case "moneda":header[i]["render"]=$.fn.dataTable.render.number( ',', '.', 2,'$' );
                            break;
                
            }
        }
    }
    
    $encabezado='<table border="0" cellpadding="50"><tr>'
                    + '<td>&nbsp;<b>Cliente:</b></td>'
                    + '<td>'+data.encabezado[0]["cliente"]+'</td>'
                +'</tr>'
                + '<tr>'
                    + '<td>&nbsp;<b>Contrato:</b></td>'
                    + '<td>'+data.encabezado[0]["clave_contrato"]+'-'+data.encabezado[0]["contrato"]+'</td>'
                    + '<td>&nbsp;<b>Saldo al día:</b></td>'
                    + '<td>'+numeral(data.encabezado[0]["saldodia"]).format("$0,0.00")+'</td>'
                    + '<td>&nbsp;<b>Saldo total:</b></td>'
                    + '<td>'+numeral(data.encabezado[0]["saldototal"]).format("$0,0.00")+'</td>'
                +'</tr>'
                + '<tr>'
                    + '<td>&nbsp;<b>Fecha inicio:</b></td>'
                    + '<td>'+data.encabezado[0]["fecha_inicio"]+'</td>'
                    + '<td>&nbsp;<b>Total:</b></td>'
                    + '<td>'+numeral(data.encabezado[0]["total_contrato"]).format("$0,0.00")+'</td>'
                    + '<td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Anticipo:</b></td>'
                    + '<td>'+numeral(data.encabezado[0]["anticipo"]).format("$0,0.00")+'</td>'
                    + '<td>&nbsp;&nbsp;&nbsp;&nbsp;<b>Parcialidades:</b></td>'
                    + '<td>'+data.encabezado[0]["numparcialidades"]+'</td>'
                +'</tr></table>'
    ;
    $("#encabezado").html($encabezado);
    
    if ($.fn.DataTable.isDataTable( '#tablareporte' ) ) {
        $('#tablareporte').html('');
        $('#tablareporte').dataTable().api().clear();
    }

    //
    $('#tablareporte').DataTable( {
            //dom: 'Bfrtip',
            dom: '<"top">Bfrtip<"bottom"><"clear">',
            destroy: true,
            //serverSide: true,
            paging:false,
            buttons: [
            //'pageLength',
                {
                    extend:    'print',
                    text:      'Imprimir',
                    titleAttr: 'Imprimir',
                    title: "Estado de cuenta",
                    messageTop: function () {
                            return $encabezado;
                    },
                    messageBottom: null,
                    /*customize: function ( win ) {
                        $(win.document.head)
                            .prepend(
                                '<link href="' + routes.urlJS + 'plugins/bootstrap/css/bootstrap.css" rel="stylesheet" media="print">'
                            );
                            
                        $(win.document.body)
                            .append(
                                '<script src="' + routes.urlJS + 'plugins/bootstrap/js/bootstrap.js"></script>'
                            );
                    }*/
                },
                {
                    extend:    'excelHtml5',
                    text:      'Excel',
                    titleAttr: 'Excel'
                },
                {
                    text:      '&nbsp;',
                },
            ],
            language: {
                "url": routes.urlJS+"plugins/jquery-datatable/plugins/spanish.json",
                buttons: {
                    pageLength: {
                        _: "Ver %d registros",
                        //'-1': "Todo"
                    }
                }
            },
            data:datos,
            columns: header ,
            columnDefs: [ 
                    {sClass : "text-right",targets:data.align_right[0]},
                    {sClass : "text-center",targets:-1}
            ],
            //order: [[ 0, "desc" ]]
        } 
    );
}

/**=========================================================================
 * Validar controles
 * =========================================================================
 */

function validarForms_cliente(){
    var msg="";
    if($("#frmClientes")[0].checkValidity()) {
        return true;
   	} 
    $("#frmClientes")[0].reportValidity();
    return false;
}