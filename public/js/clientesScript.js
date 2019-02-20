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
    $("#fecha").datetimepicker({
        locale: 'es',
        format: 'L',
        defaultDate:moment()
    });
    
    $('#movimiento').selectpicker();
    
    CargarEdoCuenta()
	
});

/** ============
 *  Cargar el estado de cuenta
 *  ====================
 */
function CargarEdoCuenta(){
    $.ajax({
		url     : routes.urlJS+'/clientes/get_edocuenta',
		type    : 'POST',
		dataType: 'JSON',
        data: {
					fechainicio : '2019-01-01',
                    fechafin    : moment().format("YYYY-MM-DD"),
				},
		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
		success : function (data) { 
		  
			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
			if (data['status'] == 'success')
			{
				/* Muestra jExcel con los datos recibidos */
				$("#tab-content").html(pintaReporte(data));
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
    var headers=Object.keys(data.headers).map(function(j){
        return data.headers[j]
    });
    //
    var tabla="<table id='tablapromedios' class='tablaremision table table-striped table-bordered dataTable no-footer' role='grid' style='width: 100%;font-size: 12px;'><thead><tr>";
    
    for(i=0;i<headers.length;i++)
        tabla+="<th>"+data.headers[i]["concepto"] +"</th>";
        
    tabla+="</tr></thead>";
    
    tabla +="<tbody>";
    for(i=0;i<datos.length;i++){
        var clase="";
        tabla+="<tr>";
        for(j=0;j<headers.length;j++){
            var concepto=headers[j]["concepto"].toLowerCase();
            if(concepto=='concepto'){
                
                posstyle=datos[i][concepto].indexOf("<class>");
                if(posstyle>=0){
                    posstyle+=7;
                    clase=datos[i][concepto].substring(posstyle);
                    datos[i][concepto]=datos[i][concepto].substring(0,posstyle-7)
                }
                
                tabla+="<td class='"+clase+"'>"+datos[i][concepto]+"</td>"
            }
            else if(concepto=='fecha'){
                tabla+="<td class='"+clase+"'>"+datos[i][concepto]+"</td>"
            }
            else{
                if(clase.indexOf("vacia")>=0)
                    tabla+="<td>&nbsp;</td>"
                else
                    tabla+="<td class='"+clase+"' style='text-align:right;'>"+numeral(datos[i][concepto]).format('$ 0,0.00')+"</td>"
            }
        }
        tabla+="</tr>";
    }
    tabla+="</tbody>"
        +"</table><br/>";
    
    return tabla;
}

/**=========================================================================
 * Registra un movimiento
 * =========================================================================
 */
function setMovimiento(){
    var msg=validarForms();
    if(msg==true){
    
        $.ajax({
    		url     : routes.urlJS+'/clientes/set_movimiento',
    		type    : 'POST',
    		dataType: 'JSON',
            data: {
    					clieprov: 1,
    					fecha       : moment($("#fecha input").val(),"DD/MM/YYYY").format("YYYY-MM-DD"),
                        cantidad    : $("#cantidad").val(),
                        movimiento  : $("#movimiento").val(),
                        concepto    : $("#concepto").val(),
    				},
    		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
    		success : function (data) { 
    		  
    			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
    			if (data['status'] == 'success')
    			{
    				/* Muestra jExcel con los datos recibidos */
    				CargarEdoCuenta();
    			/* Si hubo algún error se muestra al usuario para su correción */
    			} else {
    				swal({
    					type : 'error',
    					title: 'Existen errores de captura',
    					html : data.msg,
    				});
    			}	
    		},
    		error: function(data) {
    			/* Si existió algún otro tipo de error se muestra en la consola */
    			console.log(data)
    		}
    	});
     }
}

/**=========================================================================
 * Validar controles
 * =========================================================================
 */

function validarForms(){
    var msg="";
    if($("#frmMovimientos")[0].checkValidity()) {
        return true;
   	} 
    $("#frmMovimientos")[0].reportValidity();
    return false;
}
/**=========================================================================
 * Regresar al menu de productos
 * =========================================================================
 */
function regresar(){
    window.location.href = routes.urlJS+"/clientes/admin";
}