<header>
	<div class="wrapper cf">

	  <nav id="main-nav">

		<ul class="first-nav">
          <li class="devices">
			@if(Auth::user()->rol=="admin")
            <a href="{{ route('main_content') }}?ruta=adminClientes">Clientes</a>
            <a href="{{ route('main_content') }}?ruta=saldosReportes">Reporte de saldos</a>
            <a href="{{ route('main_content') }}?ruta=pagosReportes">Reporte de pagos</a>
            @endif
            <a href="{{ route('main_content') }}?ruta=edocuentaReportes">Estado de cuenta</a>
		  </li>
		</ul>

	  </nav>

	</div>

</header>