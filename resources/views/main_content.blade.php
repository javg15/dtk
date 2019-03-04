@extends('base')

@section('assets')
<style>
    @media (min-width: 768px){
        .modal-dialog {
            margin: 10px;
            overflow-y: initial !important
        }
        
        .modal-body{
            overflow-y: auto;
        }
    }
    
    .bootstrap-select.btn-group .dropdown-toggle .caret {
        position: absolute;
        top: 50%;
        right: 0px; 
        margin-top: -2px;
        vertical-align: middle;
    }
</style>
@endsection

@section('content')
	<div class="card" id="main_content_div">
        <!--this part will change-->
    </div>
	
@endsection

@section('scripts')
@include('template.jsDataTable')
<script>
    
    
    $(document).ready(function(){
        load_main_content({!! json_encode($ruta, JSON_HEX_TAG) !!});
        
        $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
        });
        
        
    });
    
    function load_main_content(ruta)
    {
        /** ?modal=1, siempre va a estar presente este parametro aquí
        * Significa que cuando se abre como principal, entonces, se omiten los <div> modales 
        */
        $('#main_content_div').load(ruta+'/?modal=1'); 
    }
    
    /** 
    * Se ejecuta desde los .blade.php
    */
    function loadCSSmain(file) {
        
        // DOM: Create the script element
        var cssElm = document.createElement("link");
        cssElm.rel="stylesheet",
        // set the type attribute
        cssElm.type = "text/css";
        // make the script element load file
        cssElm.href = file;
        // finally insert the element to the body element in order to load the script
        document.head.appendChild(cssElm);
    }
    
    function loadJSmain(file) {
        // DOM: Create the script element
        var jsElm = document.createElement("script");
        // set the type attribute
        jsElm.type = "application/javascript";
        // make the script element load file
        jsElm.src = file;
        // finally insert the element to the body element in order to load the script
        document.body.appendChild(jsElm);
    }
    
    function addJSmain(ruta,id_modal,callback) {
        $.ajax({ 
            type: "GET",   
            url: ruta,   
            success : function(text)
            {
                $('#main_content_div').remove(id_modal);
                $('#main_content_div').prepend(text);
                 
                /** 
                * Modulos ligados, Ej. Clientes
                */
                $(id_modal+".modal-wide").on("show.bs.modal", function() {
                    //Altura del contenido
                    var height = $(window).height() - 100;
                    $(this).find(".modal-body").css("max-height", height);
                    
                    //Ancho de la ventana
                    var width = $(window).width() - 20;
                    $(this).find(".modal-content").css("width", width);
                    
                    $(document).off('focusin.modal');
                });
                
                $(id_modal).on("hidden.bs.modal", function() {
                    //Destruir modal
                    $(this).data('bs.modal', null);
                    $(this).remove();
                    if (typeof callback == 'function') {
                        callback();
                    }
                });
                
                /* Abrir el modal
                */
                $(id_modal).modal({
                    backdrop: 'static',
                    keyboard: false,
                    toggle  : "modal"
                });
                $(id_modal).modal('show');
            }
        })
    }

</script>

@endsection