<?php $title = "ULAF - Sign Up | PixelPatch";

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

		<!-- Main Content Start  -->
		<main class="page-content">
			<div class="container py-0">
				<div class="dz-authentication-area">
					<div class="main-logo">
						<a href="javascript:void(0);" class="back-btn">
							<i class="feather icon-arrow-left"></i>
						</a>
						<div class="logo">
							<img src="assets/images/app-logo/logo.png" alt="logo">
						</div>
					</div>
					<div class="section-head">
						<h3 class="title">Create an account</h3>
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor </p>
					</div>
					<div class="account-section">
						<form class="m-b20" id="signup-form">
							<div class="mb-4">
								<label class="form-label" for="userId">CLSU ID Number</label>
								<div class="input-group input-mini input-lg">
									<input type="text" id="userId" class="form-control" name="userId" placeholder="24-0001" required>
								</div>
							</div>
							<div class="mb-4">
								<label class="form-label" for="name">Username</label>
								<div class="input-group input-mini input-lg">
									<input type="text" id="name" class="form-control" name="username" placeholder="username" required>
								</div>
							</div>
							<div class="mb-4">
								<label class="form-label" for="email">Email</label>
								<div class="input-group input-mini input-lg">
									<input type="email" id="email" class="form-control" name="email" placeholder="email@example.com" required>
								</div>
							</div>
							<div class="m-b30">
								<label class="form-label" for="password">Password</label>
								<div class="input-group input-mini input-lg">
									<input type="password" id="password" class="form-control dz-password" name="password" placeholder="*********" required>
									<span class="input-group-text show-pass">
										<i class="icon feather icon-eye-off eye-close"></i>
										<i class="icon feather icon-eye eye-open"></i>
									</span>
								</div>
							</div>
							<div class="m-b30">
								<label class="form-label" for="confirmPassword">Confirm Password</label>
								<div class="input-group input-mini input-lg">
									<input type="password" id="confirmPassword" class="form-control dz-password" name="confirmPassword" placeholder="*********" required>
									<span class="input-group-text show-pass">
										<i class="icon feather icon-eye-off eye-close"></i>
										<i class="icon feather icon-eye eye-open"></i>
									</span>
								</div>
							</div>
							<button type="button" class="btn btn-thin btn-lg w-100 btn-primary rounded-xl" onclick="submitSignUp()">Sign up</button>
						</form>
						<div class="text-center">
							<p class="form-text">By tapping “Sign Up” you accept our <a href="javascript:void(0);" class="link">terms</a> and <a href="javascript:void(0);" class="link">condition</a></p>
						</div>
					</div>


				</div>
			</div>
		</main>
		<!-- Main Content End  -->

		<!-- Modal for Alerts -->
		<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div id="alertModalContent" class="modal-content" style="padding: 20px; font-size:large; ">
					<div class=" " id="alertModalBody">
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
		function submitSignUp() {

			const form = document.getElementById('signup-form');
			const formData = new FormData(form);
			var userId = document.getElementById('userId').value;
			var username = document.getElementById('name').value;
			var email = document.getElementById('email').value;
			var password = document.getElementById('password').value;
			var confirmPassword = document.getElementById('confirmPassword').value;

			if (userId === '' || username === '' || email === '' || password === '' || confirmPassword === '') {
				const alertModalContent = document.getElementById('alertModalContent');
				const alertModalBody = document.getElementById('alertModalBody');

				alertModalContent.className = 'modal-content alert alert-danger alert-dismissible alert-alt fade show';
				alertModalBody.innerHTML = `<strong>Error!</strong> All fields are required`;
				new bootstrap.Modal(document.getElementById('alertModal')).show();
				return;
			}

			fetch('submit_signup.php', {
					method: 'POST',
					body: formData
				}).then(response => response.json())
				.then(data => {
					const alertModalContent = document.getElementById('alertModalContent');
					const alertModalBody = document.getElementById('alertModalBody');

					if (data.status === 'success') {
						alertModalContent.className = 'modal-content alert alert-primary alert-dismissible alert-alt fade show';
						alertModalBody.innerHTML = `<strong>Success!</strong> ${data.message}`;
						new bootstrap.Modal(document.getElementById('alertModal')).show();
						setTimeout(() => {
							window.location.href = 'sign-in.php';
						}, 2000);
					} else {
						alertModalContent.className = data.alertClass;
						alertModalBody.innerHTML = `<strong>${data.alertTitle}</strong> ${data.message}`;
						new bootstrap.Modal(document.getElementById('alertModal')).show();
					}
				});
		}
	</script>


</body>

</html>