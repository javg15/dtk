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
    $("#fechainicio").datetimepicker({
        locale: 'es',
        format: 'L',
        defaultDate:moment()
    });
    
    $('#numparcialidades').selectpicker();
    
    get_registro_contrato()	
});

function get_registro_contrato(){
    
    $.ajax({
		url     : routes.urlJS+'contratos/get_registro',
		type    : 'POST',
		dataType: 'JSON',
        data: {},
		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
		success : function (data) { 
		  
			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
			if (data['status'] == 'success')
			{
			     $.AdminBSB.form.fill("#frmContratos",data.data[0],exclude="")
				/* Muestra jExcel con los datos recibidos */
				$("#tablacontrato").html(pintaReporte_contrato(data.datatabla));
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
/**=========================================================================
 * Registra un movimiento
 * =========================================================================
 */
function set_registro_contrato(){
    
    var msg=validarForms_contrato();
    if(msg==true){
        var formserialize=$.AdminBSB.form.serialize("#frmContratos");
        
        $.ajax({
    		url     : routes.urlJS+'/contratos/set_registro',
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
    					title: 'Contrato',
    					html : data.msg,
    				});
                    
                    get_registro_contrato();
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

/** ============
 * 
 *  ====================
 */
function pintaReporte_contrato(data){
    var headers=Array({concepto:"Fecha"},{concepto:"Cargo"});
    var datos=Object.keys(data).map(function(j){
        return data[j]
    });
    //
    var tabla="<table class='table table-striped table-bordered dataTable no-footer' role='grid' style='width: 100%;font-size: 12px;'><thead><tr>";
    
    for(i=0;i<headers.length;i++){
        if(headers[i]["concepto"].toLowerCase()!="id")
            tabla+="<th>"+headers[i]["concepto"] +"</th>";
    }
    tabla+="<th></th>";
        
    tabla+="</tr></thead>";
    
    tabla +="<tbody>";
    for(i=0;i<datos.length;i++){
        var clase="";
        tabla+="<tr>";
        for(j=0;j<headers.length;j++){
            var concepto=headers[j]["concepto"].toLowerCase();
                
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
        /*tabla+='<td style="text-align:center;"><button type="button" class="btn bg-red waves-effect" onclick="javascript:quitarMovimiento('+ datos[i]["id"] +')">'
					+'<span>Eliminar</span>'
				   +'</button></td>';*/
        tabla+="</tr>";
    }
    tabla+="</tbody>"
        +"</table><br/>";
    
    return tabla;
}
/**=========================================================================
 * Validar controles
 * =========================================================================
 */

function validarForms_contrato(){
    var msg="";
    if($("#frmContratos")[0].checkValidity()) {
        return true;
   	} 
    $("#frmContratos")[0].reportValidity();
    return false;
}

