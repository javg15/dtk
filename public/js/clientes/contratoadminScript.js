/**======================================================================
 * Función que carga jExcel con algunos datos por default y los formatea
 * @author Emmanuel Hernández Díaz
 * ======================================================================
 */
 $.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});


$(document).ready(function(){
    CargarAdmin_contratoadmin()
});

/** ============
 *  Cargar la tabla de administrador
 *  ====================
 */
function CargarAdmin_contratoadmin(){
    $.ajax({
		url     : routes.urlJS+'/contratos/get_admin',
		type    : 'POST',
		dataType: 'JSON',
        /*data: {
					clieprov: 1,
					fechainicio : '2019-01-01',
                    fechafin    : moment().format("YYYY-MM-DD"),
				},*/
		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
		success : function (data) { 
		  
			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
			if (data['status'] == 'success')
			{
				/* Muestra el admin */
				pintaAdmin_contratoadmin(data);
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
function pintaAdmin_contratoadmin(data){
    
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
                case "botones":
                        header[i]["render"]=function ( data, type, full, meta ) {
                                var botones=data.split(',');
                                var $html=''
                                var $onclick='';var $target='';
                                
                                for(var j=0;j<botones.length;j++){
                                    var icono='',$title='';;
                                    switch(botones[j]){
                                        case "editar":icono='edit';
                                            $target='#contratos_modal'; 
                                            $onclick='onclick = "javascript:addJSmain(\''+routes.urlJS+'contratos/form/?id='+full.ID+'\',\''+$target+'\',CargarAdmin_contratoadmin)"';
                                             $title="Editar";
                                            break;
                                        case "ver":icono='pageview'; 
                                            $target='#contratos_modal';
                                            $onclick='onclick = "javascript:addJSmain(\''+routes.urlJS+'contratos/form/?id='+full.ID+'\',\''+$target+'\')"';
                                            $title="Ver";
                                            break;
                                        case "pago":icono='attach_money';
                                            $target='#clienteedocuenta_modal';   
                                            $onclick='onclick = "javascript:addJSmain(\''+routes.urlJS+'clientesedocuenta/form/?id='+full.ID+'\',\''+$target+'\')"';
                                            $title="Pagos";
                                            break;
                                    }
                                    /**
                                    * modal en en blade.php
                                    */
                                    $html+='<button type="button" class="btn btn-default waves-effect btn-xs" '
                                              + 'data-toggle   = "modal" '
										      + 'data-target   = "'+$target+'" '
										      + 'data-backdrop = "static" '
										      + 'data-keyboard = "false" '
                                              + 'title         = "'+$title+'" '
                                              + $onclick
                                              + '>'
                                            + '<i class="material-icons">'+icono+'</i>'
                                        + '</button>'
                                    
                                }
                             return $html;
                         }
                        break;
                
            }
        }
    }

    //
    $('#tablaadmin_contratoadmin').DataTable( {
            dom: 'Bfrtip',
            destroy: true,
            //serverSide: true,
            buttons: [
            'pageLength',
                {
                    extend:    'excelHtml5',
                    text:      'Excel',
                    titleAttr: 'Excel'
                },
                {
                    text:      '&nbsp;',
                },
                {
                    text:      'Nuevo',
                    titleAttr: 'Nuevo',
                    action: function ( e, dt, node, config ) {
                        addJSmain(routes.urlJS+'contratos/form','#contratos_modal',CargarAdmin_contratoadmin)                    
                    }
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
            
        } 
    );
    
}

