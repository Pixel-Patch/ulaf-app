<!DOCTYPE html>
<html lang="en">

<head>
	<?php
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$title = "ULAF - Sign In | PixelPatch";

	require("head.php");
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

		<!-- Main Content Start  -->
		<main class="page-content">
			<div class="container py-0">
				<div class="dz-authentication-area">
					<div class="main-logo">
						<div class="logo">
							<img src="assets/images/app-logo/logo.png" alt="logo">
						</div>
					</div>
					<div class="section-head">
						<h3 class="title">Sign In</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor </p>
					</div>
					<div class="account-section">

						<form id="signin-form" onsubmit="event.preventDefault(); submitSignIn();">
							<div class="mb-4">
								<label class="form-label" for="usernameEmail">Username/Email</label>
								<div class="input-group input-mini input-lg">
									<input type="text" id="usernameEmail" name="usernameEmail" class="form-control" placeholder="username/email" required>
								</div>
							</div>
							<div class="m-b30">
								<label class="form-label" for="password">Password</label>
								<div class="input-group input-mini input-lg">
									<input type="password" id="password" name="password" class="form-control dz-password" placeholder="**********" required>
									<span class="input-group-text show-pass">
										<i class="icon feather icon-eye-off eye-close"></i>
										<i class="icon feather icon-eye eye-open"></i>
									</span>
								</div>
							</div>
							<button type="submit" class="btn btn-thin btn-lg w-100 btn-primary rounded-xl mb-3">Login</button>
							<p class="form-text">Forgot Password? <a href="forgot-password.php" class="link ms-2">Reset Password</a></p>
						</form>

						<div class="text-center account-footer">
							<p class="text-light">Dont have any account?</p>
							<a href="sign-up.php" class="btn btn-secondary btn-lg btn-thin rounded-xl w-100">CREATE AN ACCOUNT</a>
						</div>
					</div>
				</div>
			</div>
		</main>
		<!-- Main Content End  -->

		<!-- Add this modal to your HTML -->
		<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content" id="alertModalContent" style="font-size:large; ">
					<div class="modal-body" id="alertModalBody">
					</div>
				</div>
			</div>
		</div>



	</div>
	<!--**********************************
    Scripts
***********************************-->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/swiper/swiper-bundle.min.js"></script><!-- Swiper -->
	<script src="assets/js/dz.carousel.js"></script><!-- Swiper -->
	<script src="assets/js/settings.js"></script>
	<script src="assets/js/custom.js"></script>
	<script>
		function showAlertModal(alertClass, alertTitle, message) {
			const alertModalContent = document.getElementById('alertModalContent');
			const alertModalBody = document.getElementById('alertModalBody');

			// Set the class and content of the alert
			alertModalContent.className = `modal-content alert ${alertClass} alert-dismissible alert-alt fade show`;
			alertModalBody.innerHTML = `<strong>${alertTitle}</strong> ${message}`;

			// Show the modal
			new bootstrap.Modal(document.getElementById('alertModal')).show();
		}

		function submitSignIn() {
			const form = document.getElementById('signin-form');
			const formData = new FormData(form);

			fetch('submit_signin.php', {
					method: 'POST',
					body: formData
				})
				.then(response => {
					if (!response.ok) {
						console.error('Server responded with status', response.status, 'and status text', response.statusText);
						return response.text(); // Get the response as text instead of JSON
					}
					return response.json();
				})
				.then(data => {
					if (data.status === 'success') {
						showAlertModal('alert-primary', 'Success!', data.message);
						setTimeout(() => {
							window.location.href = 'index.php';
						}, 2000);
					} else {
						showAlertModal(data.alertClass, data.alertTitle, data.message);
					}
				})
				.catch(error => {
					console.error('Error:', error);
					showAlertModal('alert-danger', 'Error!', 'An error occurred while processing your request.');
				});
		}
	</script>

</body>

</html>