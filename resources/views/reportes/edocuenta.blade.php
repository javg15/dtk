            	<div class="card">
            		<div class="body">
                        <div class="row clearfix">
                            <div class="sm-12">
                                <h3>Estado de cuenta</h3>
                            </div>                     
                        </div>
                        <form id="frmClientes">
                           	<div class="row clearfix">
                                <div class="col-sm-2">
                                    <h5 class="form-label">Cliente</h5>
                                    <div class="form-group">
                                        <div class='input-group form-line'>
                                            <select id="id_cliente" class="form-control" required >
                                                <option value=""></option>
                                                @foreach($clientes as $cliente)
                                                    <option value="{{ $cliente->id }}">{{ $cliente->idesc }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <h5 class="form-label">Contratos</h5>
                                    <div class="form-group">
                                        <div class='input-group form-line'>
                                            <select id="id_contrato" class="form-control" required >
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-1 align-right">
                                  <button id="btnmostrar" type="button" class="btn bg-green waves-effect" >
                                    <i class="material-icons">search</i>
                                    <span>Mostrar</span>
                                  </button>
                                </div>
                            </div>
                        </div>
                        <div class="row clearfix">
                            <div class="sm-12">
                                <table id='tablareporte' class='table table-striped table-responsive modal-body pre-scrollable table-bordered no-footer' border="1">
                                </table>
                            </div>
                        </div>
            		</div>
            	</div>

<script>
    /** 
    * Se ejecuta en main_content.blade.php
    */
    loadJSmain("{{ asset('js/reportes/edocuentaScript.js') }}");
</script>	
	
