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
    
    CargarEdoCuenta_cliente()
});

/** ============
 *  Cargar el estado de cuenta
 *  ====================
 */
function CargarEdoCuenta_cliente(){
    $.ajax({
		url     : routes.urlJS+'clientesedocuenta/get_edocuenta',
		type    : 'POST',
		dataType: 'JSON',
        data: {
                    
				},
		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
		success : function (data) { 
		  
			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
			if (data['status'] == 'success')
			{
				/* Muestra jExcel con los datos recibidos */
				$("#tablaedocuenta").html(pintaReporte_clienteedocuenta(data));
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
function pintaReporte_clienteedocuenta(data){
    
    var datos=Object.keys(data.datos).map(function(j){
        return data.datos[j]
    });
    //
    var tabla="<table id='tablapromedios' class='tablaremision table table-striped table-bordered dataTable no-footer' role='grid' style='width: 100%;font-size: 12px;'><thead><tr>";
    
    for(i=0;i<data.headers.length;i++){
        if(data.headers[i]["concepto"].toLowerCase()!="id")
            tabla+="<th>"+data.headers[i]["concepto"] +"</th>";
    }
    tabla+="<th></th>";
        
    tabla+="</tr></thead>";
    
    tabla +="<tbody>";
    for(i=0;i<datos.length;i++){
        if(i==0){
            $("#cantidad").val(datos[i]["Cargo"]);//Valor por default
            $("#concepto").val('');//Valor por default
        }
        
        var clase="";
        tabla+="<tr>";
        for(j=0;j<data.headers.length;j++){
            var concepto=data.headers[j]["concepto"];//.toLowerCase();
            //Mostrar en la etiqueta el primer saldo
            if(concepto.toLowerCase()=='saldo'){
                if(i==datos.length-1)
                    $("#saldofinal").html(numeral(datos[i][concepto]).format('$ 0,0.00'));
                if(datos[i]["mostrar"]==1)//"mostrar" significa si esta vigente de acuerdo a la fecha
                    $("#saldopendiente").html(numeral(datos[i][concepto]).format('$ 0,0.00'));
            }
            
            if(j==0 && datos[i]["mostrar"]==0)//"mostrar" significa si esta vigente de acuerdo a la fecha
                clase=" rowgris ";
            
                
            if(concepto.toLowerCase()!="id"){
                if(concepto.toLowerCase()=='concepto'){
                    
                    posstyle=datos[i][concepto].indexOf("<class>");
                    if(posstyle>=0){
                        posstyle+=7;
                        clase+=datos[i][concepto].substring(posstyle);
                        datos[i][concepto]=datos[i][concepto].substring(0,posstyle-7)
                    }
                    
                    tabla+="<td class='"+clase+"'>"+datos[i][concepto]+"</td>"
                }
                else if(concepto.toLowerCase()=='fecha'){
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
        if(datos[i]["Cargo"]==0)
            tabla+='<td style="text-align:center;"><button type="button" class="btn bg-red waves-effect" onclick="javascript:quitarMovimiento('+ datos[i]["ID"] +')">'
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
function set_registro_clienteedocuenta(){
    var msg=validarForms_clienteedocuenta();
    if(msg==true){
    
        $.ajax({
    		url     : routes.urlJS+'/clientesedocuenta/set_edocuenta',
    		type    : 'POST',
    		dataType: 'JSON',
            data: {
    					clieprov: 1,
    					fecha       : moment($("#fecha input").val(),"DD/MM/YYYY").format("YYYY-MM-DD"),
                        cantidad    : $("#cantidad").val(),
                        movimiento  : 2,
                        concepto    : $("#concepto").val(),
    				},
    		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
    		success : function (data) { 
    		  
    			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
    			if (data['status'] == 'success')
    			{
    				/* Muestra jExcel con los datos recibidos */
    				CargarEdoCuenta_cliente();
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
 * Quitar
 * =========================================================================
 */

function quitarMovimiento($id){
    //desbloquear input de sweetalert
    fixBootstrapModal();
    
    Swal.fire({
          title: 'Eliminar movimiento',
          html: 'Escribe la palabra <b>eliminar</b> y posteriormente haz clic en el boton "Continuar"',
          input: 'text',
          inputAttributes: {
            autocapitalize: 'off'
          },
          showCancelButton: true,
          confirmButtonText: 'Continuar',
          showLoaderOnConfirm: false,
          allowOutsideClick: () => !Swal.isLoading(),
          onClose:function(){
            restoreBootstrapModal();
          },
        }).then((result) => {
          if (result.value.toLowerCase()=="eliminar") {
            $.ajax({
        		url     : routes.urlJS+'/clientesedocuenta/quitar_edocuenta',
        		type    : 'POST',
        		dataType: 'JSON',
                data: {
        					id: $id,
				},
        		/* Si no hay errores de comunicación retorna success, aun cuando existan errores de validacion o de BD */
        		success : function (data) { 
        		  
        			/* Si la nueva UM se guardó sin problemas se le notifica al usuario  */
        			if (data['status'] == 'success')
        			{
        				/* Muestra jExcel con los datos recibidos */
        				CargarEdoCuenta_cliente();
        			/* Si hubo algún error se muestra al usuario para su correción */
        			} else {
        				swal({
        					type : 'error',
        					title: 'Existen errores',
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
        })
}
/**=========================================================================
 * Validar controles
 * =========================================================================
 */

function validarForms_clienteedocuenta(){
    var msg="";
    if($("#frmMovimientos")[0].checkValidity()) {
        return true;
   	} 
    $("#frmMovimientos")[0].reportValidity();
    return false;
}

