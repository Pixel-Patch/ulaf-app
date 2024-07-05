<?php
require('dbconn.php'); // Include your database connection file
$title = "ULAF - Item Claims Details | PixelPatch";
require("header.php");
require('fetch-userid.php'); // Ensure this file is correctly setting the session data

$itemId = $_GET['item_id'] ?? null;

// Fetch item details
$itemQuery = "
        SELECT items.*, categories.Category_Name 
        FROM items 
        LEFT JOIN categories ON items.Category_ID = categories.Category_ID 
        WHERE items.Item_ID = ?
        LIMIT 1";

$itemDetails = [];
if ($stmt = $conn->prepare($itemQuery)) {
	$stmt->bind_param("i", $itemId);
	$stmt->execute();
	$result = $stmt->get_result();
	$itemDetails = $result->fetch_assoc();
	$stmt->close();
}

if ($itemDetails) {
	$images = explode(',', $itemDetails['Image']);
	$isPoster = $itemDetails['Poster_ID'] == $userId;
}

// Fetch claims for this specific item
$itemClaims = [];
$claimsQuery = "
    SELECT claims.Claim_ID, claims.Claim_Status, claims.Proof, claims.Proof_Image, claims.Claim_Date, claims.Verification_Status, claims.Verification_Date, users.Username
    FROM claims 
    JOIN users ON claims.Claimer_ID = users.User_ID
    WHERE claims.Item_ID = ?
    ORDER BY claims.Claim_Date DESC";

if ($stmt = $conn->prepare($claimsQuery)) {
	$stmt->bind_param("i", $itemId);
	$stmt->execute();
	$result = $stmt->get_result();

	while ($row = $result->fetch_assoc()) {
		$itemClaims[] = $row;
	}
	$stmt->close();
}

?>

<style>
	.swiper {
		margin-bottom: 100px !important;
	}

	.dz-product-detail {
		margin-top: -122px;
	}

	#map {
		height: 300px;
		width: 100%;
	}

	.dz-media {
		max-width: 100%;
		max-height: 500px;
		overflow: hidden;
	}

	.dz-media img {
		width: 100%;
		height: 100%;
		object-fit: cover;
	}

	.right-content {
		position: absolute;
		top: 0;
		right: 0;
		padding: 10px;
		margin-right: 10px;
		margin-top: 5px;
	}

	.responsive-image {
		max-height: 125px;
		max-width: 150px;
		object-fit: cover;
	}
</style>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCzWcAbNuR8iS50rrGnYD-aLfuULyuaQ9s&libraries=places" async></script>

<link rel="stylesheet" href="assets/vendor/swiper/swiper-bundle.min.css">
<script>
	function initMap() {
		const location = {
			lat: <?php echo $itemDetails['Latitude']; ?>,
			lng: <?php echo $itemDetails['Longitude']; ?>
		};
		const map = new google.maps.Map(document.getElementById('map'), {
			zoom: 19,
			center: location
		});
		const marker = new google.maps.Marker({
			position: location,
			map: map
		});
	}
</script>
</head>

<body onload="initMap()">
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

				<div class="mid-content">
					<h4 class="title">Item Claims</h4>
				</div>

			</div>
		</header>
		<!-- Header -->

		<!-- Main Content Start -->
		<main class="page-content p-b80">
			<div class="container p-0">
				<?php if ($itemDetails) : ?>
					<div class="dz-product-preview bg-primary">
						<div class="swiper product-detail-swiper">
							<div class="swiper-wrapper">
								<?php foreach ($images as $image) : ?>
									<div class="swiper-slide">
										<div class="dz-media">
											<img src="assets/uploads/items/<?php echo htmlspecialchars(trim($image)); ?>" alt="image">
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>


					<div class="dz-product-detail">
						<div class="dz-handle"></div>
						<a href="edit-item-details.php?item_id=<?php echo $itemId  ?>">
							<div class="right-content d-flex align-items-center gap-4">
								<svg enable-background="new 0 0 461.75 461.75" height="18" viewBox="0 0 461.75 461.75" width="18" xmlns="http://www.w3.org/2000/svg">
									<path d="m23.099 461.612c2.479-.004 4.941-.401 7.296-1.177l113.358-37.771c3.391-1.146 6.472-3.058 9.004-5.587l226.67-226.693 75.564-75.541c9.013-9.016 9.013-23.63 0-32.645l-75.565-75.565c-9.159-8.661-23.487-8.661-32.645 0l-75.541 75.565-226.693 226.67c-2.527 2.53-4.432 5.612-5.564 9.004l-37.794 113.358c-4.029 12.097 2.511 25.171 14.609 29.2 2.354.784 4.82 1.183 7.301 1.182zm340.005-406.011 42.919 42.919-42.919 42.896-42.896-42.896zm-282.056 282.056 206.515-206.492 42.896 42.896-206.492 206.515-64.367 21.448z" fill="#808080"></path>
								</svg>
						</a>

					</div>
					<div class="detail-content">
						<h4 class="title"><?php echo htmlspecialchars($itemDetails['Item_Name']); ?></h4>
						<p><?php echo htmlspecialchars($itemDetails['Category_Name']); ?></p>
						<label class="form-label" for="Item Status">Item Status :</label>
						<span class="badge light badge-info" style="font-size: 18px;"><?php echo htmlspecialchars($itemDetails['Item_Status']); ?></span>

						<br>
						<br>

						<h3>Claims for this Item</h3>
						<?php if (empty($itemClaims)) : ?>
							<p class="no-claims-message">There are no claims for this item at the moment.</p>
						<?php else : ?>
							<br>
							<ul class="featured-list">
								<div class="row g-3">
									<?php foreach ($itemClaims as $claim) : ?>
										<div class="col-12 col-sm-12">
											<div class="dz-wishlist-bx">
												<div class="dz-media">
													<a href="view-verify-claims.php?claim_id=<?php echo $claim['Claim_ID']; ?>" style="display: flex; align-items: center; justify-content: center; height: 100px;">
														<?php if (!empty($claim['Proof_Image'])) : ?>
															<img src="assets/uploads/proofs/<?php echo htmlspecialchars($claim['Proof_Image']); ?>" alt="Proof Image" class="responsive-image">
														<?php else : ?>
															<p style="margin: 0;">No Image Available</p>
														<?php endif; ?>
													</a>


												</div>
												<div class="dz-info">
													<br>
													<div class="dz-head">
														<p>Claim # <?php echo $claim['Claim_ID']; ?></p>
														<h6 class="title"><a href="view-my-claim-details.php?claim_id=<?php echo $claim['Claim_ID']; ?>"><?php echo htmlspecialchars($itemDetails['Item_Name']); ?></a></h6>
														<br>
														<?php
														if ($claim['Verification_Status'] == 'Pending') {
															echo '<span class="badge badge-info" style="font-size: 18px; position: absolute; bottom: 0; right: 0; margin-right: 17px; margin-bottom: 14px;">Pending</span>';
														} elseif ($claim['Verification_Status'] == 'Declined') {
															echo '<span class="badge badge-dark" style="font-size: 18px; position: absolute; bottom: 0; right: 0; margin-right: 17px; margin-bottom: 14px;" >Declined</span>';
														} elseif ($claim['Verification_Status'] == 'Approved') {
															echo '<span class="badge badge-success" style="font-size: 18px; position: absolute; bottom: 0; right: 0; margin-right: 17px; margin-bottom: 14px;" >Approved</span>';
														}
														?>
													</div>
												</div>
											</div>
										</div>
									<?php endforeach; ?>
								</div>
							</ul>
						<?php endif; ?>
					</div>
			</div>
		<?php else : ?>
			<div class="alert alert-danger" role="alert">
				Item not found.
			</div>
		<?php endif; ?>
	</div>
	</main>
	<!-- Main Content End -->



	<div class="footer fixed bg-white">
		<div class="container">
			<a href="view-my-post-claims.php?item_id=<?php echo $itemId; ?>" class="btn btn-primary btn-lg rounded-xl btn-thin w-100 gap-2">View My Post Claims</a>
		</div>
	</div>



	<!-- Claim Submitted Modal -->
	<div class="modal fade" id="claimSubmittedModal">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Claim Status</h5>
					<button class="btn-close" data-bs-dismiss="modal">
						<i class="fa-solid fa-xmark"></i>
					</button>
				</div>
				<div class="modal-body">
					<p>We appreciate your interest in claiming this item. However, it appears that you have already submitted a claim for this item. We kindly ask for your patience as the item founder verifies your claim.</p>
					<p>Once your claim has been processed, you will be notified of the outcome. If your claim is declined, you will have the opportunity to submit a new claim and retry your attempt to claim the item.</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Claim Modal -->
	<div class="modal fade" id="claimModal">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<input type="hidden" name="item_id" value="<?php echo $itemId; ?>">
					<h5 class="modal-title"><?php echo in_array(strtolower($itemDetails['Item_Status']), ['claimed', 'returning', 'retrieving', 'returned', 'retrieved']) ? 'Dispute Claim' : 'Claim Item'; ?></h5>
					<button class="btn-close" data-bs-dismiss="modal">
						<i class="fa-solid fa-xmark"></i>
					</button>
				</div>
				<div class="modal-body">
					<form id="claim-form">
						<div class="mb-3">
							<label for="distinguishableMarks" class="form-label">Distinguishable Marks</label>
							<textarea id="distinguishableMarks" name="distinguishableMarks" class="form-control" rows="3" placeholder="Describe any unique marks or features on the item"></textarea>
						</div>
						<div class="mb-3">
							<label for="proofImage" class="form-label">Upload Proof Images</label>
							<input type="file" class="form-control" id="proofImage" name="proofImages[]" multiple>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="submitClaim()"><?php echo in_array(strtolower($itemDetails['Item_Status']), ['claimed', 'returning', 'retrieving', 'returned', 'retrieved']) ? 'Dispute Claim' : 'Claim Item'; ?></button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal for alerts -->
	<div class="modal fade" id="alertModal" tabindex="-1" role="dialog" aria-labelledby="alertModalCenterTitle" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div id="alertModalContent" class="modal-content" style="padding: 20px; font-size: large;">
				<div id="alertModalBody"></div>
			</div>
		</div>
	</div>

	</div>
	<!-- Scripts -->
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
	<script>

	</script>
	<script>
		// get the textarea element for the editDescription field
		const textarea = document.getElementById('editDescription');

		// set the height of the textarea to the height of its scrollHeight
		textarea.style.height = 'auto';
		textarea.style.height = textarea.scrollHeight + 'px';

		// listen for changes to the textarea value and update the height accordingly
		textarea.addEventListener('input', () => {
			textarea.style.height = 'auto';
			textarea.style.height = textarea.scrollHeight + 'px';
		});

		// get the textarea element for the editpinlocation field
		const pinTextarea = document.getElementById('editpinlocation');

		// set the height of the textarea to the height of its scrollHeight
		pinTextarea.style.height = 'auto';
		pinTextarea.style.height = pinTextarea.scrollHeight + 'px';

		// listen for changes to the textarea value and update the height accordingly
		pinTextarea.addEventListener('input', () => {
			pinTextarea.style.height = 'auto';
			pinTextarea.style.height = pinTextarea.scrollHeight + 'px';
		});

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

		function showWarningModal(message, noRedirect = false) {
			const alertModalContent = document.getElementById('alertModalContent');
			const alertModalBody = document.getElementById('alertModalBody');
			alertModalContent.className = 'modal-content alert alert-warning alert-dismissible alert-alt fade show';
			alertModalBody.innerHTML = `<strong>Warning!</strong> ${message}`;
			new bootstrap.Modal(document.getElementById('alertModal')).show();
			if (!noRedirect) {
				document.getElementById('preloader').style.display = 'none';
			}
		}

		function showSuccessModal(message) {
			const alertModalContent = document.getElementById('alertModalContent');
			const alertModalBody = document.getElementById('alertModalBody');
			alertModalContent.className = 'modal-content alert alert-success alert-dismissible alert-alt fade show';
			alertModalBody.innerHTML = `<strong>Success!</strong> ${message}`;
			new bootstrap.Modal(document.getElementById('alertModal')).show();
			setTimeout(() => {
				window.location.href = 'index.php';
			}, 2000);
		}

		function submitClaim() {
			// Get form data
			const form = document.getElementById('claim-form');
			const formData = new FormData(form);

			// Append the item ID
			formData.append('item_id', "<?php echo $itemId; ?>");

			// Send the request
			fetch('submit-claim.php', {
					method: 'POST',
					body: formData
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						showSuccessModal(data.message);
					} else {
						showErrorModal(data.message, true);
					}
				})
				.catch(error => {
					showErrorModal('An error occurred while submitting your claim. Please try again later.', true);
				});
		}
	</script>

</body>

</html>