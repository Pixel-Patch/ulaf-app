<?php $title = "ULAF - Welcome | PixelPatch";

require("head.php"); ?>

</head>

<body>
	<div class="page-wrapper">

		<!-- Preloader -->
		<div id="preloader">
			<div class="loader">
				<div class="spinner-border text-primary" role="status">
					<span class="visually-hidden">Loading...</span>
				</div>
			</div>
		</div>
		<!-- Preloader end-->

		<!-- Welcome Start -->
		<main class="page-content">
			<div class="container py-0">
				<div class="welcome-area row">
					<div class="welcome-inner-2 col" style="background-image: url('assets/images/background/bg3.png'); background-size: cover; background-repeat: no-repeat;">
						<div class="main-wrapper">
							<div class="main-logo">
								<div class="logo-icon">
									<img src="assets/images/coffe-cup.png" alt="logo">
								</div>
							</div>
						</div>
						<div class="dz-button-group">
							<h3 class="title">Morning begins with <br> Ombe coffee</h3>
							<a href="sign-in.php" class="btn btn-primary btn-social btn-thin rounded-xl btn-lg w-100"><img src="assets/images/social/inbox.png" alt=""><span>Login With Email</span></a>
							<!-- <a href="sign-in.php" class="btn btn-facebook btn-primary btn-social btn-thin rounded-xl btn-lg w-100"><img src="assets/images/social/facebook.png" alt=""><span>Login with facebook</span></a>
							<a href="sign-in.php" class="btn btn-white btn-social btn-thin rounded-xl btn-lg w-100"><img src="assets/images/social/google-mail.png" alt=""><span class="text-dark">Login with Google</span></a> -->
						</div>
					</div>
				</div>
			</div>
		</main>
		<!-- Welcome End -->

	</div>
	<!--**********************************
    Scripts
***********************************-->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/swiper/swiper-bundle.min.js"></script><!-- Swiper -->
	<script src="assets/js/dz.carousel.js"></script><!-- Swiper -->
	<script src="assets/vendor/wow/dist/wow.min.js"></script>
	<script src="assets/js/settings.js"></script>
	<script src="assets/js/custom.js"></script>
	<script>
		new WOW().init();

		var wow = new WOW({
			boxClass: 'wow', // animated element css class (default is wow)
			animateClass: 'animated', // animation css class (default is animated)
			offset: 50, // distance to the element when triggering the animation (default is 0)
			mobile: false // trigger animations on mobile devices (true is default)
		});
		wow.init();
	</script>
</body>

</html>