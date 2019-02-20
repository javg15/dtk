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
    CargarAdmin()
	
});

/** ============
 *  Cargar el estado de cuenta
 *  ====================
 */
function CargarAdmin(){
    $.ajax({
		url     : routes.urlJS+'/clientes/get_admin',
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
				pintaAdmin(data);
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
function pintaAdmin(data){
    
    var datos=Object.keys(data.data).map(function(j){
        return data.data[j]
    });
    //
    $('#tablaadmin').DataTable( {
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
            columns: [
                { "data": "id","title": "ID" },
                { "data": "icode","title": "Código", },
                { "data": "cliente","title": "Cliente", },
                { "data": "saldo","title": "Saldo", render: $.fn.dataTable.render.number( ',', '.', 2,'$' ) },
                { "data": "","title": "", },
            ],
            columnDefs: [ {
                    targets: -1,
                    defaultContent: '<button type="button" class="btn bg-blue waves-effect">'
            						+'<span>Ver</span>'
            					   +'</button>'
                    },
                    {sClass : "text-right",targets:3},
                    {sClass : "text-center",targets:-1}
            ],
            
        } 
    );
    
    $('#tablaadmin tbody').on( 'click', 'button', function () {
        var data = $('#tablaadmin').DataTable().row( $(this).parents('tr') ).data();
        
        linkmenu(data.id,'/clientes/registro','');
    } );
}

/* =============================================================
 * Atiende al menu de botones
 * ============================================================= */
function linkmenu($id,$url,$href){
    window.location.href = $url+'?id_clieprov='+$id;
	/*$.ajax({
	    url: $url,
	    type: 'POST',
	    data: {
	        id_clieprov: $id,
	    },
	    dataType: 'JSON',
	    success: function () {
	        window.location.href = $href;
	    },
	    error: function (data) {
	        if (data.responseJSON.message) {
	            muestraAlerta('error', data.responseJSON.message);
	            location.reload();
	            return;
	        }
	        if (data.responseJSON.errors.iP) {
	            muestraAlerta('error', data.responseJSON.errors.iP[0]);
	            return;
	        }
	    }
	});*/
}

/**=========================================================================
 * Regresar al menu de productos
 * =========================================================================
 */
function regresar(){
    window.location.href = routes.urlJS+"/home";
}