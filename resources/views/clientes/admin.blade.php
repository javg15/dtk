@extends('base')

@section('assets')
@endsection

@section('content')
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
                    <table id='tablaadmin' class='table table-striped table-responsive modal-body pre-scrollable table-bordered no-footer' border="1">
                    </table>
                </div>
            </div>
		</div>
	</div>
	
@endsection

@section('scripts')
@include('template.jsDataTable')
	<script src="{{ asset('js/clientesAdminScript.js') }}"></script>
@endsection