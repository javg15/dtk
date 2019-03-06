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
    
    $("#crearcuenta").on("change",function(){
        if($("#crearcuenta").is(":checked")){
            $("#divcuentas").show()    
        }
        else
            $("#divcuentas").hide()
        
    })
    $("#divcuentas").hide();
    
    //declarar validaciones
    $('#frmClientes').bootstrapValidator();
;
        
    get_registro_cliente()
});

function get_registro_cliente(){
    
    $.ajax({
		url     : routes.urlJS+'clientes/get_registro',
		type    : 'POST',
		dataType: 'JSON',
        data: {},
		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
		success : function (data) { 
		  
			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
			if (data['status'] == 'success')
			{
			     $.AdminBSB.form.fill("#frmClientes",data.data[0],exclude="")
				/* Muestra jExcel con los datos recibidos */
				//$("#tab-content").html(pintaReporte_cliente(data));
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
function pintaReporte_cliente(data){
    
    var datos=Object.keys(data.datos).map(function(j){
        return data.datos[j]
    });
    //
    var tabla="<table class='table table-striped table-bordered dataTable no-footer' role='grid' style='width: 100%;font-size: 12px;'><thead><tr>";
    
    for(i=0;i<data.headers.length;i++){
        if(data.headers[i]["concepto"].toLowerCase()!="id")
            tabla+="<th>"+data.headers[i]["concepto"] +"</th>";
    }
    tabla+="<th></th>";
        
    tabla+="</tr></thead>";
    
    tabla +="<tbody>";
    for(i=0;i<datos.length;i++){
        var clase="";
        tabla+="<tr>";
        for(j=0;j<data.headers.length;j++){
            var concepto=data.headers[j]["concepto"].toLowerCase();
            //Mostrar en la etiqueta el primer saldo
            if(concepto=='saldo' && i==0){
                $("#saldofinal").html(numeral(datos[i][concepto]).format('$ 0,0.00'));
            }
                
            if(concepto.toLowerCase()!="id"){
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
        }
        tabla+='<td style="text-align:center;"><button type="button" class="btn bg-red waves-effect" onclick="javascript:quitarMovimiento('+ datos[i]["id"] +')">'
					+'<span>Eliminar</span>'
				   +'</button></td>';
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
function set_registro_cliente(){
    $("#frmClientes").bootstrapValidator('validate');
    
    if($("#frmClientes").data('bootstrapValidator').isValid()){
        var formserialize=$("#frmClientes").serializeArray();
        
        $.ajax({
    		url     : routes.urlJS+'/clientes/set_registro',
    		type    : 'POST',
    		dataType: 'JSON',
            data: {
                datos:formserialize,
            },
    		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
    		success : function (data) { 
    		  
    			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
    			if (data['status'] == 'success')
    			{
    				swal({
    					type : 'success',
    					title: 'Cliente',
    					html : data.msg,
    				});
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

function validarForms_cliente(){
    /*
    if($("#frmClientes")[0].checkValidity()) {
        return true;
   	} 
    $("#frmClientes")[0].reportValidity();
    return false;*/
    
    
    
    
}

// IMPORTANT NOTICE: You have to declare the callback as a global function
// outside of $(document).ready()
function checkUser(value, validator) {
    if($("#crearcuenta").is(":checked")){
        if($("[name='email']").val().length<=6)
            return false;
    }
    
    return true;
};

function checkPassword(value, validator) {
    if($("#crearcuenta").is(":checked")){
        if($("[name='password']").val().length<=6)
            return false;
    }
    
    return true;
};