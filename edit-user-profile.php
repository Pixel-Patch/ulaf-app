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
					<form id="profileForm" action="update-user-profile.php" method="POST" enctype="multipart/form-data">
						<div class="profile-image">
							<div class="avatar-upload">
								<div class="avatar-preview">
									<div id="imagePreview" style="background-image: url(assets/uploads/user-avatar/<?php echo htmlspecialchars($userData['Avatar_Image'] ?? 'default-avatar.jpg'); ?>);"></div>
									<div class="change-btn">
										<input type='file' class="form-control d-none" id="imageUpload" accept=".png, .jpg, .jpeg" name="avatar">
										<label for="imageUpload">
											<i class="fi fi-rr-pencil"></i>
										</label>
									</div>
								</div>
							</div>
						</div>
						<h6 class="dz-title my-2">Account Details</h6>
						<div class="mb-3">
							<label class="form-label" for="userId">CLSU ID Number</label>
							<input type="text" id="userId" class="form-control" value="<?php echo $userId; ?>" name="userId" aria-label=" " disabled />
						</div>
						<div class="mb-3">
							<label class="form-label" for="user-type">User Type</label>
							<select id="user-type" class="form-control" disabled>
								<option value="Student">Student</option>
								<option value="Faculty">Faculty</option>
								<option value="Staff">Staff</option>
							</select>
						</div>
						<div class="mb-3">
							<label class="form-label" for="addfullname">Full Name</label>
							<input type="text" id="addfullname" class="form-control" placeholder="John Doe" name="addfullname" aria-label="John Doe" value="<?php echo $userData['FullName']; ?>" disabled />
						</div>
						<div class="mb-3">
							<label class="form-label" for="editusername">Username</label>
							<input type="text" id="editusername" class="form-control" placeholder="username" name="editusername" aria-label="username" value="<?php echo $userData['Username']; ?>" />
						</div>
						<div class="mb-3">
							<label class="form-label" for="currentpassword">Current Password</label>
							<div class="input-group input-group-icon">
								<input type="password" id="currentpassword" name="currentpassword" class="form-control dz-password" placeholder="Current Password">
								<span class="input-group-text show-pass">
									<i class="icon feather icon-eye-off eye-close"></i>
									<i class="icon feather icon-eye eye-open"></i>
								</span>
							</div>
						</div>

						<div class="mb-3">
							<label class="form-label" for="editpassword">Password</label>
							<div class="input-group input-group-icon">
								<input type="password" id="editpassword" name="editpassword" class="form-control dz-password" placeholder="New Password">
								<span class="input-group-text show-pass">
									<i class="icon feather icon-eye-off eye-close"></i>
									<i class="icon feather icon-eye eye-open"></i>
								</span>
							</div>
						</div>
						<div class="mb-3">
							<label class="form-label" for="editconfirmpassword">Confirm Password</label>
							<div class="input-group input-group-icon">
								<input type="password" id="editconfirmpassword" name="editconfirmpassword" class="form-control dz-password" aria-label="confirm password" placeholder="Confirm Password">
								<span class="input-group-text show-pass">
									<i class="icon feather icon-eye-off eye-close"></i>
									<i class="icon feather icon-eye eye-open"></i>
								</span>
							</div>
						</div>

						<!-- Academic Info -->
						<h6 class="dz-title my-2">Academic Info</h6>
						<div class="mb-3">
							<label class="form-label" for="College">College</label>
							<input type="text" id="College" class="form-control" placeholder="College" name="College" aria-label="College" value="<?php echo $userData['College']; ?>" disabled />
						</div>
						<div class="mb-3">
							<label class="form-label" for="Course">Course</label>
							<input type="text" id="Course" class="form-control" placeholder="Course" name="Course" aria-label="Course" value="<?php echo $userData['Course']; ?>" disabled />
						</div>
						<div class="mb-3">
							<img id="preview" src="" alt="Image Preview" style="max-width: 100%; display: none;" />
						</div>

						<div class="mb-3">
							<label class="form-label" for="editclsuaddress">CLSU Address</label>
							<input class="form-control" id="editclsuaddress" name="editclsuaddress" value="<?php echo $userData['CLSU_Address']; ?>" />
						</div>

						<!-- Personal Details -->
						<h6 class="dz-title my-2">Personal Details</h6>
						<div class="mb-3">
							<label class="form-label" for="editcontact">Contact</label>
							<input type="text" class="form-control phone-mask" id="editcontact" name="editcontact" placeholder="+63 988 888 8888" aria-label="+63 988 888 8888" required value="<?php echo $userData['Contact']; ?>" />
						</div>
						<div class="mb-3">
							<label class="form-label" for="edithomeaddress">Home Address</label>
							<textarea class="form-control" id="edithomeaddress" name="edithomeaddress" placeholder="123 Main St, Anytown, PH" aria-label="123 Main St, Anytown, USA" required><?php echo $userData['Home_Address']; ?></textarea>
						</div>
						<div class="mb-3">
							<label class="form-label" for="editlinks">Other Social Links (separated by commas)</label>
							<textarea class="form-control" id="editlinks" name="editlinks" placeholder="m.me/username, viber://add?phonenumber, t.me/username" aria-label="m.me/username, viber://add?phonenumber, t.me/username" required><?php echo $userData['Social_Links']; ?></textarea>
						</div>
						<div class="accordion accordion-primary" id="accordion-one">
							<div class="accordion-item">
								<div class="accordion-header collapsed " id="headingTwo" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-controls="collapseTwo" role="button" aria-expanded="true">
									<span class="accordion-header-text">Why can't I edit some of the details?</span>
									<span class="accordion-header-indicator"></span>
								</div>
								<div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion-one">
									<div class="accordion-body-text ">
										Certain items cannot be edited due to security protocols designed to prevent unauthorized modifications or potential fraudulent activity.
										<br>
										<br>
										To request any changes, please visit the OAD Office and consult with the system administrator or the appropriate staff member.
									</div>

								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</main>

		<!-- Main Content End -->

		<!-- Footer Fixed Button -->
		<div class="footer-fixed-btn bottom-0 bg-white">
			<a href="javascript:void(0);" class="btn btn-lg btn-thin btn-primary rounded-xl w-100" onclick="submitProfileForm()">Update Profile</a>
		</div>
		<!-- Footer Fixed Button -->

		<!-- Modal for Alerts -->
		<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div id="alertModalContent" class="modal-content" style="padding: 20px; font-size: large;">
					<div id="alertModalBody"></div>
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
	<script src="assets/vendor/imageuplodify/imageuploadify.js"></script>
	<script src="assets/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
	<script src="assets/js/dz.carousel.js"></script>
	<script src="assets/js/settings.js"></script>
	<script src="assets/js/custom.js"></script>
	<script>
		function submitProfileForm() {
			var formData = new FormData(document.getElementById('profileForm'));
			document.getElementById('preloader').style.display = 'block';
			$.ajax({
				url: 'update-user-profile.php',
				type: 'POST',
				data: formData,
				contentType: false,
				processData: false,
				success: function(response) {
					document.getElementById('preloader').style.display = 'none';
					let data = JSON.parse(response);
					document.getElementById('alertModalContent').className = data.alertClass;
					document.getElementById('alertModalBody').innerHTML = `<strong>${data.alertTitle}</strong> ${data.message}`;
					new bootstrap.Modal(document.getElementById('alertModal')).show();
					if (data.status === 'success' && data.redirect) {
						setTimeout(() => {
							window.location.href = 'user-profile.php';
						}, 2000);
					}
				},
				error: function(xhr, status, error) {
					document.getElementById('preloader').style.display = 'none';
					showErrorModal('An error occurred while submitting your details. Please try again.');
				}
			});
		}

		function showErrorModal(message, noRedirect = false) {
			const alertModalContent = document.getElementById('alertModalContent');
			const alertModalBody = document.getElementById('alertModalBody');
			alertModalContent.className = 'modal-content alert alert-danger alert-dismissible alert-alt fade show';
			alertModalBody.innerHTML = `<strong>Error!</strong> ${message}`;
			new bootstrap.Modal(document.getElementById('alertModal')).show();
			if (!noRedirect) {
				document.getElementById('preloader').style.display = 'none';
			}
		}

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