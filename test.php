<?php
$title = "ULAF - Home | PixelPatch";

require("head.php"); ?>


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
							<p class="text m-b10">Good Morning</p>
							<h3 class="title">Williams</h3>
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


					<!-- Button trigger modal -->
					<button type="button" class="btn w-100 btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Modal centered</button>


			</main>


			<!-- Main Content End -->

			<!-- Menubar -->
			<div class="menubar-area footer-fixed">
				<div class="toolbar-inner menubar-nav">
					<a href="index.php" class="nav-link active">
						<i class="fi fi-rr-home"></i>
					</a>
					<a href="wishlist.php" class="nav-link">
						<i class="fi fi-rr-heart"></i>
					</a>
					<a href="cart.php" class="nav-link">
						<i class="fi fi-rr-shopping-cart"></i>
					</a>
					<a href="profile.php" class="nav-link">
						<i class="fi fi-rr-user"></i>
					</a>
				</div>
			</div>
			<!-- Menubar -->
		</div>
		<!-- Nav Floting End -->
		<!-- Modal -->
		<div class="modal fade" id="exampleModalCenter">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content alert alert-warning alert-dismissible alert-alt fade show">
					<div class="">
						<button class="btn-close" data-bs-dismiss="modal">
							<i class="fa-solid fa-xmark"></i>
						</button>
						<strong>Warning!</strong> Something went wrong. Please check.
					</div>
				</div>
			</div>
		</div>
		
		<div class="modal fade show" id="alertModal" tabindex="-1" aria-labelledby="alertModalCenterTitle" style="display: block;" aria-modal="true" role="dialog">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div id="alertModalContent" class="modal-content alert alert-warning alert-dismissible alert-alt fade show">
					<div class="modal-header">
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>
					<div class="modal-body" id="alertModalBody"><strong>Warning!</strong> User ID already exists. Please sign in.</div>
				</div>
			</div>
		</div>


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
		// Trigger the modal when needed
		document.addEventListener('DOMContentLoaded', (event) => {
			// Logic to determine when to show the modal
			// For example, show the modal immediately on page load:
			document.getElementById('triggerModal').click();
		});
	</script>
</body>

</html>