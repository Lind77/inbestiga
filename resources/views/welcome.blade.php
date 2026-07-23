<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Avantage - 2024</title>
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

	<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

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
	  <script src="{{asset('/vendor/js/helpers.js')}}"></script>
  
	  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
	  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
	  <script src="{{asset('/js/config.js')}}"></script>
		
	  
		<style>
			body{
				overflow-x: hidden;
			}
		</style>
		@vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
	<body>	
		<div id="preloader" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: #121216; display: flex; align-items: center; justify-content: center; z-index: 99999; transition: opacity 0.4s ease, visibility 0.4s ease;">
			<div class="loader-content" style="text-align: center;">
				<img src="/img/logo_ag.png" alt="AVANTAGE" height="65" style="animation: pulse 1.5s infinite ease-in-out; margin: 0 auto; display: block; object-fit: contain;" />
				<div style="color: #FFFFFF; font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 600; letter-spacing: 3px; margin-top: 20px; text-transform: uppercase;">AVANTAGE GROUP</div>
			</div>
		</div>
		<style>
			@keyframes pulse {
				0%, 100% { transform: scale(0.9); opacity: 0.6; }
				50% { transform: scale(1.1); opacity: 1; }
			}
			.loader-fade-out {
				opacity: 0 !important;
				visibility: hidden !important;
			}
		</style>
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
	<script src="{{asset('/js/ui-popover.js')}}"></script>
    <!-- Place this tag in your head or just before your close body tag. -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>
	<script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js" async></script>
	<script>
		window.Laravel = {
			csrfToken: "{{ csrf_token() }}"
		}
	</script>
	<script>
		(function() {
			var preloader = document.getElementById('preloader');
			Promise.all([
				new Promise(function(resolve) {
					if (document.readyState === 'complete') {
						resolve();
					} else {
						window.addEventListener('load', resolve);
					}
				}),
				document.fonts.ready
			]).then(function() {
				setTimeout(function() {
					if (preloader) {
						preloader.classList.add('loader-fade-out');
						setTimeout(function() {
							preloader.remove();
						}, 400);
					}
				}, 200);
			});
		})();
	</script>
</body>
</html>