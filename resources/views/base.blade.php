<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- CSRF Token -->
	<meta name = "csrf-token" content = "{{ csrf_token() }}">
	<meta name = "app-name"   content = "{{ config('app.name') }}">

    <title>{{ config('app.name', 'Simulador') }}</title>
    <!-- Favicon-->
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <!--<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">-->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Raleway:200,300,400,600,700">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Bootstrap Core Css -->
    <link href="{{ asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="{{ asset('plugins/node-waves/waves.css') }}" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="{{ asset('plugins/animate-css/animate.css') }}" rel="stylesheet" />
	
    <!-- Bootstrap Select Css -->
    <link href="{{ asset('plugins/bootstrap-select/css/bootstrap-select.min.css') }}" rel="stylesheet">
    
    <!-- Datetime picker  -->
    <link href="{{ asset('plugins/eonasdan-datetimepicker/css/bootstrap-datetimepicker.css')}}"/>    
    
    <!-- Menu Css -->
    <link href="{{ asset('plugins/menu-hc-offcanvas-nav/hc-offcanvas-nav.css') }}" rel="stylesheet">
	
    <!-- Sweet alert-->
    <link href="{{ asset('plugins/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet">
    
	<!-- Menu Css -->
	<link href="{{ asset('css/style.css') }}" rel="stylesheet">
	

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="{{ asset('css/themes/all-themes.css') }}" rel="stylesheet" />
    <link href="{{ asset('css/menu.css') }}" rel="stylesheet">

	@yield('assets')
	
</head>
<body class="theme-red">
	@include('template.preloader')
	 <!-- Overlay For Sidebars -->
	<div class="overlay"></div>
		@include('template.searchBar')
		@include('template.navbar')
		<section>
			@include('template.leftSideBar')
		</section>
	<section class="content">
			@yield('content')
	</section>
	</div>
</body>
</html>

<!-- Jquery Core Js -->
    <script src="{{ asset('plugins/jquery/jquery-2.2.4.min.js') }}"></script>
	
	<!-- timeline -->
	<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.4/jquery-ui.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.js') }}"></script>

    <!-- Select Plugin Js -->
    <script src="{{ asset('plugins/bootstrap-select/js/bootstrap-select.js')}}"></script>

    <!-- Menu-->
    <script src="{{ asset('plugins/menu-hc-offcanvas-nav/hc-offcanvas-nav.js?ver=3.4.0')}}"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="{{ asset('plugins/node-waves/waves.js')}}"></script>

    <!-- Moment Js -->
    <script src="{{ asset('plugins/momentjs/moment-with-locales.min.js')}}"></script>
    
    <!-- formatear numeros -->
    <script src="{{ asset('plugins/momentjs/numeral.min.js') }}"></script>
    
    <!-- Datetime picker Js -->
    <script src="{{ asset('plugins/eonasdan-datetimepicker/js/bootstrap-datetimepicker.min.js')}}"></script>
    
    <!-- Sweet alert-->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js')}}"></script>    
    
    <!-- Block UI-->
    <script src="{{ asset('plugins/jquery-blockUI/jquery.blockUI.js')}}"></script>
	
    <!-- Custom Js -->
    <script src="{{ asset('js/admin.js')}}"></script>
    <script src="{{ asset('js/funcionesGlobales.js')}}"></script>
        
@include('componentes.js')
@yield('scripts')