
<div class="modal fade modal-wide" id="clienteedocuenta_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-lg">
			<div class="modal-header">
                <div class="col-sm-10 align-left">
				    <h5 class="modal-title">Movimiento de Contrato - {{  Session::get('contratos_idesc') }}</h5>
                </div>
                <div class="col-sm-1 align-right">
                  <button id="btnguardar" type="button" class="btn bg-green waves-effect" onclick="javascript:set_registro_clienteedocuenta();">
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
                <form id="frmMovimientos" class="formpage">
        			<div class="row clearfix">
                        <div class="col-sm-2">
                            <h5 class="form-label">Fecha(*)</h5>
                            <div class="form-group">
                                <div class='input-group date form-line' id='fecha'>
                                    <input type='text' class="form-control" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        
        
        				<div class="col-sm-2 ">
        					<h5 class="form-label">Cantidad(*)</h5>
                            <div class="form-group form-float">
            					<div class="form-line">
            						<input 
            							id          = "cantidad"
            							name        = "cantidad"
            							class       = "form-control input-md" 
            							type        = "number"
                                        min         = "0"
            							max         = "999999999.00"
                                        step        ="0.01"
                                        required
            						>
            					</div>
            				</div>
        				</div>
                        <div class="col-sm-4 ">
        					<h5 class="form-label">Concepto(*)</h5>
                            <div class="form-group form-float">
            					<div class="form-line">
            						<input 
            							id          = "concepto"
            							name        = "concepto"
            							class       = "form-control input-md" 
            							type        = "text"
                                        required
            						>
            					</div>
            				</div>
        				</div>
                    </div>
                    <div class="row clearfix">
                        <div class="sm-12">
                            <h3>Estado de cuenta</h3>
                        </div>
                    </div>
                    <br />
                    <div class="row clearfix">
                        <div class="form-group">
                            <div class="col-sm-6">
                                <label>Saldo pendiente al día:&nbsp;<span style="color: blue;" id="saldopendiente">$ 0.00</span></label>
                            </div>
                            <div class="col-sm-6">
                                <label>Saldo total:&nbsp;<span style="color: blue;" id="saldofinal">$ 0.00</span></label>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="sm-12">
                            <div id="tablaedocuenta" style="height: 32em;" class="tab-content">
                            </div>
                        </div>
                    </div>
                </form>
             </div>
        </div>
    </div>
</div>
	
<script>
        loadCSSmain("{{ asset('css/clientes/clienteedocuenta.css') }}");
        loadJSmain("{{ asset('js/clientes/clienteedocuentaScript.js') }}");
</script>

