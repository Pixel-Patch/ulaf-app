<?php
require('dbconn.php'); // Include your database connection file
$title = "ULAF - Item Details | PixelPatch";
require("header.php");
require('fetch-userid.php'); // Ensure this file is correctly setting the session data

$claimId = $_GET['claim_id'] ?? null;
$userId = $_SESSION['user_id'] ?? null; // Assuming user ID is stored in session

$claimDetails = null;

if ($claimId && $userId) {
	// Fetch claim details
	$stmt = $conn->prepare("
        SELECT 
            claims.Claim_ID, claims.Item_ID, claims.Claimer_ID, claims.Claim_Status, claims.Proof, claims.Proof_Image, 
            claims.Claim_Date, claims.Verification_Status, claims.Verification_Date, claims.Claim_Again,
            items.Item_Name, items.Image, items.Type, items.Category_ID, items.Description, items.Pin_Location, 
            items.Posted_Date, items.Current_Location, items.Poster_ID, items.Item_Status, items.Latitude, items.Longitude, 
            items.Retrieved_By, items.Retrieved_Date, categories.Category_Name
        FROM claims
        INNER JOIN items ON claims.Item_ID = items.Item_ID
        INNER JOIN categories ON items.Category_ID = categories.Category_ID
        WHERE claims.Claim_ID = ?
    ");
	$stmt->bind_param("i", $claimId);
	$stmt->execute();
	$result = $stmt->get_result();

	if ($result->num_rows > 0) {
		$claimDetails = $result->fetch_assoc();
		// Check if the user has permission to view this claim
		if ($claimDetails['Poster_ID'] != $userId) {
			$claimDetails = null;
		}
	}
	$stmt->close();
}

$images = $claimDetails ? explode(',', $claimDetails['Proof_Image']) : [];
$imagesItem = $claimDetails ? explode(',', $claimDetails['Image']) : [];

$verificationStatus = htmlspecialchars($claimDetails['Verification_Status']);
$claimId = htmlspecialchars($claimId); // Ensure $claimId is sanitized

$pendingClaim = $approveClaim = $declinedClaim = false;

if ($claimDetails) {
	if ($verificationStatus === 'Pending') {
		$pendingClaim = true;
	} elseif ($verificationStatus === 'Approved') {
		$approveClaim = true;
	} elseif ($verificationStatus === 'Declined') {
		$declinedClaim = true;
	}
}
?>

<style>
	.dz-product-detail {
		margin-top: -29px;

	}

	.buttonf {
		padding-bottom: 0px;
		margin-top: 7px;

	}

	.dz-product-detail .item-wrapper {
		margin-bottom: -28px;
	}
</style>
</head>

<body>
	<div class="page-wrapper">
		<!-- Header -->
		<header class="header header-fixed transparent">
			<!-- Your header content -->
		</header>
		<!-- Header end-->

		<!-- Main Content Start -->
		<main class="page-content p-b80">
			<div class="container p-0">
				<?php if ($claimDetails) : ?>
					<!-- Display item details -->
					<div class="dz-product-preview bg-primary">
						<!-- Swiper slider for item images -->
						<div class="swiper product-detail-swiper">
							<div class="swiper-wrapper">
								<?php foreach ($imagesItem as $imageItem) : ?>
									<div class="swiper-slide">
										<div class="dz-media">
											<img src="assets/uploads/items/<?php echo htmlspecialchars(trim($imageItem)); ?>" alt="image">
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<div class="dz-product-detail">
						<!-- Item details section -->
						<div class="dz-handle"></div>
						<div class="detail-content">
							<h4 class="title"><?php echo htmlspecialchars($claimDetails['Item_Name']); ?></h4>
							<p><?php echo htmlspecialchars($claimDetails['Category_Name']); ?></p>
						</div>
						<div class="item-wrapper">
							<div class="dz-meta-items">
								<!-- Additional item details if needed -->
							</div>
							<div class="mb-3">
								<label class="form-label" for="editDescription">Proof Description:</label>
								<textarea id="editDescription" class="form-control" name="editDescription" aria-label="editDescription" readonly><?php echo htmlspecialchars($claimDetails['Proof'] ?? 'No proof available'); ?></textarea>
							</div>

							<label class="form-label" for="editProofImages">Proof Images:</label>
							<div class="proof-images">
								<?php foreach ($images as $image) : ?>
									<div class="proof-image">
										<img src="assets/uploads/proofs/<?php echo htmlspecialchars(trim($image)); ?>" alt="Proof Image" style="width:1000px; object-fit: cover;">
									</div>
								<?php endforeach; ?>
							</div>
						</div>
					</div>

					<?php
					// Conditional footer based on Claim_Status
					if ($claimDetails['Claim_Status'] === 'Returned' || $claimDetails['Claim_Status'] === 'Retrieved') :
						$buttonText = ($claimDetails['Claim_Status'] === 'Returned') ? 'Item Returned' : 'Item Retrieved';
					?>
						<div class="fixed bg-white">
							<div class="container buttonf">
								<button type="button" class="btn btn-info btn-lg rounded-xl btn-thin w-100 gap-2"><?php echo $buttonText; ?></button>
							</div>
						</div>
					<?php elseif ($declinedClaim) : ?>
						<div class="fixed bg-white">
							<div class="container buttonf">
								<button type="button" class="btn btn-danger btn-lg rounded-xl btn-thin w-100 gap-2" data-bs-toggle="modal">Declined : Claim Closed</button>
							</div>
						</div>
					<?php elseif ($approveClaim) : ?>
						<div class="fixed bg-white">
							<div class="container buttonf">
								<button type="button" class="btn btn-primary btn-lg rounded-xl btn-thin w-100 gap-2" onclick="location.href='view-message.php?claim_id=<?php echo $claimId; ?>'">Message Now</button>
							</div>
						</div>
					<?php elseif ($pendingClaim) : ?>
						<div class="fixed bg-white">
							<div class="container buttonf">
								<div class="row">
									<div class="col-1"></div>
									<div class="col-4 px-0">
										<button type="button" class="btn btn-danger btn-xs rounded-xl btn-thin w-100 gap-2" style="font-size: 13.5px !important" data-bs-toggle="modal" data-bs-target="#declineModal">Decline Claim</button>
									</div>
									<div class="col-2"></div>
									<div class="col-4 px-0">
										<button type="button" class="btn btn-success btn-xs rounded-xl btn-thin w-100 gap-2" style="font-size: 13.5px !important" data-bs-toggle="modal" data-bs-target="#approveModal">Approve Claim</button>
									</div>
								</div>
							</div>
						</div>
					<?php endif; ?>

				<?php else : ?>
					<p>Item not found or you do not have permission to view this item.</p>
				<?php endif; ?>
			</div>
		</main>
		<!-- Main Content End -->

		<!-- Menubar -->
		<?php include('menubar.php'); ?>
		<!-- Menubar -->

		<!-- Modals for Decline and Approve -->
		<!-- Decline Claim Modal -->
		<div class="modal fade" id="declineModal">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Decline Claim</h5>
						<button class="btn-close" data-bs-dismiss="modal">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to decline claim # <?php echo $claimId; ?>?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-sm btn-danger" onclick="declineClaim()">Decline</button>
					</div>
				</div>
			</div>
		</div>



		<!-- Your existing modals for decline and approve -->

		<!-- Approve Claim Modal -->
		<div class="modal fade" id="approveModal">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Approve Claim</h5>
						<button class="btn-close" data-bs-dismiss="modal">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to approve claim # <?php echo $claimId; ?>?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
						<button type="button" class="btn btn-sm btn-success" onclick="approveClaim()">Approve</button>
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
	<script>
		// get the textarea element for the editDescription field
		const pinTextarea = document.getElementById('editDescription');

		// set the height of the textarea to the height of its scrollHeight
		pinTextarea.style.height = 'auto';
		pinTextarea.style.height = pinTextarea.scrollHeight + 'px';

		// listen for changes to the textarea value and update the height accordingly
		pinTextarea.addEventListener('input', () => {
			pinTextarea.style.height = 'auto';
			pinTextarea.style.height = pinTextarea.scrollHeight + 'px';
		});
	</script>
	<script>
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

		function declineClaim() {
			const claimId = '<?php echo $claimId; ?>';
			window.location.href = `decline.php?claimId=${claimId}`;
		}

		function approveClaim() {
			const claimId = '<?php echo $claimId; ?>';
			window.location.href = `approve.php?claimId=${claimId}`;
		}
	</script>

</body>

</html>