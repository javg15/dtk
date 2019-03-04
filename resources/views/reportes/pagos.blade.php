            	<div class="card">
            		<div class="body">
                        <div class="row clearfix">
                            <div class="sm-12">
                                <h3>Reporte de pagos</h3>
                            </div>                     
                        </div>
                       	<div class="row clearfix">
                            <div class="col-sm-2">
                                <h5 class="form-label">Fecha de inicio</h5>
                                <div class="form-group">
                                    <div class='input-group date form-line' id='fechainicio'>
                                        <input type='text' class="form-control" required />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <h5 class="form-label">Fecha de corte</h5>
                                <div class="form-group">
                                    <div class='input-group date form-line' id='fechacorte'>
                                        <input type='text' class="form-control" required />
                                        <span class="input-group-addon">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-1 align-right">
                              <button id="btnmostrar" type="button" class="btn bg-green waves-effect" onclick="javascript:cargar_reporte();">
                                <i class="material-icons">search</i>
                                <span>Mostrar</span>
                              </button>
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
    loadJSmain("{{ asset('js/reportes/pagosScript.js') }}");
</script>	
	
