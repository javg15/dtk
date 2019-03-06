<div class="modal fade modal-wide" id="clientes_modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-lg">
			<div class="modal-header">
                <div class="col-sm-10 align-left">
				    <h5 class="modal-title">Cliente - {{  Session::get('clientes_idesc') }}</h5>
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
                <form id="frmClientes"
                data-bv-feedbackicons-valid="glyphicon glyphicon-ok"
                data-bv-feedbackicons-invalid="glyphicon glyphicon-remove"
                data-bv-feedbackicons-validating="glyphicon glyphicon-refresh"
                >
                    <div class="row clearfix">
                        <div class="col-sm-2">
                            <h5 class="form-label">Clave</h5>
                            <div class="form-group form-group-sm">
                                <div class="input-group form-line">
                                    <input class="form-control" name="icode"  />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <h5 class="form-label">RFC</h5>
                            <div class="form-group form-group-sm">
                                <div class="input-group form-line">
                                    <input class="form-control" name="rfc"  />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h5 class="form-label">Nombre(*)</h5>
                            <div class="form-group form-group-sm">
                                <div class="input-group form-line">
                                    <input class="form-control" name="idesc"   required=""/>
                                </div>
                            </div>
                        </div>
                    </div>
        			<div class="row clearfix">
                        
                        <div class="col-sm-6">
                            <h5 class="form-label">Dirección</h5>
                            <div class="form-group form-group-sm">
                                <div class="input-group form-line">
                                    <input class="form-control" name="calle"  />
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row clearfix">
                        <div class="col-sm-4">
                                <input type="checkbox" id="crearcuenta" name="crearcuenta" class="filled-in">
                                <label for="crearcuenta">¿Editar cuenta de acceso?</label>
                        </div>
                    </div>
                    <div class="row clearfix" id="divcuentas">
                        <div class="col-sm-4">
                            <h5 class="form-label">Cuenta de correo(*)</h5>
                            <div class="form-group form-group-sm">
                                <div class="input-group form-line">
                                    <input class="form-control" name="email"
                                        data-bv-callback="true"
                                        data-bv-callback-message="Dato requerido"
                                        data-bv-callback-callback="checkUser"  
                                        />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <h5 class="form-label">Contraseña(*)</h5>
                            <div class="form-group form-group-sm">
                                <div class="input-group form-line">
                                    <input class="form-control" name="password" type="password"
                                        data-bv-callback="true"
                                        data-bv-callback-message="Dato requerido y mayor a 6 caracteres"
                                        data-bv-callback-callback="checkPassword"  
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                        
            </div>
		</div>
	</div>
</div>
<script>
        loadJSmain("{{ asset('js/clientes/clienteScript.js') }}");
</script>
	
