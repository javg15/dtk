@extends('base')

@section('assets')
@endsection

@section('content')
	<div class="card">

		<div class="body">
            <div class="row">
				<div class="sm-12 align-right" id="divBtnSiguiente">
					<ul class="toolbar-form">
           				<li>
        					<button type="button" class="btn bg-blue waves-effect" onclick="javascript:regresar();">
        						<i class="material-icons">arrow_back</i>
        						<span>{{ __('Regresar') }}</span>
        					</button>
        				</li>
        			</ul>
				</div>
			</div>
            <div class="row clearfix">
                <div class="sm-12">
                    <h3>Registro de movimientos - {{  Session::get('idesc_clieprov') }}</h3>
                </div>                     
            </div>
            <div class="panel-group full-body" id="accordion_19" role="tablist" aria-multiselectable="true">
                <div class="panel panel-col-orange">
                    <div class="panel-heading" role="tab" id="headingOne_19">
                        <h4 class="panel-title">
                            <a role="button" data-toggle="collapse" href="#collapseOne_19" aria-expanded="true" aria-controls="collapseOne_19" class="">
                                <i class="material-icons">add</i> Agregar movimientos
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne_19" class="panel-collapse collapse " role="tabpanel" aria-labelledby="headingOne_19" aria-expanded="false" style="">
                        <div class="panel-body">
                            <form id="frmMovimientos" class="formpage">
                    			<div class="row clearfix">
                                    <div class="col-sm-1 align-right">
                    					<label class="form-label">Fecha:</label>
                    				</div>
                                    <div  class="col-sm-2 align-left">
                                        <div class="form-group">
                                            <div class='input-group date form-line' id='fecha'>
                                                <input type='text' class="form-control" required />
                                                <span class="input-group-addon">
                                                    <span class="glyphicon glyphicon-calendar"></span>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                    				<div class="col-sm-1 align-right">
                    					<label class="form-label">Movimiento:</label>
                    				</div>
                                    <div  class="col-sm-2 align-left">
                                       <div class="form-group form-float">
                        					<select id="movimiento" class="selectpicker" required>
                                                <option value=""></option>
                                                <option value="1">Cargo</option>
                                                <option value="2">Abono</option>
                                            </select>
                        				</div>
                                    </div>
                    
                    				<div class="col-sm-1 align-right">
                    					<label class="form-label">Cantidad:</label>
                    				</div>
                                    <div  class="col-sm-2 align-left">
                                       <div class="form-group form-float">
                        					<div class="form-line">
                        						<input 
                        							id          = "cantidad"
                        							name        = "cantidad"
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
                                <div class="row clearfix">
                                    <div class="col-sm-1 align-right">
                    					<label class="form-label">Concepto:</label>
                    				</div>
                                    <div  class="col-sm-4 align-left">
                                        <div class="form-group">
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
                                    <div  class="col-sm-2 align-left">
                                    </div>
                                    <div  class="col-sm-2 align-left">
                                        <button id="btnguardar" type="button" class="btn bg-green waves-effect" onclick="javascript:setMovimiento();">
                    						<i class="material-icons">save</i>
                    						<span>{{ __('Guardar') }}</span>
                    					</button>
                                    </div>
                                </div>
                            </form>
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
                <div class="sm-12">
                    <h3>Saldo al día:&nbsp;<span style="color: blue;" id="saldofinal">$ 0.00</span></h3>
                </div>
            </div>
            <div class="row clearfix">
                <div class="sm-12">
                    <div id="tab-content" style="height: 32em;" class="tab-content">
                    </div>
                </div>
            </div>
		</div>
	</div>
	
@endsection

@section('scripts')
	<script src="{{ asset('js/clientesScript.js') }}"></script>
@endsection