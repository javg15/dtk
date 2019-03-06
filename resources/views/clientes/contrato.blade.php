<div class="modal fade modal-wide" id="contratos_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-lg">
			<div class="modal-header">

                <div class="col-sm-10 align-left">
				    <h5 class="modal-title">Contratos - {{  Session::get('clientes_idesc') }}</h5>
                </div>
                <div class="col-sm-1 align-right">
                  <button id="btnguardar" type="button" class="btn bg-green waves-effect" onclick="javascript:set_registro_contrato();">
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
                <form id="frmContratos" class="formpage">
                    <div class="row clearfix">
                        <div class="row clearfix">
                            <div class="col-sm-2">
                                <h5 class="form-label">Clave</h5>
                                <div class="form-group form-group-sm">
                                    <div class="input-group form-line">
                                        <input class="form-control" name="icode"  />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <h5 class="form-label">Concepto(*)</h5>
                                <div class="form-group form-group-sm">
                                    <div class="input-group form-line">
                                        <input class="form-control" name="idesc"   required=""/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        			<div class="row clearfix">
                        <div class="col-sm-2">
                            <h5 class="form-label">Fecha de inicio(*)</h5>
                            <div class="form-group form-group-sm">
                                <div class='input-group date form-line' id='fechainicio'>
                                    <input name="fechainicio" type='text' class="form-control date-input" required />
                                    <span class="input-group-addon">
                                        <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <h5 class="form-label">Parcialidades en meses (*)</h5>
                            <div class="form-group form-group-sm">
                                <div class="input-group form-line">
                                    <select id="numparcialidades" name="numparcialidades" class="selectpicker" required>
                                        <option value=""></option>
                                        <option value="6">6</option>
                                        <option value="12">12</option>
                                        <option value="18">18</option>
                                        <option value="24">24</option>
                                        <option value="36">36</option>
                                        <option value="36">48</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <h5 class="form-label">Total del contrato(*)</h5>
                            <div class="form-group form-group-sm">
                                <div class="input-group form-line">
                                    <input 
            							id          = "total"
            							name        = "total"
            							class       = "form-control input-md currency" 
            							type        = "number"
                                        min         = "0"
            							max         = "999999999.00"
                                        required
            						>
                                </div>
                            </div>
        				</div>
        				<div class="col-sm-2">
                            <h5 class="form-label">Anticipo(*)</h5>
                            <div class="form-group form-group-sm">
                                <div class="input-group form-line">
                                    <input 
            							id          = "anticipo"
            							name        = "anticipo"
            							class       = "form-control input-md" 
            							type        = "number"
                                        min         = "0"
            							max         = "999999999.00"
                                        
                                        required
            						>
                                </div>
                            </div>
        				</div>
                    </div>
                </form>
                        
                <div class="row clearfix">
                    <div class="sm-12">
                        <h3>Parcialidades</h3>
                    </div>
                </div>
                <div class="row clearfix">
                    <div class="sm-12">
                        <div id="tablacontrato" style="height: 32em;" class="tab-content">
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
<script>
        loadJSmain("{{ asset('js/clientes/contratoScript.js') }}");
</script>
	
