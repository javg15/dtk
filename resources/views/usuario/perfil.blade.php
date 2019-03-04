@extends('base')

@section('assets')
	<link href="{{ asset('css/jExcel/jquery.jcalendar.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jdropdown.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.bootstrap.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.css') }}" rel="stylesheet">
	<link href="{{ asset('css/jExcel/jquery.jexcel.green.css') }}" rel="stylesheet">
@endsection

@section('content')
	<div class="card">
		<div class="header bg-green">
			<h2>
				Perfil de usuario
			</h2>
		</div>
		<div class="body">
            <div class="row">
				<div class="sm-12 align-right" id="divBtnSiguiente">
					<ul class="toolbar-form">
                        <li>
            				<button type="button" class="btn bg-blue waves-effect" onclick="javascript:Guardar();">
        						<i class="material-icons">save</i>
        						<span>Guardar</span>
        					</button>
            			</li>
        			</ul>
				</div>
			</div>
			<div class="row clearfix">
				<div class="col-sm-4 align-right">
					<label class="form-label">Nombre:</label>
				</div>
                <div  class="col-sm-6 align-right">
                    <div class="form-group form-float">
						<div class="form-line">
							<input 
								id          = "name"
								name        = "name"
								class       = "form-control input-md" 
								type        = "text"
							>
						</div>
					</div>
                </div>
            </div>
            <div class="row clearfix">
				<div class="col-sm-4 align-right">
					<label class="form-label">Correo electrónico:</label>
				</div>
                <div  class="col-sm-6 align-right">
                    <div class="form-group form-float">
						<div class="form-line">
							<input 
								id          = "email"
								name        = "email"
								class       = "form-control input-md" 
								type        = "text"
                                readonly
							>
						</div>
					</div>
                </div>
            </div>
		</div>
	</div>
	
@endsection

@section('scripts')
	<script src="{{ asset('js/perfilScripts.js') }}"></script>
@endsection