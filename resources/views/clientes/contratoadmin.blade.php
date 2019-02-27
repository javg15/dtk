<div class="modal fade modal-wide" id="contratosadmin_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-lg">
			<div class="modal-header">
                <div class="col-sm-10 align-left">
				    <h5 class="modal-title">Contratos - {{  Session::get('clientes_idesc') }}</h5>
                </div>
                <div class="col-sm-1 align-right">
                  <button id="btnguardar" type="button" class="btn bg-green waves-effect" onclick="javascript:set_registro_cliente();">
                    <i class="material-icons">save</i>
                    <span>Guardar</span>
                  </button>
                </div>
                <div class="col-sm-1 align-right">
    				<button type="button" class="btn bg-orange waves-effect" data-dismiss="modal" aria-label="Close">
    					<span aria-hidden="true">Cerrar</span>
    				</button>
                </div>
			</div>
			<div class="modal-body">
            	<div class="card">
            		<div class="body">
                        <div class="row clearfix">
                            <div class="sm-12">
                                <table id='tablaadmin_contratoadmin' class='table table-striped table-responsive modal-body pre-scrollable table-bordered no-footer' border="1">
                                </table>
                            </div>
                        </div>
            		</div>
            	</div>
             </div>
        </div>
    </div>
</div>



<script>
    /** 
    * Se ejecuta en main_content.blade.php
    */
    loadJSmain("{{ asset('js/clientes/contratoadminScript.js') }}");
</script>	
	
