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
                    <h3>Registro de movimientos</h3>
                </div>                     
            </div>
            <br /><br /><br />
			<div class="row clearfix">
                <div class="col-sm-1 align-right">
					<label class="form-label">Fecha:</label>
				</div>
                <div  class="col-sm-2 align-left">
                    <div class="form-group">
                        <div class='input-group date form-line' id='fecha'>
                            <input type='text' class="form-control" />
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
    					<select id="movimiento" class="selectpicker">
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
    							step        = "100.00"
    							max         = "1000000.00"
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
    							id          = "idesc"
    							name        = "idesc"
    							class       = "form-control input-md" 
    							type        = "text"
    						>
    					</div>
                    </div>
                </div>
                <div  class="col-sm-2 align-left">
                </div>
                <div  class="col-sm-2 align-left">
                    <button type="button" class="btn bg-blue waves-effect" onclick="javascript:setMovimiento();">
						<i class="material-icons">save</i>
						<span>{{ __('Guardar') }}</span>
					</button>
                </div>
            </div>
            <br />
            <div class="row clearfix">
                <div class="sm-12">
                    <h3>Estado de cuenta</h3>
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