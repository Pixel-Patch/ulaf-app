<?php
require('dbconn.php'); // Include your database connection file
$title = "ULAF - Item Details | PixelPatch";
require("header.php");
require('fetch-userid.php'); // Ensure this file is correctly setting the session data

$claimId = $_GET['claim_id'] ?? null;
$userId = $_SESSION['user_id'] ?? null; // Assuming user ID is stored in session

if (!$claimId || !$userId) {
	die("Invalid access.");
}

// Fetch claim details
$stmt = $conn->prepare("SELECT * FROM claims WHERE Claim_ID = ?");
$stmt->bind_param("s", $claimId);
$stmt->execute();
$result = $stmt->get_result();
$claim = $result->fetch_assoc();

if (!$claim || $claim['Verification_Status'] != 'Approved') {
	die("Claim Invalid");
}

// Fetch item details
$stmt = $conn->prepare("SELECT * FROM items WHERE Item_ID = ?");
$stmt->bind_param("s", $claim['Item_ID']);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

// Fetch user details
$stmt = $conn->prepare("SELECT * FROM users WHERE User_ID = ?");
$stmt->bind_param("s", $claim['Claimer_ID']);
$stmt->execute();
$result = $stmt->get_result();
$claimerUser = $result->fetch_assoc();
$claimerUsername = $claimerUser['Username'];
$claimerUserId = $claimerUser['User_ID'];

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$message = $_POST['message'] ?? '';
	$messageImage = '';

	// Set timezone to PHT (Philippine Time)
	date_default_timezone_set('Asia/Manila');
	$timestamp = date('Y-m-d H:i:s');

	if (isset($_FILES['message_image']) && $_FILES['message_image']['error'] === UPLOAD_ERR_OK) {
		$targetDir = "assets/uploads/messages/";
		$fileExtension = pathinfo($_FILES["message_image"]["name"], PATHINFO_EXTENSION);

		// Get the count of existing files for this claim to generate the counter
		$files = glob($targetDir . $claimId . " - *." . $fileExtension);
		$counter = count($files) + 1;

		// Generate the new file name
		$fileName = $claimId . " - " . date('Y-m-d_H-i-s') . " PHT -" . $counter . "." . $fileExtension;
		$targetFile = $targetDir . $fileName;

		move_uploaded_file($_FILES["message_image"]["tmp_name"], $targetFile);
		$messageImage = $fileName;
	}

	$stmt = $conn->prepare("INSERT INTO chat_messages (claim_id, sender_id, receiver_id, message, message_image, timestamp) VALUES (?, ?, ?, ?, ?, ?)");
	$stmt->bind_param("ssssss", $claimId, $userId, $claimerUserId, $message, $messageImage, $timestamp);
	$stmt->execute();
	header("Location: " . $_SERVER['REQUEST_URI']);
	exit();
}
?>


<style>
	.mb-4 {
		margin-bottom: 0rem !important;
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
		<header class="header header-fixed">
			<div class="header-content">
				<div class="left-content">
					<a href="javascript:void(0);" class="back-btn">
						<i class="feather icon-arrow-left"></i>
					</a>
				</div>
				<div class="mid-content" style="margin-top: 4%;">
					<h4 class="title"><?php echo htmlspecialchars($claimerUsername); ?></h4>
					<p>Claim #<?php echo htmlspecialchars($claimId); ?></p>
				</div>
				<?php if ($userId == $item['Poster_ID']) : ?>
					<div class="dropdown">
						<button type="button" class="btn btn-primary dropdown-toggle show" data-bs-toggle="dropdown" aria-expanded="true"></button>
						<div class="dropdown-menu show" data-popper-placement="bottom-start">
							<a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#claimReturned">Mark as Returned</a>
							<a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#declineModal">Deny Claim</a>
							<a class="dropdown-item">Help ?</a>
						</div>
					</div>
				<?php endif; ?>
			</div>
		</header>
		<!-- Header -->

		<!-- Main Content Start -->
		<main class="page-content space-top p-b60">
			<div class="container">
				<div class="chat-box-area" id="chatBox">
					<?php
					// Fetch chat messages
					$stmt = $conn->prepare("SELECT * FROM chat_messages WHERE claim_id = ? ORDER BY timestamp ASC");
					$stmt->bind_param("s", $claimId);
					$stmt->execute();
					$result = $stmt->get_result();
					$messages = $result->fetch_all(MYSQLI_ASSOC);

					foreach ($messages as $message) {
						$senderClass = $message['sender_id'] == $userId ? 'user' : '';
					?>
						<div class="chat-content <?= $senderClass ?>">
							<div class="message-item">
								<?php if ($message['message_image']) : ?>
									<div class="bubble"><img src="assets/uploads/messages/<?= htmlspecialchars($message['message_image']) ?>" alt="Image"></div>
								<?php endif; ?>
								<?php if ($message['message']) : ?>
									<div class="bubble"><?= htmlspecialchars($message['message']) ?></div>
								<?php endif; ?>
								<div class="message-time"><?= htmlspecialchars(date('h:i A', strtotime($message['timestamp']))) ?></div>
							</div>
						</div>
					<?php
					}
					?>
				</div>
			</div>
		</main>
		<!-- Main Content End -->

	</div>
	<!-- Chat Footer -->
	<div class="chat-footer  fixed bg-white">
		<form id="messageForm" method="POST" enctype="multipart/form-data">
			<div class="form-group boxed">
				<div class="input-wrapper message-area input-lg">
					<div class="append-media"></div>
					<input type="text" name="message" class="form-control" placeholder="Type Message" style="padding-left:16%">
					<!-- File Upload Icon -->
					<a href="javascript:void(0);" class="btn chat-btn" id="fileUpload" style="left: 2%; right:85%; box-shadow: none;">
						<i class="fa-regular fa-paperclip"></i>
					</a>
					<!-- File Upload Icon -->
					<input type="file" name="message_image" id="messageImage" style="display: none;">
					<a href="javascript:void(0);" class="btn chat-btn" id="sendMessage">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M1.49984 21.75C1.33034 21.75 1.16384 21.693 1.02734 21.582C0.81134 21.4065 0.70934 21.126 0.76409 20.8523L2.26409 13.3523C2.32484 13.047 2.56859 12.8108 2.87609 12.7598L7.43759 12L2.87684 11.2395C2.56934 11.1885 2.32559 10.9523 2.26484 10.647L0.76484 3.147C0.70934 2.874 0.81134 2.5935 1.02734 2.418C1.24334 2.2425 1.54184 2.20125 1.79459 2.31075L22.7946 11.3108C23.0713 11.4285 23.2498 11.7 23.2498 12C23.2498 12.3 23.0713 12.5715 22.7953 12.6893L1.79534 21.6893C1.70084 21.7305 1.59959 21.75 1.49984 21.75V21.75Z" fill="#04764E" />
						</svg>
					</a>
				</div>
			</div>
		</form>
	</div>
	<!-- Chat Footer -->

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

	<!-- Claim Modal -->
	<div class="modal fade" id="claimReturned">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<div class="col-12 mb-4">
						<h2 class="mb-4"><?= htmlspecialchars($item['Item_Name']) ?></h2>
						<h6 class="mb-4">Claim ID #<?php echo $claimId; ?></h6>
					</div>
					<input type="hidden" id="item_id" name="item_id" value="<?= htmlspecialchars($item['Item_ID']) ?>">
					<input type="hidden" id="claimer_id" name="claimer_id" value="<?= htmlspecialchars($claim['Claimer_ID']) ?>">
					<h5 class="modal-title"></h5>
					<button class="btn-close" data-bs-dismiss="modal">
						<i class="fa-solid fa-xmark"></i>
					</button>
				</div>
				<div class="modal-body">
					<form id="claim-form">
						<div class="mb-3">
							<label for="returnedImage" class="form-label">Upload Proof of Returned Images</label>
							<input type="file" class="form-control" id="returnedImage" name="returnedImage[]" multiple>
						</div>
						<div class="divider inner-divider transparent mb-0"><span>or</span></div>
						<div class="mb-3">
							<label for="remarks" class="form-label">Remarks</label>
							<textarea id="remarks" name="remarks" class="form-control" rows="3" placeholder="Type remarks here"></textarea>
						</div>
					</form>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">Close</button>
					<button type="button" class="btn btn-sm btn-primary" onclick="submitClaim()">Submit</button>
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

	<!-- Scripts -->
	<script src="assets/js/jquery.js"></script>
	<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
	<script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
	<script src="assets/vendor/bootstrap-touchspin/dist/jquery.bootstrap-touchspin.min.js"></script>
	<script src="assets/vendor/jquery-listview/js/mobiscroll.jquery.min.js"></script>
	<script src="assets/js/dz.carousel.js"></script>
	<script src="assets/js/settings.js"></script>
	<script src="assets/js/custom.js"></script>

	<script>
		$(document).ready(function() {
			// Function to scroll to the latest message
			function scrollToLatestMessage() {
				const chatBox = document.getElementById('chatBox');
				chatBox.scrollTop = chatBox.scrollHeight;
			}

			// Function to handle form submission
			function submitMessageForm() {
				let formData = new FormData($("#messageForm")[0]);

				$.ajax({
					url: window.location.href,
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					success: function(response) {
						appendMessageToChatBox();
						clearMessageForm();
						scrollToLatestMessage();
					},
					error: function(xhr, status, error) {
						console.error(xhr.responseText);
					}
				});
			}

			// Function to append the message to the chat box
			function appendMessageToChatBox() {
				let message = $("input[name='message']").val();
				let messageImage = $("#messageImage")[0].files[0];
				let messageContent = message ? `<div class="bubble">${message}</div>` : '';
				if (messageImage) {
					messageContent += `<div class="bubble"><img src="assets/uploads/messages/${messageImage.name}" alt="Image"></div>`;
				}

				$(".chat-box-area").append(`
            <div class="chat-content user">
                <div class="message-item">
                    ${messageContent}
                    <div class="message-time">Now</div>
                </div>
            </div>
        `);
			}

			// Function to clear the message form
			function clearMessageForm() {
				$("input[name='message']").val('');
				$("#messageImage").val('');
			}

			// Click event for file upload icon
			$("#fileUpload").click(function() {
				$("#messageImage").click();
			});

			// Click event for sending the message
			$("#sendMessage").click(function(event) {
				event.preventDefault();
				submitMessageForm();
			});

			// Press Enter to send the message
			$("input[name='message']").keypress(function(event) {
				if (event.which == 13) {
					event.preventDefault();
					submitMessageForm();
				}
			});

			// MutationObserver to detect new messages added to the chat box and scroll to the latest message
			const chatBox = document.getElementById('chatBox');
			const observer = new MutationObserver(scrollToLatestMessage);
			observer.observe(chatBox, {
				childList: true
			});

			// Scroll to the latest message on page load
			scrollToLatestMessage();
		});

		// Modal alert functions
		function showModal(type, message, itemId) {
			const alertModalContent = document.getElementById('alertModalContent');
			const alertModalBody = document.getElementById('alertModalBody');
			let modalClass = '';
			let modalTitle = '';

			switch (type) {
				case 'error':
					modalClass = 'alert alert-danger';
					modalTitle = 'Error!';
					break;
				case 'warning':
					modalClass = 'alert alert-warning';
					modalTitle = 'Warning!';
					break;
				case 'success':
					modalClass = 'alert alert-success';
					modalTitle = 'Success!';
					break;
			}

			alertModalContent.className = `modal-content ${modalClass} alert-dismissible alert-alt fade show`;
			alertModalBody.innerHTML = `<strong>${modalTitle}</strong> ${message}`;
			new bootstrap.Modal(document.getElementById('alertModal')).show();

			if (type === 'success' && itemId) {
				setTimeout(() => {
					window.location.href = `view-my-post-claims.php?item_id=${itemId}`;
				}, 2000);
			}
		}

		function showErrorModal(message, noRedirect = false) {
			showModal('error', message);
			if (!noRedirect) {
				document.getElementById('preloader').style.display = 'none';
			}
		}

		function showWarningModal(message, noRedirect = false) {
			showModal('warning', message);
			if (!noRedirect) {
				document.getElementById('preloader').style.display = 'none';
			}
		}

		function showSuccessModal(message, itemId) {
			showModal('success', message, itemId);
		}

		function declineClaim() {
			const claimId = '<?php echo $claimId; ?>';
			window.location.href = `decline-claim.php?claimId=${claimId}`;
		}

		function submitClaim() {
			var form = document.getElementById('claim-form');
			var formData = new FormData(form);

			// Append the hidden input values to the FormData
			formData.append('item_id', document.getElementById('item_id').value);
			formData.append('claimer_id', document.getElementById('claimer_id').value);
			formData.append('claim_id', '<?= $claimId; ?>');

			var xhr = new XMLHttpRequest();
			xhr.open('POST', 'submit-return.php', true);

			xhr.onload = function() {
				if (xhr.status === 200) {
					var response = JSON.parse(xhr.responseText);
					if (response.success) {
						showSuccessModal('Claim submitted successfully!', response.item_id);

						// Redirect to view-my-post-claims.php?item_id=${itemId}
						var itemId = response.item_id; // Make sure itemId is the correct variable
						window.location.href = `view-my-post-claims.php?item_id=<?= htmlspecialchars($item['Item_ID']) ?>`;
					} else {
						showErrorModal(response.message);
					}
				} else {
					showErrorModal('An error occurred while submitting the claim.');
				}
			};

			xhr.onerror = function() {
				showErrorModal('An error occurred while submitting the claim.');
			};

			xhr.send(formData);
		}
	</script>
</body>

</html>