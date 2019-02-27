@if (app('request')->input('modal')!="1")
<div class="modal fade modal-wide" id="clientesadmin_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-lg">
			<div class="modal-header">
				<h5 class="modal-title">Registro de movimientos - {{  Session::get('idesc_clieprov') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
@endif
            	<div class="card">
            		<div class="body">
                        <div class="row clearfix">
                            <div class="sm-12">
                                <h3>Clientes</h3>
                            </div>                     
                        </div>
                        <br /><br /><br />
                        <div class="row clearfix">
                            <div class="sm-12">
                                <table id='tablaadmin_clienteadmin' class='table table-striped table-responsive modal-body pre-scrollable table-bordered no-footer' border="1">
                                </table>
                            </div>
                        </div>
            		</div>
            	</div>
@if (app('request')->input('modal')!="1")                
             </div>
        </div>
    </div>
</div>
@endif


<script>
    /** 
    * Se ejecuta en main_content.blade.php
    */
    loadJSmain("{{ asset('js/clientes/clienteadminScript.js') }}");
</script>	
	
