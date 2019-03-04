/**======================================================================
 * Función que carga jExcel con algunos datos por default y los formatea
 * @author Emmanuel Hernández Díaz
 * ======================================================================
 */
 var renglonconceldasvacias=[];


$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function(){
    
    $("#fechainicio").datetimepicker({
        locale: 'es',
        format: 'L',
        defaultDate:moment()
    });
    
	$("#fechacorte").datetimepicker({
        locale: 'es',
        format: 'L',
        defaultDate:moment()
    });
    
    
});

function cargar_reporte(){
    $.ajax({
		url     : routes.urlJS+'/reportes/get_pagos',
		type    : 'POST',
		dataType: 'JSON',
        data    :{
                fechainicio  : moment($("#fechainicio input").val(),"DD/MM/YYYY").format("YYYY-MM-DD"),
                fechacorte  : moment($("#fechacorte input").val(),"DD/MM/YYYY").format("YYYY-MM-DD"),
        },
		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
		success : function (data) { 
		  
			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
			if (data['status'] == 'success')
			{
				/* Muestra jExcel con los datos recibidos */
				$("#tablareporte").html(pintaReporte(data));
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
    
    if ($.fn.DataTable.isDataTable( '#tablareporte' ) ) {
        $('#tablareporte').html('');
        $('#tablareporte').dataTable().api().clear();
    }
        
    var footer="<tfoot>";
    for(var i=0;i<header.length;i++)
        footer+="<th></th>"
    footer+="</tfoot>"
    $("#tablareporte").append(footer);
    //
    
    var table = $('#tablareporte').DataTable( {
            //dom: 'Bfrtip',
            dom: '<"top">Bfrtip<"footer"><"bottom"><"clear">',
            destroy: true,
            //serverSide: true,
            paging:false,
            buttons: [
            //'pageLength',
                {
                    extend:    'print',
                    footer: true,
                    text:      'Imprimir',
                    titleAttr: 'Imprimir',
                    title: data.titulo,
                     
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
            order: [[ 0, "desc" ]],
            "footerCallback": function ( row, data, start, end, display ) {
        
                total = this.api()
                    .column(3)//numero de columna a sumar
                    //.column(1, {page: 'current'})//para sumar solo la pagina actual
                    .data()
                    .reduce(function (a, b) {
                        return parseInt(a) + parseInt(b);
                    }, 0 );
                $(this.api().column(2).footer()).html("Total:");
                $(this.api().column(3).footer()).html(numeral(total).format("$0,0.00"));
                
            },
    });
    
    
}

