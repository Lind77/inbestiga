<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Inbestiga</title>
	<!-- Favicon -->
	<link rel="icon" type="image/x-icon" href="{{asset('img/favicon/favicon.ico')}}" />
	<!-- Fonts -->
	<link rel="preconnect" href="https://fonts.googleapis.com" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
	<link
	href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
	rel="stylesheet"
	crossorigin="anonymous"
	/>

	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" crossorigin="anonymous">
	
	 <!-- Icons. Uncomment required icon fonts -->
	 <link rel="stylesheet" href="{{asset('vendor/fonts/boxicons.css')}}" />
	  <!-- Core CSS -->
	  <link rel="stylesheet" href="{{asset('vendor/css/core.css')}}" class="template-customizer-core-css" />
	  <link rel="stylesheet" href="{{asset('vendor/css/theme-default.css')}}" class="template-customizer-theme-css" />
	  <link rel="stylesheet" href="{{asset('css/demo.css')}}" />
	

	  <link rel="stylesheet" href="{{asset('vendor/css/pages/page-auth.css')}}" />
	  <!-- Vendors CSS -->
	  <link rel="stylesheet" href="{{asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.css')}}" />
		
	  <!-- Page CSS -->
  
	  <!-- Helpers -->
	  <script src="{{asset('vendor/js/helpers.js')}}"></script>
  
	  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
	  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
	  <script src="{{asset('js/config.js')}}"></script>
		
	  @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
	<body>	
	<div id="app"></div>	
    <!-- build:js assets/vendor/js/core.js -->
	<script src="{{asset('vendor/libs/jquery/jquery.js')}}"></script>
    <script src="{{asset('vendor/libs/popper/popper.js')}}"></script>
    <script src="{{asset('vendor/js/bootstrap.js')}}"></script>
    <script src="{{asset('vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>
    <script src="{{asset('vendor/js/menu.js')}}"></script>
    <!-- endbuild -->

    <!-- Vendors JS -->
	
    <!-- Main JS -->
    <script src="{{asset('js/main.js')}}"></script>

    <!-- Page JS -->
	<script src="{{asset('js/ui-popover.js')}}"></script>
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
	<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
	<script>
		window.Laravel = {
			csrfToken: "{{ csrf_token() }}"
		}
	</script>
</body>
</html>