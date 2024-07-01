<?php

$title = "ULAF - Home | PixelPatch";
require("header.php");
require("fetch-user-data.php"); // Include the fetch-user-data script
$userData = $_SESSION['user_data'] ?? []; // Retrieve user data from session
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
		<header class="header header-fixed border-bottom">
			<div class="header-content">
				<div class="left-content">
					<a href="javascript:void(0);" class="back-btn">
						<i class="feather icon-arrow-left"></i>
					</a>
				</div>
				<div class="mid-content">
					<h4 class="title">Edit Profile</h4>
				</div>
				<div class="right-content"></div>
			</div>
		</header>
		<!-- Header -->

		<!-- Main Content Start -->
		<main class="page-content space-top p-b80">
			<div class="container">
				<div class="edit-profile">
					<div class="profile-image">
						<div class="avatar-upload">
							<div class="avatar-preview">
								<div id="imagePreview" style="background-image: url(assets/images/avatar/1.jpg);"></div>
								<div class="change-btn">
									<input type='file' class="form-control d-none" id="imageUpload" accept=".png, .jpg, .jpeg">
									<label for="imageUpload">
										<i class="fi fi-rr-pencil"></i>
									</label>
								</div>
							</div>
						</div>
					</div>
					<div class="mb-4">
						<label class="form-label" for="name">Full Name</label>
						<div class="input-group input-mini input-sm">
							<input type="text" id="name" class="form-control">
						</div>
					</div>
					<div class="mb-4">
						<label class="form-label" for="phone">Mobile Number</label>
						<div class="input-group input-mini input-sm">
							<input type="tel" id="phone" class="form-control">
						</div>
					</div>
					<div class="mb-4">
						<label class="form-label" for="email">Email</label>
						<div class="input-group input-mini input-sm">
							<input type="email" id="email" class="form-control">
						</div>
					</div>
					<div class="mb-4">
						<label class="form-label" for="address">Location</label>
						<div class="input-group input-mini input-sm">
							<input type="text" id="address" class="form-control">
						</div>
					</div>
				</div>
			</div>
		</main>
		<!-- Main Content End -->

		<!-- Footer Fixed Button -->
		<div class="footer-fixed-btn bottom-0 bg-white">
			<a href="user-profile.php" class="btn btn-lg btn-thin btn-primary rounded-xl w-100">Update Profile</a>
		</div>
		<!-- Footer Fixed Button -->
	</div>
	<!--**********************************
    Scripts
***********************************-->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script src="assets/vendor/imageuplodify/imageuploadify.js"></script>
	<script src="assets/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
	<script src="assets/js/dz.carousel.js"></script>
	<script src="assets/js/settings.js"></script>
	<script src="assets/js/custom.js"></script>
	<script>
		function readURL(input) {
			if (input.files && input.files[0]) {
				var reader = new FileReader();
				reader.onload = function(e) {
					$('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
					$('#imagePreview').hide();
					$('#imagePreview').fadeIn(650);
				}
				reader.readAsDataURL(input.files[0]);
			}
		}
		$("#imageUpload").change(function() {
			readURL(this);
		});
		$('.remove-img').on('click', function() {
			var imageUrl = "images/no-img-avatar.png";
			$('.avatar-preview, #imagePreview').removeAttr('style');
			$('#imagePreview').css('background-image', 'url(' + imageUrl + ')');
		});
	</script>
</body>

</html>