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
		@vite('resources/css/app.css')
</head>
	<body>	
		<div id="preloader" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; background-color: #121216; display: flex; align-items: center; justify-content: center; z-index: 99999; transition: opacity 0.4s ease, visibility 0.4s ease;">
			<div class="loader-content" style="text-align: center;">
				<svg width="60" height="60" viewBox="0 0 25 42" version="1.1" xmlns="http://www.w3.org/2000/svg" style="animation: pulse 1.5s infinite ease-in-out; margin: 0 auto;">
					<defs>
						<path d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z" id="path-1"></path>
					</defs>
					<use fill="#1D5EFF" xlink:href="#path-1"></use>
				</svg>
				<div style="color: #FFFFFF; font-family: 'Montserrat', sans-serif; font-size: 0.95rem; font-weight: 600; letter-spacing: 3px; margin-top: 20px; text-transform: uppercase;">AVANTAGE</div>
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
	@vite('resources/js/app.js')	
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