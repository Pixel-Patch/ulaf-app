<?php
require('dbconn.php'); // Include your database connection file
$title = "ULAF - Item Details | PixelPatch";
require("header.php");
require('fetch-userid.php'); // Ensure this file is correctly setting the session data

$claimId = $_GET['claim_id'] ?? null;
$userId = $_SESSION['user_id'] ?? null; // Assuming user ID is stored in session

$pendingClaim = false;
$approveClaim = false;
$declinedClaim = false;
$claimAgain = false;

if ($claimId && $userId) {
	// Fetch claim details
	$claimQuery = "
        SELECT claims.*, items.Item_Name, items.Type, items.Category_ID, items.Image, items.Item_Status, items.Current_Location, categories.Category_Name 
        FROM claims 
        LEFT JOIN items ON claims.Item_ID = items.Item_ID 
        LEFT JOIN categories ON items.Category_ID = categories.Category_ID 
        WHERE claims.Claim_ID = ? AND claims.Claimer_ID = ?";

	$claimDetails = [];
	if ($stmt = $conn->prepare($claimQuery)) {
		$stmt->bind_param("ii", $claimId, $userId);
		$stmt->execute();
		$result = $stmt->get_result();
		$claimDetails = $result->fetch_assoc();
		$stmt->close();
	}

	$images = explode(
		',',
		$claimDetails['Proof_Image']
	);
	$imagesItem = explode(',', $claimDetails['Image']);

	if ($claimDetails) {

		if ($claimDetails['Verification_Status'] === 'Pending') {
			$pendingClaim = true;
		} elseif ($claimDetails['Verification_Status'] === 'Approved') {
			$approveClaim = true;
		} elseif ($claimDetails['Verification_Status'] === 'Declined' && $claimDetails['Claim_Again'] == 0) {
			$declinedClaim = true;
		} elseif ($claimDetails['Verification_Status'] === 'Declined' && $claimDetails['Claim_Again'] == 1) {
			$claimAgain = true;
		}
	}
}

$itemId = $claimDetails['Item_ID'] ?? null;

?>

<style>
	.labels {
		display: flex;
		justify-content: space-between;
		width: 110%;
		margin: 2% -5%;
	}

	.labels span {
		font-size: 14px;
		color: #666;
	}

	.progress {
		width: 100%;
	}

	.swiper {
		margin-bottom: 100px !important;
	}

	.dz-product-detail {
		margin-top: -132px;
	}

	.progress {
		position: relative;
		width: 100%;
		height: 20px;
		background-color: #f3f3f3;
	}

	.progress-bar {
		height: 100%;
		background-color: #007bff;
	}

	.labels {
		display: flex;
		justify-content: space-between;
		margin-top: 10px;
	}

	.labels span {
		font-weight: normal;
		color: gray;
	}

	.responsive-image {
		max-height: 125px;
		max-width: 150px;
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

	.buttonf {
		margin-bottom: -21px;
	}

	.ph {
		font-size: 12px;
	}
</style>
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
		<header class="header header-fixed transparent">
			<div class="header-content">
				<div class="mid-content">
					<h4 class="title">Details</h4>
				</div>
			</div>
		</header>
		<!-- Header -->

		<!-- Main Content Start -->
		<main class="page-content p-b80">
			<div class="container p-0">
				<?php if ($claimDetails) : ?>
					<div class="dz-product-preview bg-primary">
						<div class="swiper product-detail-swiper">
							<div class="swiper-wrapper">
								<div class="swiper-slide">
									<div class="dz-media">
										<img src="assets/uploads/items/<?php echo htmlspecialchars($claimDetails['Image'] ?? 'No image available'); ?>" alt="image">
									</div>
								</div>
								<?php if (!empty($imagesItem)) : ?>
									<?php foreach ($imagesItem as $image) : ?>
										<div class="swiper-slide">
											<div class="dz-media">
												<img src="assets/uploads/items/<?php echo htmlspecialchars(trim($image)); ?>" alt="image">
											</div>
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<div class="dz-product-detail">

						<div class="dz-handle"></div>
						<div class="detail-content">
							<h4 class="title"><?php echo htmlspecialchars($claimDetails['Item_Name']); ?></h4>
							<p><?php echo htmlspecialchars($claimDetails['Category_Name']); ?></p>
						</div>

						<h6>Claim Status:</h6>
						<div class="card-body">
							<div class="progress">
								<div class="progress-bar primary" style="width: 30%;" role="progressbar"></div>
								<div class="progress-circle"></div>
							</div>
							<div class="labels">
								<span id="claiming">Claiming</span>
								<span id="claimed">Claimed</span>
								<span id="retrieving">Retrieving</span>
								<span id="retrieved">Retrieved</span>
							</div>
						</div>

						<div class="item-wrapper">
							<div class="dz-meta-items">
								<!-- Add more item details here if needed -->
							</div>
							<div class="mb-3">
								<label class="form-label" for="editDescription">Proof Description:</label>
								<textarea id="editDescription" class="form-control" name="editDescription" aria-label="editDescription" readonly><?php echo htmlspecialchars($claimDetails['Proof'] ?? 'No proof available'); ?></textarea>
							</div>

							<label class="form-label" for="editProofImages">Proof Images:</label>
							<div class="proof-images">
								<?php if (!empty($images)) : ?>
									<?php foreach ($images as $image) : ?>
										<div class="proof-image">
											<img src="assets/uploads/proofs/<?php echo htmlspecialchars(trim($image)); ?>" alt="Proof Image" style="width:1000px; object-fit: cover;">
										</div>
									<?php endforeach; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>


					<?php if ($pendingClaim) : ?>
						<div class="fixed bg-white">
							<div class="buttonf container">
								<button type="button" class="btn btn-primary btn-lg rounded-xl btn-thin w-100 gap-2" data-bs-toggle="modal" data-bs-target="#claimSubmittedModal">Claim Submitted</button>
							</div>
						</div>
					<?php elseif ($approveClaim) : ?>
						<div class="fixed bg-white">
							<div class="container buttonf">
								<?php if ($claimDetails['Current_Location'] == 'reporter') : ?>
									<button type="button" class="btn btn-primary btn-lg rounded-xl btn-thin w-100 gap-2" onclick="messageNow(<?php echo $itemId; ?>, <?php echo $claimId; ?>)">Message Now</button>
								<?php elseif (in_array($claimDetails['Current_Location'], ['OAd Office', 'USF Office'])) : ?>
									<button type="button" class="btn btn-primary btn-lg rounded-xl btn-thin w-100 gap-2" onclick="claimNow(<?php echo $itemId; ?>, <?php echo $claimId; ?>)">Claim Now</button>

								<?php endif; ?>
							</div>
						</div>

					<?php elseif ($declinedClaim) : ?>
						<div class="fixed bg-white">
							<div class="buttonf container">
								<button type="button" class="btn btn-primary btn-lg rounded-xl btn-thin w-100 gap-2" data-bs-toggle="modal" data-bs-target="#claimAgainModal">Claim again</button>
							</div>
						</div>
					<?php elseif ($claimAgain) : ?>
						<div class="fixed bg-white">
							<div class="buttonf container">
								<button type="button" class="btn btn-danger btn-lg rounded-xl btn-thin w-100 gap-2" data-bs-toggle="modal">Claim Closed</button>
							</div>
						</div>
					<?php else : ?>
						<div class="fixed bg-white">
							<div class="buttonf container">
								<button type="button" class="btn btn-danger btn-lg rounded-xl btn-thin w-100 gap-2" data-bs-toggle="modal">Claim Closed</button>
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

		<!-- Claim Again Modal -->
		<div class="modal fade" id="claimAgainModal">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<input type="hidden" name="item_id" value="<?php echo $itemId; ?>">
						<h5 class="modal-title"><?php echo in_array(strtolower($claimDetails['Item_Status'] ?? ''), ['claimed', 'returning', 'retrieving', 'returned', 'retrieved']) ? 'Dispute Claim' : 'Claim Item'; ?></h5>
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
						<button type="button" class="btn btn-sm btn-primary" onclick="submitClaim()"><?php echo in_array(strtolower($claimDetails['Item_Status'] ?? ''), ['claimed', 'returning', 'retrieving', 'returned', 'retrieved']) ? 'Dispute Claim' : 'Claim Item'; ?></button>
					</div>
				</div>
			</div>
		</div>
		<!-- Claim Now Modal -->
		<div class="modal fade" id="claimNowModal">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Claim Approval</h5>
						<button class="btn-close" data-bs-dismiss="modal">
							<i class="fa-solid fa-xmark"></i>
						</button>
					</div>
					<div class="modal-body">
						<!-- Use PHP to dynamically display the claim details -->
						<center>
							<h5>Congratulations!</h5>
							<h6>
								Your claim #<?php echo $claimId; ?> has been approved.
							</h6>
						</center>
						<br>
						<?php if ($claimDetails['Current_Location'] == 'OAd Office') : ?>
							<p class="ph">Please proceed to the <strong>OAd Office</strong> to claim your item. Remember to bring your ID and a screenshot of this page for verification purposes.</p>
						<?php elseif ($claimDetails['Current_Location'] == 'USF Office') : ?>
							<p class="ph">Please proceed to the <strong>USF Office</strong> to claim your item.
								<br>
								<br>*Remember to bring your ID and a screenshot of this page for verification purposes.
							</p>
						<?php endif; ?>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Close</button>
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
		// get the textarea element for the editpinlocation field
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
						submitClaimAgain(); // Call submitClaimAgain if success
					} else {
						showErrorModal(data.message, true);
					}
				})
				.catch(error => {
					submitClaimAgain(); // Call submitClaimAgain if success
					showSuccessModal('Successfully Claimed Again!');
				});
		}

		function submitClaimAgain() {
			fetch('update-claim-again.php', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({
						claim_id: "<?php echo $claimId; ?>"
					})
				})
				.then(response => response.json())
				.then(data => {
					if (!data.success) {
						showSuccessModal(data.message);
					}
				})
				.catch(error => {
					showErrorModal('An error occurred while updating your claim. Please try again later.', true);
				});
		}
	</script>


	<script>
		document.addEventListener("DOMContentLoaded", function() {
			var claimStatus = "<?php echo htmlspecialchars($claimDetails['Claim_Status'] ?? ''); ?>";
			var claimPercent = 0;
			var boldElementId;

			switch (claimStatus) {
				case 'Claiming':
					claimPercent = 3;
					boldElementId = 'claiming';
					break;
				case 'Claimed':
					claimPercent = 33;
					boldElementId = 'claimed';
					break;
				case 'Retrieving':
					claimPercent = 66;
					boldElementId = 'retrieving';
					break;
				case 'Retrieved':
					claimPercent = 100;
					boldElementId = 'retrieved';
					break;
				default:
					break;
			}

			document.querySelector('.progress-bar').style.width = claimPercent + '%';

			if (boldElementId) {
				var boldElement = document.getElementById(boldElementId);
				boldElement.style.fontWeight = 'bold';
				boldElement.style.color = 'black';
			}
		});
	</script>
	<script>
		function claimNow(itemId, claimId) {
			// Send an AJAX request to submit-claim-now.php
			fetch('submit-claim-now.php?item_id=' + itemId + '&claim_id=' + claimId, {
					method: 'GET'
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						setTimeout(function() {
							// Show the modal after the page reload
							$('#claimNowModal').modal('show');
						}, 1000);
					} else {
						alert('Failed to claim item. Please try again.');
					}
				})
				.catch(error => {
					console.error('Error:', error);
					alert('An error occurred. Please try again.');
				});
		}

		function messageNow(itemId, claimId) {
			// Send an AJAX request to submit-claim-now.php
			fetch('submit-claim-now.php?item_id=' + itemId + '&claim_id=' + claimId, {
					method: 'GET'
				})
				.then(response => response.json())
				.then(data => {
					if (data.success) {
						location.href = 'view-message.php?claim_id=<?php echo $claimId; ?>'

					} else {
						alert('Failed to claim item. Please try again.');
					}
				})
				.catch(error => {
					console.error('Error:', error);
					alert('An error occurred. Please try again.');
				});
		}
	</script>

</body>

</html>