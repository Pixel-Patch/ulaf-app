<?php
$title = "ULAF - Home | PixelPatch";

require("header.php");
require("fetch-user-data.php");

$userData = $_SESSION['user_data'] ?? []; // Retrieve user data from session
?>



<style>
	del {
		text-decoration: none;
	}

	.dz-media {
		border-radius: 50px;
	}

	.overlay-swiper1 .swiper-slide {
		width: 225px;
	}

	.overlay-swiper2 .swiper-slide {
		width: 350px;
	}

	.dz-card-overlay a {
		margin-left: 10px;
	}

	ul {
		padding: 0px 10px 0px 10px;
	}

	p {
		margin: 5px 0 0 10px;
	}

	.truncated {
		display: -webkit-box;
		-webkit-line-clamp: 3;
		/* Number of lines to show */
		-webkit-box-orient: vertical;
		overflow: hidden;
		text-overflow: ellipsis;
	}
</style>

</head>

<body>
	<div class="page-wrapper">

		<!-- Preloader -->
		<?php include "pre-loader.php"; ?>
		<!-- Preloader end-->

		<!-- Sidebar -->
		<?php include("sidebar.php"); ?>
		<!-- Sidebar End -->

		<!-- Nav Floting Start -->
		<div class="dz-nav-floting">
			<!-- Header -->
			<header class="header py-2 mx-auto">
				<div class="header-content">
					<div class="left-content">
						<div class="info">
							<p class="text m-b10" id="greeting">Good Morning/Afternoon/Evening</p>
							<h3 class="title"><?php echo htmlspecialchars($userData['Username'] ?? 'N/A'); ?></h3>
						</div>
					</div>
					<div class="mid-content"></div>
					<div class="right-content d-flex align-items-center gap-4">
						<a href="notification.php" class="notification-badge font-20 badge-active">
							<svg width="30" height="30" viewBox="0 0 24 24" class="svg-primary" fill="none" xmlns="http://www.w3.org/2000/svg">
								<path d="M21.7329 21.68C21.8273 21.5791 21.8998 21.4597 21.9457 21.3295C21.9917 21.1992 22.0101 21.0608 21.9999 20.923L20.9999 7.92299C20.9805 7.67134 20.8666 7.43634 20.6811 7.26515C20.4957 7.09396 20.2523 6.99924 19.9999 6.99999H16.9999C16.9999 5.67391 16.4731 4.40214 15.5355 3.46446C14.5978 2.52677 13.326 1.99999 11.9999 1.99999C10.6738 1.99999 9.40207 2.52677 8.46438 3.46446C7.5267 4.40214 6.99992 5.67391 6.99992 6.99999H3.99992C3.74752 6.99924 3.50417 7.09396 3.3187 7.26515C3.13323 7.43634 3.01935 7.67134 2.99992 7.92299L1.99992 20.923C1.98929 21.0606 2.00727 21.199 2.05275 21.3294C2.09822 21.4597 2.17019 21.5792 2.26413 21.6804C2.35807 21.7816 2.47194 21.8622 2.59858 21.9172C2.72521 21.9722 2.86186 22.0004 2.99992 22H20.9999C21.1375 22 21.2737 21.9715 21.3998 21.9165C21.5259 21.8614 21.6393 21.7809 21.7329 21.68ZM11.9999 3.99999C12.7956 3.99999 13.5586 4.31606 14.1212 4.87867C14.6838 5.44128 14.9999 6.20434 14.9999 6.99999H8.99992C8.99992 6.20434 9.31599 5.44128 9.8786 4.87867C10.4412 4.31606 11.2043 3.99999 11.9999 3.99999ZM4.07992 20L4.92592 8.99999H6.99992V11C6.99992 11.2652 7.10527 11.5196 7.29281 11.7071C7.48035 11.8946 7.7347 12 7.99992 12C8.26513 12 8.51949 11.8946 8.70702 11.7071C8.89456 11.5196 8.99992 11.2652 8.99992 11V8.99999H14.9999V11C14.9999 11.2652 15.1053 11.5196 15.2928 11.7071C15.4803 11.8946 15.7347 12 15.9999 12C16.2651 12 16.5195 11.8946 16.707 11.7071C16.8946 11.5196 16.9999 11.2652 16.9999 11V8.99999H19.0739L19.9199 20H4.07992Z" fill="#04764E"></path>
							</svg>
						</a>
						<a href="javascript:void(0);" class="icon dz-floating-toggler">
							<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
								<rect y="2" width="20" height="3" rx="1.5" fill="#5F5F5F" />
								<rect y="18" width="20" height="3" rx="1.5" fill="#5F5F5F" />
								<rect x="4" y="10" width="20" height="3" rx="1.5" fill="#5F5F5F" />
							</svg>
						</a>
					</div>
				</div>
			</header>

			<!-- Header -->

			<!-- Main Content Start -->
			<main class="page-content bg-white p-b60">
				<div class="container">
					<!-- SearchBox -->
					<div class="search-box">
						<div class="input-group input-radius input-rounded input-lg">
							<input type="text" placeholder="Search beverages or foods" class="form-control">
							<span class="input-group-text">
								<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
									<path d="M9.65925 19.3102C11.8044 19.3103 13.8882 18.5946 15.5806 17.2764L21.9653 23.6612C22.4423 24.1218 23.2023 24.1086 23.663 23.6316C24.1123 23.1664 24.1123 22.4288 23.663 21.9635L17.2782 15.5788C20.5491 11.3682 19.7874 5.30333 15.5769 2.03243C11.3663 -1.23848 5.30149 -0.476799 2.03058 3.73374C-1.24033 7.94428 -0.478646 14.0092 3.73189 17.2801C5.42702 18.5969 7.51269 19.3113 9.65925 19.3102ZM4.52915 4.5273C7.36245 1.69394 11.9561 1.69389 14.7895 4.5272C17.6229 7.3605 17.6229 11.9542 14.7896 14.7876C11.9563 17.6209 7.36261 17.621 4.52925 14.7877C4.5292 14.7876 4.5292 14.7876 4.52915 14.7876C1.69584 11.9749 1.67915 7.39794 4.49181 4.56464C4.50424 4.55216 4.51667 4.53973 4.52915 4.5273Z" fill="#C9C9C9" />
								</svg>
							</span>
						</div>
					</div>
					<!-- SearchBox -->


					<!-- Overlay Card -->
					<div class="swiper overlay-swiper1" style="padding-top: 20px;">
						<div class="title-bar mb-0">
							<h5 class="title">Recently Added</h5>
							<a href="items.php">load more</a>
						</div>

						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<div class="dz-card-overlay style-1" style="border-radius: 50px;">
									<div class="dz-media">
										<a href="product-detail.php">
											<img src="assets/images/featured/facecream.jpg" alt="image">
										</a>
									</div>
									<div class="dz-info">
										<h6 class="title">
											<span class="badge badge-success">Found</span><br>
											<a href="product-detail.php">Face Cream</a>
										</h6>
										<ul class="dz-meta">
											<li class="dz-price">
												<del class="no-line">Categories</del>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-card-overlay style-1" style="border-radius: 50px;">
									<div class="dz-media">
										<a href="product-detail.php">
											<img src="assets/images/featured/facecream.jpg" alt="image">
										</a>
									</div>
									<div class="dz-info">
										<h6 class="title">
											<span class="badge badge-danger">Lost</span><br>
											<a href="product-detail.php">Face Cream</a>
										</h6>
										<ul class="dz-meta">
											<li class="dz-price">
												<del class="no-line">Categories</del>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-card-overlay style-1" style="border-radius: 50px;">
									<div class="dz-media">
										<a href="product-detail.php">
											<img src="assets/images/featured/facecream.jpg" alt="image">
										</a>
									</div>
									<div class="dz-info">
										<h6 class="title">
											<span class="badge badge-success">Found</span><br>
											<a href="product-detail.php">Face Cream</a>
										</h6>
										<ul class="dz-meta">
											<li class="dz-price">
												<del class="no-line">Categories</del>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-card-overlay style-1" style="border-radius: 50px;">
									<div class="dz-media">
										<a href="product-detail.php">
											<img src="assets/images/featured/facecream.jpg" alt="image">
										</a>
									</div>
									<div class="dz-info">
										<h6 class="title">
											<span class="badge badge-danger">Lost</span><br>
											<a href="product-detail.php">Face Cream</a>
										</h6>
										<ul class="dz-meta">
											<li class="dz-price">
												<del class="no-line">Categories</del>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-card-overlay style-1" style="border-radius: 50px;">
									<div class="dz-media">
										<a href="product-detail.php">
											<img src="assets/images/featured/facecream.jpg" alt="image">
										</a>
									</div>
									<div class="dz-info">
										<h6 class="title">
											<span class="badge badge-success">Found</span><br>
											<a href="product-detail.php">Face Cream</a>
										</h6>
										<ul class="dz-meta">
											<li class="dz-price">
												<del class="no-line">Categories</del>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-card-overlay style-1" style="border-radius: 50px;">
									<div class="dz-media">
										<a href="product-detail.php">
											<img src="assets/images/featured/facecream.jpg" alt="image">
										</a>
									</div>
									<div class="dz-info">
										<h6 class="title">
											<span class="badge badge-danger">Lost</span><br>
											<a href="product-detail.php">Face Cream</a>
										</h6>
										<ul class="dz-meta">
											<li class="dz-price">
												<del class="no-line">Categories</del>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</div>

					</div>
					<!-- Overlay Card -->

					<!-- Categories Swiper -->
					<div class="title-bar mb-0">
						<h5 class="title">Categories</h5>
					</div>
					<div class="swiper categories-swiper dz-swiper m-b20">
						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<div class="dz-categories-bx">
									<div class="icon-bx">
										<a href="electronics.php">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
												<path d="M20 17.722c.595-.347 1-.985 1-1.722V5c0-1.103-.897-2-2-2H5c-1.103 0-2 .897-2 2v11c0 .736.405 1.375 1 1.722V18H2v2h20v-2h-2v-.278zM5 16V5h14l.002 11H5z"></path>
											</svg>
										</a>
									</div>
									<div class="dz-content">
										<h6 class="title"><a href="electronics.php">Electronics</a></h6>
										<span class="menus text-primary">67 Items</span>
									</div>
								</div>
							</div>

							<div class="swiper-slide">
								<div class="dz-categories-bx">
									<div class="icon-bx">
										<a href="personal-items.php">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
												<path d="M16 12h2v4h-2z"></path>
												<path d="M20 7V5c0-1.103-.897-2-2-2H5C3.346 3 2 4.346 2 6v12c0 2.201 1.794 3 3 3h15c1.103 0 2-.897 2-2V9c0-1.103-.897-2-2-2zM5 5h13v2H5a1.001 1.001 0 0 1 0-2zm15 14H5.012C4.55 18.988 4 18.805 4 18V8.815c.314.113.647.185 1 .185h15v10z"></path>
											</svg>
										</a>
									</div>
									<div class="dz-content">
										<h6 class="title"><a href="personal-items.php">Personal Items</a></h6>
										<span class="menus text-primary">25 Items</span>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-categories-bx">
									<div class="icon-bx">
										<a href="clothing-shoes.php">
											<i class="fa-regular fa-shirt" style="font-size:20px; margin-top:3px"></i>
										</a>
									</div>
									<div class="dz-content">
										<h6 class="title"><a href="clothing-shoes.php">Clothing & Shoes</a></h6>
										<span class="menus text-primary">43 Items</span>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-categories-bx">
									<div class="icon-bx">
										<a href="books-stationery.php">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
												<path d="M21 3h-7a2.98 2.98 0 0 0-2 .78A2.98 2.98 0 0 0 10 3H3a1 1 0 0 0-1 1v15a1 1 0 0 0 1 1h5.758a2.01 2.01 0 0 1 1.414.586l1.121 1.121c.009.009.021.012.03.021.086.08.182.15.294.196h.002a.996.996 0 0 0 .762 0h.002c.112-.046.208-.117.294-.196.009-.009.021-.012.03-.021l1.121-1.121A2.01 2.01 0 0 1 15.242 20H21a1 1 0 0 0 1-1V4a1 1 0 0 0-1-1zm-1 15h-4.758a4.03 4.03 0 0 0-2.242.689V6c0-.551.448-1 1-1h6v13z"></path>
											</svg>
										</a>
									</div>
									<div class="dz-content">
										<h6 class="title"><a href="books-stationery.php">Books and Stationery</a></h6>
										<span class="menus text-primary">32 Items</span>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-categories-bx">
									<div class="icon-bx">
										<a href="flasks-accessories.php">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
												<path d="M12 22c4.636 0 8-3.468 8-8.246C20 7.522 12.882 2.4 12.579 2.185a1 1 0 0 0-1.156-.001C11.12 2.397 4 7.503 4 13.75 4 18.53 7.364 22 12 22zm-.001-17.74C13.604 5.55 18 9.474 18 13.754 18 17.432 15.532 20 12 20s-6-2.57-6-6.25c0-4.29 4.394-8.203 5.999-9.49z"></path>
											</svg>
										</a>
									</div>
									<div class="dz-content">
										<h6 class="title"><a href="flasks-accessories.php">Flasks & Accessories</a></h6>
										<span class="menus text-primary">18 Items</span>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-categories-bx">
									<div class="icon-bx">
										<a href="bags-backpacks.php">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
												<path d="M4 20h2V10a1 1 0 0 1 1-1h12V7a1 1 0 0 0-1-1h-3.051c-.252-2.244-2.139-4-4.449-4S6.303 3.756 6.051 6H3a1 1 0 0 0-1 1v11a2 2 0 0 0 2 2zm6.5-16c1.207 0 2.218.86 2.45 2h-4.9c.232-1.14 1.243-2 2.45-2z"></path>
												<path d="M21 11H9a1 1 0 0 0-1 1v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8a1 1 0 0 0-1-1zm-6 7c-2.757 0-5-2.243-5-5h2c0 1.654 1.346 3 3 3s3-1.346 3-3h2c0 2.757-2.243 5-5 5z"></path>
											</svg>
										</a>
									</div>
									<div class="dz-content">
										<h6 class="title"><a href="bags-backpacks.php">Bags and Backpacks</a></h6>
										<span class="menus text-primary">56 Items</span>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-categories-bx">
									<div class="icon-bx">
										<a href="miscellaneous.php">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" style="fill: rgba(0, 0, 0, 1);">
												<path d="M7 22a4.965 4.965 0 0 0 3.535-1.465l9.193-9.193.707.708 1.414-1.414-8.485-8.486-1.414 1.414.708.707-9.193 9.193C2.521 14.408 2 15.664 2 17s.521 2.592 1.465 3.535A4.965 4.965 0 0 0 7 22zM18.314 9.928 15.242 13H6.758l7.314-7.314 4.242 4.242z"></path>
											</svg>
										</a>
									</div>
									<div class="dz-content">
										<h6 class="title"><a href="miscellaneous.php">Miscellaneous</a></h6>
										<span class="menus text-primary">29 Items</span>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!-- Categories Swiper -->


					<!-- Last 7 days Overlay Card -->
					<div class="title-bar mb-0">
						<h5 class="title">Last 7 days <br></h5>
						<a href="items.php">load more</a>
					</div>
					<div class="swiper overlay-swiper2" style="padding-top: 25px;">


						<div class="swiper-wrapper">
							<div class="swiper-slide">
								<div class="dz-wishlist-bx">
									<div class="dz-media">
										<a href="product-detail.php"><img src="assets/images/menus/pic1.jpg" alt=""></a>
									</div>
									<div class="dz-info">
										<div class="dz-head">
											<h6 class="title"><a href="product-detail.php">Apple Watch</a></h6>
											<span class="badge badge-success">Found</span>
											<span class="badge light badge-light">01-23-2024 09:35:45 </span>

											<p>Have scatches in bottghghghfghom left
										</div>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-wishlist-bx">
									<div class="dz-media">
										<a href="product-detail.php"><img src="assets/images/menus/pic1.jpg" alt=""></a>
									</div>
									<div class="dz-info">
										<div class="dz-head">
											<h6 class="title"><a href="product-detail.php">Apple Watch</a></h6>
											<span class="badge badge-danger">Lost</span>
											<span class="badge light badge-light">01-23-2024 09:35:45 </span>

											<p>Have scatches in bottghghghfghom left
										</div>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-wishlist-bx">
									<div class="dz-media">
										<a href="product-detail.php"><img src="assets/images/menus/pic1.jpg" alt=""></a>
									</div>
									<div class="dz-info">
										<div class="dz-head">
											<h6 class="title"><a href="product-detail.php">Apple Watch</a></h6>
											<span class="badge badge-success">Found</span>
											<span class="badge light badge-light">01-23-2024 09:35:45 </span>

											<p>Have scatches in bottghghghfghom left
										</div>
									</div>
								</div>
							</div>
							<div class="swiper-slide">
								<div class="dz-wishlist-bx">
									<div class="dz-media">
										<a href="product-detail.php"><img src="assets/images/menus/pic1.jpg" alt=""></a>
									</div>
									<div class="dz-info">
										<div class="dz-head">
											<h6 class="title"><a href="product-detail.php">Apple Watch</a></h6>
											<span class="badge badge-danger">Lost</span>
											<span class="badge light badge-light">01-23-2024 09:35:45 </span>

											<p>Have scatches in bottghghghfghom left
										</div>
									</div>
								</div>
							</div>
						</div>

					</div>
					<!-- Overlay Card -->

					<!-- Featured Beverages -->
					<div class="accordion-item accordion-primary">
						<div class="accordion-header  " id="headingOne" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne" aria-expanded="true" role="button">
							<span class="accordion-header-icon"></span>
							<span class="accordion-header-text">Unclaimed Found Items</span>
							<span class="accordion-header-indicator"></span>
						</div>
						<div id="collapseOne" class="collapse  " aria-labelledby="headingOne" data-bs-parent="#accordion-one">
							<div class="accordion-body-text">
								Attention: Unclaimed items in the lost and found will be donated or recycled at the end of the semester. Please check for any missing items and claim them before then. Go to USF Office for more details.
							</div>
						</div>
					</div>

					<p></p>

					<ul class="featured-list">
						<div class="row g-3">
							<div class="col-12 col-sm-12">
								<div class="dz-wishlist-bx">
									<div class="dz-media">
										<a href="product-detail.php"><img src="assets/images/menus/pic1.jpg" alt=""></a>
									</div>
									<div class="dz-info">
										<div class="dz-head">
											<h6 class="title"><a href="product-detail.php">Apple Watch</a></h6>
											<span class="badge badge-success">Found</span>
											<span class="badge light badge-light">01-23-2024 09:35:45 </span>

											<p>Have scatches in bottghghghfghom left
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-12">
								<div class="dz-wishlist-bx">
									<div class="dz-media">
										<a href="product-detail.php"><img src="assets/images/menus/pic1.jpg" alt=""></a>
									</div>
									<div class="dz-info">
										<div class="dz-head">
											<h6 class="title"><a href="product-detail.php">Apple Watch</a></h6>
											<span class="badge badge-success">Found</span>
											<span class="badge light badge-light">01-23-2024 09:35:45 </span>

											<p>Have scatches in bottghghg hfghom left gfhfghfgh dfgfdgdfg dfgfdgdfg sdfbdgggsfbhdsbf
												dsf
												d
												ffgdfg gdfgfdg gfdgfdgdf g dfg fdgfd gfdgdfgdfg
												sdf
										</div>
									</div>
								</div>
							</div>
							<div class="col-12 col-sm-12">
								<div class="dz-wishlist-bx">
									<div class="dz-media">
										<a href="product-detail.php"><img src="assets/images/menus/pic1.jpg" alt=""></a>
									</div>
									<div class="dz-info">
										<div class="dz-head">
											<h6 class="title"><a href="product-detail.php">Apple Watch</a></h6>
											<span class="badge badge-success">Found</span>
											<span class="badge light badge-light">01-23-2024 09:35:45 </span>

											<p>Have scatches in bottghghghfghom left
										</div>
									</div>
								</div>
							</div>
						</div>
					</ul>
					<a href="unclaimed-found-item.php" class="btn mb-2 me-2 btn-block btn-secondary">Load More</a>

					<!-- Featured Beverages -->
				</div>

			</main>
			<!-- Main Content End -->

			<!-- Menubar -->
			<div class="menubar-area footer-fixed">
				<div class="toolbar-inner menubar-nav">
					<a href="index.php" class="nav-link active">
						<i class="fi fi-rr-home"></i>
					</a>
					<a href="cart.php" class="nav-link">
						<i class="fi fi-rr-shopping-cart"></i>
					</a>
					<a href="user-profile.php" class="nav-link">
						<i class="fi fi-rr-user"></i>
					</a>
					<a href="add-item-details.php" class="nav-link">
						<i class="fa-regular fa-file-circle-plus"></i>
					</a>
				</div>
			</div>
			<!-- Menubar -->
		</div>
		<!-- Nav Floting End -->

		<!-- Modal -->
		<div class="modal fade dz-pwa-modal" id="pwaModal" tabindex="-1" aria-labelledby="pwaModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<img class="logo dark" src="assets/images/app-logo/logo.png" alt="">
					<img class="logo light" src="assets/images/app-logo/logo-white.png" alt="">
					<h5 class="title">ULAF - University Lost and Found</h5>
					<p class="pwa-text">To fully utilize the app's features, including posting and claiming items, please complete the registration process.</p>
					<a href="add-user-details.php" class="btn pwa-btn" onclick="completeRegistration()">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M12 16.0001V13.0001M12 13.0001V10.0001M12 13.0001H9M12 13.0001H15M4 16.8002V11.4522C4 10.9179 4 10.6506 4.06497 10.4019C4.12255 10.1816 4.2173 9.97307 4.34521 9.78464C4.48955 9.57201 4.69064 9.39569 5.09277 9.04383L9.89436 4.84244C10.6398 4.19014 11.0126 3.86397 11.4324 3.73982C11.8026 3.63035 12.1972 3.63035 12.5674 3.73982C12.9875 3.86406 13.3608 4.19054 14.1074 4.84383L18.9074 9.04383C19.3096 9.39569 19.5102 9.57201 19.6546 9.78464C19.7825 9.97307 19.8775 10.1816 19.9351 10.4019C20 10.6505 20 10.9184 20 11.4522V16.8037C20 17.9216 20 18.4811 19.7822 18.9086C19.5905 19.2849 19.2842 19.5906 18.9079 19.7823C18.4805 20.0001 17.9215 20.0001 16.8036 20.0001H7.19691C6.07899 20.0001 5.5192 20.0001 5.0918 19.7823C4.71547 19.5906 4.40973 19.2849 4.21799 18.9086C4 18.4807 4 17.9203 4 16.8002Z" stroke="#03764D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
						</svg>
						<span>Complete Registration</span>
					</a>
				</div>
			</div>
		</div>
		<!-- PWA End -->

	</div>
	<!--**********************************
Scripts
***********************************-->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script src="assets/js/dz.carousel.js"></script>
	<script src="assets/js/settings.js"></script>
	<script src="assets/js/custom.js"></script>
	<script src="index.js"></script>
	<script>
		// Calculate the current time in PHT (Philippine Time)
		function getPhilippineTime() {
			const now = new Date();
			const utcOffset = now.getTimezoneOffset() * 60000;
			const philippinesOffset = 8 * 60 * 60000; // UTC+8 for PHT
			const pht = new Date(now.getTime() + utcOffset + philippinesOffset);
			return pht;
		}

		function getGreeting() {
			const currentHour = getPhilippineTime().getHours();
			let greeting;

			if (currentHour < 12) {
				greeting = "Good Morning";
			} else if (currentHour < 18) {
				greeting = "Good Afternoon";
			} else {
				greeting = "Good Evening";
			}

			return greeting;
		}

		// Set the greeting and username dynamically
		document.getElementById('greeting').innerText = getGreeting();
		document.getElementById('username').innerText = username;
	</script>
</body>

</html>