<?php $title = "ULAF - Item Page | PixelPatch";
require("header.php"); ?>
<style>
	.mySwiper {
		position: -webkit-sticky;
		/* For Safari */
		position: sticky;
		top: 0;
		z-index: 1000;
		background-color: white;
		/* Ensure background is solid to overlay content */
		border-bottom: 1px solid #ccc;
		/* Optional: to add a border for better visibility */
	}

	.dz-categories-bx.active {
		border: 2px solid darkgreen;
		/* Green border for active category */
	}

	.dz-categories-bx .title.active-title a {
		color: #04764e;
		/* Custom green color for active title */
	}

	.m-b20 {
		margin-bottom: -10px;
	}
</style>


</head>

<body>
	<div class="page-wrapper">

		<!-- Preloader -->
		<?php include "pre-loader.php"; ?>
		<!-- Preloader end-->

		<!-- Header -->
		<header class="header header-fixed">
			<div class="header-content">
				<div class="left-content">
					<a href="index.php" class="back-btn">
						<i class="feather icon-arrow-left"></i>
					</a>
				</div>
				<div class="mid-content">
					<h4 class="title">Items</h4>
				</div>
				<div class="right-content d-flex align-items-center gap-4">
					<a href="javascript:void(0);" class="font-24">
						<i class="font-w700 feather icon-more-vertical-"></i>
					</a>
				</div>
			</div>
		</header>
		<!-- Header -->

		<!-- Main Content Start -->
		<main class="page-content space-top">
			<div class="container">
				<!-- SearchBox -->
				<div class="search-box">
					<div class="input-group input-radius input-rounded input-lg">
						<input type="search" placeholder="Search beverages or foods" class="form-control">
						<span class="input-group-text">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M9.65925 19.3102C11.8044 19.3103 13.8882 18.5946 15.5806 17.2764L21.9653 23.6612C22.4423 24.1218 23.2023 24.1086 23.663 23.6316C24.1123 23.1664 24.1123 22.4288 23.663 21.9635L17.2782 15.5788C20.5491 11.3682 19.7874 5.30333 15.5769 2.03243C11.3663 -1.23848 5.30149 -0.476799 2.03058 3.73374C-1.24033 7.94428 -0.478646 14.0092 3.73189 17.2801C5.42702 18.5969 7.51269 19.3113 9.65925 19.3102ZM4.52915 4.5273C7.36245 1.69394 11.9561 1.69389 14.7895 4.5272C17.6229 7.3605 17.6229 11.9542 14.7896 14.7876C11.9563 17.6209 7.36261 17.621 4.52925 14.7877C4.5292 14.7876 4.5292 14.7876 4.52915 14.7876C1.69584 11.9749 1.67915 7.39794 4.49181 4.56464C4.50424 4.55216 4.51667 4.53973 4.52915 4.5273Z" fill="#C9C9C9" />
							</svg>
						</span>
					</div>
				</div>
				<!-- SearchBox -->

				<!-- Categories Swiper -->
				<div class="title-bar mb-0">
					<h5 class="title">Categories</h5>
				</div>
				<div class="swiper categories-swiper dz-swiper m-b20">
					<div class="swiper-wrapper">
						<div class="swiper-slide">
							<div class="dz-categories-bx" onclick="makeActive(this)">
								<div class="icon-bx">
									<a href="#electronics">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
											<path d="M20 17.722c.595-.347 1-.985 1-1.722V5c0-1.103-.897-2-2-2H5c-1.103 0-2 .897-2 2v11c0 .736.405 1.375 1 1.722V18H2v2h20v-2h-2v-.278zM5 16V5h14l.002 11H5z"></path>
										</svg>
									</a>
								</div>
								<div class="dz-content">
									<h6 class="title"><a href="#electronics">Electronics</a></h6>
									<span class="menus text-primary">67 Items</span>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-categories-bx" onclick="makeActive(this)">
								<div class="icon-bx">
									<a href="#personal-items">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
											<path d="M16 12h2v4h-2z"></path>
											<path d="M20 7V5c0-1.103-.897-2-2-2H5C3.346 3 2 4.346 2 6v12c0 2.201 1.794 3 3 3h15c1.103 0 2-.897 2-2V9c0-1.103-.897-2-2-2zM5 5h13v2H5a1.001 1.001 0 0 1 0-2zm15 14H5.012C4.55 18.988 4 18.805 4 18V8.815c.314.113.647.185 1 .185h15v10z"></path>
										</svg>
									</a>
								</div>
								<div class="dz-content">
									<h6 class="title"><a href="#personal-items">Personal Items</a></h6>
									<span class="menus text-primary">25 Items</span>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-categories-bx" onclick="makeActive(this)">
								<div class="icon-bx">
									<a href="#clothing-shoes">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
											<path d="M21.316 4.055C19.556 3.478 15 1.985 15 2a3 3 0 1 1-6 0c0-.015-4.556 1.478-6.317 2.055A.992.992 0 0 0 2 5.003v3.716a1 1 0 0 0 1.242.97L6 9v12a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1V9l2.758.689A1 1 0 0 0 22 8.719V5.003a.992.992 0 0 0-.684-.948z"></path>
										</svg>
									</a>
								</div>
								<div class="dz-content">
									<h6 class="title"><a href="#clothing-shoes">Clothing & Shoes</a></h6>
									<span class="menus text-primary">43 Items</span>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-categories-bx" onclick="makeActive(this)">
								<div class="icon-bx">
									<a href="#books-stationery">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
											<path d="M21 3h-7a2.98 2.98 0 0 0-2 .78A2.98 2.98 0 0 0 10 3H3a1 1 0 0 0-1 1v15a1 1 0 0 0 1 1h5.758a2.01 2.01 0 0 1 1.414.586l1.121 1.121c.009.009.021.012.03.021.086.08.182.15.294.196h.002a.996.996 0 0 0 .762 0h.002c.112-.046.208-.117.294-.196.009-.009.021-.012.03-.021l1.121-1.121A2.01 2.01 0 0 1 15.242 20H21a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 15h-4.758a4.03 4.03 0 0 0-2.242.689V6c0-.551.448-1 1-1h6v13z"></path>
										</svg>
									</a>
								</div>
								<div class="dz-content">
									<h6 class="title"><a href="#books-stationery">Books and Stationery</a></h6>
									<span class="menus text-primary">32 Items</span>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-categories-bx" onclick="makeActive(this)">
								<div class="icon-bx">
									<a href="#flasks-accessories">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
											<path d="M12 22c4.636 0 8-3.468 8-8.246C20 7.522 12.882 2.4 12.579 2.185a1 1 0 0 0-1.156-.001C11.12 2.397 4 7.503 4 13.75 4 18.53 7.364 22 12 22zm-.001-17.74C13.604 5.55 18 9.474 18 13.754 18 17.432 15.532 20 12 20s-6-2.57-6-6.25c0-4.29 4.394-8.203 5.999-9.49z"></path>
										</svg>
									</a>
								</div>
								<div class="dz-content">
									<h6 class="title"><a href="#flasks-accessories">Flasks & Accessories</a></h6>
									<span class="menus text-primary">18 Items</span>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-categories-bx" onclick="makeActive(this)">
								<div class="icon-bx">
									<a href="#bags-backpacks">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
											<path d="M4 20h2V10a1 1 0 0 1 1-1h12V7a1 1 0 0 0-1-1h-3.051c-.252-2.244-2.139-4-4.449-4S6.303 3.756 6.051 6H3a1 1 0 0 0-1 1v11a2 2 0 0 0 2 2zm6.5-16c1.207 0 2.218.86 2.45 2h-4.9c.232-1.14 1.243-2 2.45-2z"></path>
											<path d="M21 11H9a1 1 0 0 0-1 1v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8a1 1 0 0 0-1-1zm-6 7c-2.757 0-5-2.243-5-5h2c0 1.654 1.346 3 3 3s3-1.346 3-3h2c0 2.757-2.243 5-5 5z"></path>
										</svg>
									</a>
								</div>
								<div class="dz-content">
									<h6 class="title"><a href="#bags-backpacks">Bags and Backpacks</a></h6>
									<span class="menus text-primary">56 Items</span>
								</div>
							</div>
						</div>
						<div class="swiper-slide">
							<div class="dz-categories-bx" onclick="makeActive(this)">
								<div class="icon-bx">
									<a href="#miscellaneous">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
											<path d="M7 22a4.965 4.965 0 0 0 3.535-1.465l9.193-9.193.707.708 1.414-1.414-8.485-8.486-1.414 1.414.708.707-9.193 9.193C2.521 14.408 2 15.664 2 17s.521 2.592 1.465 3.535A4.965 4.965 0 0 0 7 22zM18.314 9.928 15.242 13H6.758l7.314-7.314 4.242 4.242z"></path>
										</svg>
									</a>
								</div>
								<div class="dz-content">
									<h6 class="title"><a href="#miscellaneous">Miscellaneous</a></h6>
									<span class="menus text-primary">29 Items</span>
								</div>
							</div>
						</div>
					</div>


				</div>
				<!-- Categories Swiper -->

				<!-- Items Area -->
				<div class="dz-custom-swiper">
					<div thumbsSlider="" class="swiper mySwiper dz-tabs-swiper">
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<h5 class="title">Lost</h5>
							</div>
							<div class="swiper-slide">
								<h5 class="title">Found</h5>
							</div>
						</div>
					</div>
					<div class="swiper mySwiper2 dz-tabs-swiper2">
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<ul class="featured-list">
									<li>
										<div class="dz-card list">
											<div class="dz-media">
												<a href="view-item-details.php"><img src="assets/images/items/product2.jpg" alt=""></a>

											</div>
											<div class="dz-content">
												<div class="dz-head">
													<h6 class="title"><a href="view-item-details.php">Item Name</a></h6>
													<ul class="tag-list">

														<li><a href="javascript:void(0);">Electronics</a>
														</li>

													</ul>
													<span class="badge light badge-info">Posted</span><br>

													<span class="badge light badge-light">01-23-2024 09:35:45 </span>
												</div>

											</div>
										</div>
									</li>
									<li>
										<div class="dz-card list">
											<div class="dz-media">
												<a href="view-item-details.php"><img src="assets/images/items/product2.jpg" alt=""></a>

											</div>
											<div class="dz-content">
												<div class="dz-head">
													<h6 class="title"><a href="view-item-details.php">Item Name</a></h6>
													<ul class="tag-list">

														<li><a href="javascript:void(0);">Personal Items</a>
														</li>

													</ul>
													<span class="badge light badge-warning">Claiming</span><br>

													<span class="badge light badge-light">01-23-2024 09:35:45 </span>
												</div>
											</div>
										</div>
									</li>
									<li>
										<div class="dz-card list">
											<div class="dz-media">
												<a href="view-item-details.php"><img src="assets/images/items/product2.jpg" alt=""></a>

											</div>
											<div class="dz-content">
												<div class="dz-head">
													<h6 class="title"><a href="view-item-details.php">Item Name</a></h6>
													<ul class="tag-list">

														<li><a href="javascript:void(0);">Electronics</a>
														</li>

													</ul>
													<span class="badge light badge-info">Posted</span><br>

													<span class="badge light badge-light">01-23-2024 09:35:45 </span>
												</div>

											</div>
										</div>
									</li>
									<li>
										<div class="dz-card list">
											<div class="dz-media">
												<a href="view-item-details.php"><img src="assets/images/items/product2.jpg" alt=""></a>

											</div>
											<div class="dz-content">
												<div class="dz-head">
													<h6 class="title"><a href="view-item-details.php">Item Name</a></h6>
													<ul class="tag-list">

														<li><a href="javascript:void(0);">Personal Items</a>
														</li>

													</ul>
													<span class="badge light badge-warning">Claiming</span><br>

													<span class="badge light badge-light">01-23-2024 09:35:45 </span>
												</div>
											</div>
										</div>
									</li>
									<li>
										<div class="dz-card list">
											<div class="dz-media">
												<a href="view-item-details.php"><img src="assets/images/items/product2.jpg" alt=""></a>

											</div>
											<div class="dz-content">
												<div class="dz-head">
													<h6 class="title"><a href="view-item-details.php">Item Name</a></h6>
													<ul class="tag-list">

														<li><a href="javascript:void(0);">Electronics</a>
														</li>

													</ul>
													<span class="badge light badge-info">Posted</span><br>

													<span class="badge light badge-light">01-23-2024 09:35:45 </span>
												</div>

											</div>
										</div>
									</li>
									<li>
										<div class="dz-card list">
											<div class="dz-media">
												<a href="view-item-details.php"><img src="assets/images/items/product2.jpg" alt=""></a>

											</div>
											<div class="dz-content">
												<div class="dz-head">
													<h6 class="title"><a href="view-item-details.php">Item Name</a></h6>
													<ul class="tag-list">

														<li><a href="javascript:void(0);">Personal Items</a>
														</li>

													</ul>
													<span class="badge light badge-warning">Claiming</span><br>

													<span class="badge light badge-light">01-23-2024 09:35:45 </span>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>
							<div class="swiper-slide">
								<ul class="featured-list">
									<li>
										<div class="dz-card list">
											<div class="dz-media">
												<a href="view-item-details.php"><img src="assets/images/items/product2.jpg" alt=""></a>

											</div>
											<div class="dz-content">
												<div class="dz-head">
													<h6 class="title"><a href="view-item-details.php">Item Name</a></h6>
													<ul class="tag-list">

														<li><a href="javascript:void(0);">Electronics</a>
														</li>

													</ul>
													<span class="badge light badge-success">Posted</span><br>

													<span class="badge light badge-light">01-23-2024 09:35:45 </span>
												</div>

											</div>
										</div>
									</li>
									<li>
										<div class="dz-card list">
											<div class="dz-media">
												<a href="view-item-details.php"><img src="assets/images/items/product2.jpg" alt=""></a>

											</div>
											<div class="dz-content">
												<div class="dz-head">
													<h6 class="title"><a href="view-item-details.php">Item Name</a></h6>
													<ul class="tag-list">

														<li><a href="javascript:void(0);">Personal Item</a>
														</li>

													</ul>
													<span class="badge light badge-warning">Claiming</span><br>

													<span class="badge light badge-light">01-23-2024 09:35:45 </span>
												</div>
											</div>
										</div>
									</li>
								</ul>
							</div>

						</div>
					</div>
				</div>
				<!-- Items Area -->
			</div>
		</main>
		<!-- Main Content End -->
	</div>
	<!--**********************************
    Scripts
***********************************-->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
	<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script src="assets/vendor/wnumb/wNumb.js"></script><!-- WNUMB -->
	<script src="assets/vendor/nouislider/nouislider.min.js"></script><!-- NOUSLIDER MIN JS-->
	<script src="assets/js/noui-slider.init.js"></script><!-- NOUSLIDER MIN JS-->
	<script src="assets/js/dz.carousel.js"></script>
	<script src="assets/js/settings.js"></script>
	<script src="assets/js/custom.js"></script>
	<script>
		function makeActive(element) {
			// Remove active class from all dz-categories-bx elements
			var elements = document.getElementsByClassName('dz-categories-bx');
			for (var i = 0; i < elements.length; i++) {
				elements[i].classList.remove('active');
				var title = elements[i].querySelector('.title');
				if (title) {
					title.classList.remove('active-title');
				}
			}

			// Add active class to the clicked element
			element.classList.add('active');
			var title = element.querySelector('.title');
			if (title) {
				title.classList.add('active-title');
			}

			// Scroll the clicked element into view, aligning it to the left first
			element.scrollIntoView({
				behavior: 'smooth',
				inline: 'center',
				block: 'nearest'
			});

			// Adjust the scroll position to center the clicked element
			var container = document.querySelector('.dz-categories-container'); // Assuming container class
			var containerRect = container.getBoundingClientRect();
			var elementRect = element.getBoundingClientRect();
			var offset = elementRect.left - containerRect.left - (containerRect.width / 2) + (elementRect.width / 2);

			container.scrollBy({
				left: offset,
				behavior: 'smooth'
			});
		}
	</script>

</body>

</html>