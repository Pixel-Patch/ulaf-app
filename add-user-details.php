<?php
$_SESSION['registration_incomplete'] = true;

$title = "ULAF - Add User Details | PixelPatch";
require("header.php");
?>

<!-- Include the Select2 CSS file -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


<!-- Custom CSS for Select2 -->
<style>
	/* Custom CSS for Select2 */

	/* Change the hover background color of dropdown options */
	.select2-container .select2-results__option--highlighted[aria-selected] {
		background-color: #8FCCA7 !important;
		/* Lighter shade of green */
	}

	/* Increase the height of the dropdown options */
	.select2-container--default .select2-results__option {
		height: 40px;
		/* Adjust this value to increase the height */
		line-height: 30px;
		/* Ensure the text is vertically centered */
	}

	/* Increase the height of the single select dropdown */
	.select2-container--default .select2-selection--single {
		height: 40px;
		/* Adjust this value to increase the height */
		line-height: 40px;
	}

	.select2-container--default .select2-selection--single .select2-selection__rendered {
		line-height: 40px;
		/* Ensure the text is vertically centered */
	}
</style>

</head>

<body class="bg-light">
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
					<h4 class="title">Add User Details</h4>
				</div>
				<div class="right-content"></div>
			</div>
		</header>
		<!-- Header -->

		<!-- Main Content Start -->
		<main class="page-content space-top p-b100">
			<div class="container">
				<!-- Account Details -->
				<h6 class="dz-title my-2">Account Details</h6>
				<div class="mb-3">
					<label class="form-label" for="userId">CLSU ID Number</label>
					<input type="text" id="userId" class="form-control" value="<?php echo $userId; ?>" name="userId" aria-label=" " readonly />
				</div>

				<div class="mb-3">
					<label class="form-label" for="user-type">User Type</label>
					<select id="user-type" class="form-control">
						<option value="Student">Student</option>
						<option value="Faculty">Faculty</option>
						<option value="Staff">Staff</option>
					</select>
				</div>
				<div class="mb-3">
					<label class="form-label" for="addfullname">Full Name</label>
					<input type="text" id="addfullname" class="form-control" placeholder="John Doe" name="addfullname" aria-label="John Doe" />
				</div>

				<!-- Academic Info -->
				<h6 class="dz-title my-2">Academic Info</h6>
				<div class="mb-3">
					<label class="form-label" for="addcollege">College</label>
					<select id="addcollege" name="addcollege" class="form-control">
						<option value="">Select a college</option>
						<option value="College of Agriculture">College of Agriculture</option>
						<option value="College of Arts and Social Sciences">College of Arts and Social Sciences</option>
						<option value="College of Business Administration and Accountancy">College of Business Administration and Accountancy</option>
						<option value="College of Education">College of Education</option>
						<option value="College of Engineering">College of Engineering</option>
						<option value="College of Fisheries">College of Fisheries</option>
						<option value="College of Home Science and Industry">College of Home Science and Industry</option>
						<option value="College of Science">College of Science</option>
						<option value="College of Veterinary Science and Medicine">College of Veterinary Science and Medicine</option>
						<option value="Doctor of Philosophy">Doctor of Philosophy</option>
						<option value="Master of Science">Master of Science</option>
						<option value="Other Masteral Programs">Other Masteral Programs</option>
						<option value="Distance, Open, and Transnational University (DOTUni)">Distance, Open, and Transnational University (DOTUni)</option>
						<option value="Institute of Sports, Physical Education and Recreation">Institute of Sports, Physical Education and Recreation</option>
						<option value="Vocational Course (1-Year Program)">Vocational Course (1-Year Program)</option>
					</select>
				</div>
				<div class="mb-3">
					<label class="form-label" for="addcourse">Course</label>
					<select id="addcourse" name="addcourse" class="form-control">
						<option value="">Select a course</option>
					</select>
				</div>
				<div class="mb-3">
					<label for="addclsuidimage" class="form-label">CLSU ID Image</label>
					<input class="form-control" type="file" id="addclsuidimage" name="addclsuidimage" accept="image/*" capture="camera" />
				</div>
				<div class="mb-3">
					<img id="preview" src="" alt="Image Preview" style="max-width: 100%; display: none;" />
				</div>

				<div class="mb-3">
					<label class="form-label" for="addclsuaddress">CLSU Address</label>
					<input class="form-control" id="addclsuaddress" name="addclsuaddress" />
				</div>

				<!-- Personal Details -->
				<h6 class="dz-title my-2">Personal Details</h6>
				<div class="mb-3">
					<label class="form-label" for="addavatar">Upload Avatar Image</label>
					<input type="file" class="form-control" id="addavatar" name="addavatar" />
				</div>
				<div class="mb-3">
					<label class="form-label" for="addcontact">Contact</label>
					<input type="text" class="form-control phone-mask" id="addcontact" name="addcontact" placeholder="+63 988 888 8888" aria-label="+63 988 888 8888" required />
				</div>
				<div class="mb-3">
					<label class="form-label" for="addhomeaddress">Home Address</label>
					<textarea class="form-control" id="addhomeaddress" name="addhomeaddress" placeholder="123 Main St, Anytown, PH" aria-label="123 Main St, Anytown, USA" required></textarea>
				</div>
				<div class="mb-3">
					<label class="form-label" for="addlinks">Other Social Links (separated by commas)</label>
					<textarea class="form-control" id="addlinks" name="addlinks" placeholder="m.me/username, viber://add?phonenumber, t.me/username" aria-label="m.me/username, viber://add?phonenumber, t.me/username" required></textarea>
				</div>
			</div>
		</main>
		<!-- Main Content End -->

		<!-- Modal -->
		<div class="modal fade" id="exampleModalCenter">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Are you sure you want to submit?</h5>
						<button class="btn-close" data-bs-dismiss="modal">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>
					<div class="modal-body">
						<p>Please review your information carefully before submitting, as some details cannot be edited online once submitted. If you need to make changes to these details in the future, visit the nearest OAD office.</p>
						<p>Accurate information is essential to prevent fraudulent claims and protect your security.</p>
						<p>Thanks for your attention and patience.</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-danger light" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal" onclick="submitSignUp()">Save changes</button>
					</div>
				</div>
			</div>
		</div>

		<!-- Footer Fixed Button -->
		<div class="footer-fixed-btn bottom-0 bg-white">
			<a href="javascript:void(0);" type="submit" name="submitButton" class="btn btn-lg btn-thin btn-primary w-100 rounded-xl" data-bs-toggle="modal" data-bs-target="#exampleModalCenter">Submit</a>
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

		<!--**********************************
Scripts
***********************************-->
		<script src="assets/js/jquery.js"></script>
		<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
		<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
		<script src="assets/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
		<script src="assets/js/dz.carousel.js"></script>
		<script src="assets/js/settings.js"></script>
		<script src="assets/js/custom.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
		<script src="assets/js/select2.js"></script>
		<script>
			function submitSignUp() {
				var formData = new FormData();
				var userId = $('#userId').val();
				var userType = $('#user-type').val();
				var addFullName = $('#addfullname').val();
				var addCollege = $('#addcollege').val();
				var addCourse = $('#addcourse').val();
				var addClsuAddress = $('#addclsuaddress').val();
				var addContact = $('#addcontact').val();
				var addHomeAddress = $('#addhomeaddress').val();
				var addLinks = $('#addlinks').val();
				var addClsuIdImage = $('#addclsuidimage')[0].files[0];
				var addAvatar = $('#addavatar')[0].files[0];

				document.getElementById('preloader').style.display = 'block';

				if (!userId || !userType || !addFullName || !addCollege || !addCourse || !addClsuAddress || !addContact || !addHomeAddress || !addLinks) {
					showErrorModal('All fields are required');
					return;
				}

				formData.append('userId', userId);
				formData.append('user-type', userType);
				formData.append('addfullname', addFullName);
				formData.append('addcollege', addCollege);
				formData.append('addcourse', addCourse);
				formData.append('addclsuaddress', addClsuAddress);
				formData.append('addcontact', addContact);
				formData.append('addhomeaddress', addHomeAddress);
				formData.append('addlinks', addLinks);

				if (addClsuIdImage) formData.append('addclsuidimage', addClsuIdImage);
				if (addAvatar) formData.append('addavatar', addAvatar);

				$.ajax({
					url: 'submit-user-details.php',
					type: 'POST',
					data: formData,
					contentType: false,
					processData: false,
					success: function(response) {
						document.getElementById('preloader').style.display = 'none';
						let data = JSON.parse(response);
						alertModalContent.className = data.alertClass;
						alertModalBody.innerHTML = `<strong>${data.alertTitle}</strong> ${data.message}`;
						new bootstrap.Modal(document.getElementById('alertModal')).show();
						if (data.status === 'success') {
							setTimeout(() => {
								window.location.href = 'index.php';
							}, 2000);
						}
					},
					error: function(xhr, status, error) {
						document.getElementById('preloader').style.display = 'none';
						console.error('Error:', error);
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
		</script>

</body>

</html>