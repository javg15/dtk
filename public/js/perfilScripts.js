 var renglonconceldasvacias=[];
 

$.ajaxSetup({
	headers: {
		'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
	}
});

$(document).ready(function(){
    
	$.ajax({
		url     : routes.urlJS+'/usuario/get_perfil',
		type    : 'POST',
		dataType: 'JSON',
		success : function (data) { 
			if (data['status'] == 'success')
			{
			     $("input[name='name']").val(data.data[0]["name"]);
                 $("input[name='email']").val(data.data[0]["email"]);
			     $("input[name='avatar'][value='"+data.data[0]["avatar"]+"']").prop('checked', true);
			} else {
				swal({
					type : 'error',
					title: 'Oops...',
					text : data.msg,
				});
			}	
		},
		error: function(data) {
			console.log(data)
		}
	});
});





/**======================================================================
 * Función para guardar los datos
 * @author JAVG
 * ======================================================================
 */
function Guardar(){
    	$.ajax({
    		url     : routes.urlJS+'/usuario/set_perfil',
            data    :{
                        "name":$("input[name='name']").val()
                        ,"email":$("input[name='email']").val()
                        ,"avatar":$("input[name='avatar']:checked").val()
                    },
    		type    : 'POST',
    		dataType: 'JSON',
    		success : function (data) { 
    			if (data['status'] == 'success')
    			{
    				
                    swal({
    					type : 'success',
                        title: 'Mensaje',
					    text : data.msg,
    					onClose: () => {
								/* Cierra el modal de crear categoría y limpia los inputs*/
								$("#imgAvatar").attr("src",routes.urlJS+"img/adminTemplate/"+$("input[name='avatar']:checked").val()+".png");
                                $(".profile-info .name").text($("input[name='name']").val())
							}
    				});
                    
                    

    			} else {
    				swal({
    					type : 'error',
    					title: 'Oops...',
    					text : data.msg,
    				});
    			}	
    		},
    		error: function(data) {
    			console.log(data)
    		}
    	});
    
}


/**=========================================================================
 * Regresar al menu de productos
 * =========================================================================
 */
function regresar(){
    window.location.href = routes.urlJS+"/home";
}