<?php
require('dbconn.php'); // Include your database connection file
$title = "ULAF - Item Details | PixelPatch";
require("header.php");
require('fetch-userid.php'); // Ensure this file is correctly setting the session data
?>

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

		<!-- Header -->
		<header class="header header-fixed transparent">
			<div class="header-content">
				<div class="left-content">
					<a href="javascript:void(0);" class="back-btn">
						<i class="feather icon-arrow-left"></i>
					</a>
				</div>
				<div class="mid-content">
					<h4 class="title">Details</h4>
				</div>
				<div class="right-content d-flex align-items-center gap-4">
					<a href="javascript:void(0);" class="item-bookmark style-3">
						<i class="far fa-bookmark"></i>
						<i class="fas fa-bookmark"></i>
					</a>
				</div>
			</div>
		</header>
		<!-- Header -->

		<!-- Main Content Start -->
		<main class="page-content p-b80">
			<div class="container p-0">
				<div class="dz-product-preview bg-primary">
					<div class="swiper product-detail-swiper">
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<div class="dz-media">
									<img src="assets/images/products/detail/1.png" alt="">
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-media">
									<img src="assets/images/products/detail/2.png" alt="">
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-media">
									<img src="assets/images/products/detail/3.png" alt="">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="dz-product-detail">
					<div class="dz-handle"></div>
					<div class="detail-content">
						<h4 class="title">Ice Chocolate Coffee</h4>
						<p>“Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do</p>
					</div>
					<div class="dz-item-rating">4.5</div>
					<div class="item-wrapper">
						<div class="dz-range-slider">
							<div class="slider" id="slider-pips"></div>
						</div>
						<div class="dz-meta-items">
							<div class="dz-price flex-1">
								<div class="price"><sub>$</sub>5.8<del>$8.0</del></div>
							</div>
							<div class="dz-quantity">
								<div class="dz-stepper style-3">
									<input readonly class="stepper" type="text" value="3" name="demo3">
								</div>
							</div>
						</div>
						<div class="description">
							<p class="text-light">*)Dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore</p>
						</div>
					</div>
				</div>
			</div>
		</main>
		<!-- Main Content End -->

		<div class="footer fixed bg-white">
			<div class="container">
				<a href="cart.php" class="btn btn-primary btn-lg rounded-xl btn-thin w-100 gap-2">Place order <span class="opacity-25">$17.4</span></a>
			</div>
		</div>
	</div>
	<!--**********************************
    Scripts
***********************************-->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
	<script src="assets/vendor/nouislider/nouislider.min.js"></script>
	<script src="assets/vendor/wnumb/wNumb.js"></script>
	<script src="assets/js/noui-slider.init.js"></script>
	<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script src="assets/js/dz.carousel.js"></script>
	<script src="assets/js/settings.js"></script>
	<script src="assets/js/custom.js"></script>
</body>

</html>