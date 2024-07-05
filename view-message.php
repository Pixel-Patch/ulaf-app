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
$stmt->bind_param("i", $claimId);
$stmt->execute();
$result = $stmt->get_result();
$claim = $result->fetch_assoc();

if (!$claim || $claim['Verification_Status'] != 'Approved') {
	die("Claim Invalid");
}

// Fetch item details
$stmt = $conn->prepare("SELECT * FROM items WHERE Item_ID = ?");
$stmt->bind_param("i", $claim['Item_ID']);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

// Fetch user details
$stmt = $conn->prepare("SELECT * FROM users WHERE User_ID = ?");
$stmt->bind_param("i", $claim['Claimer_ID']);
$stmt->execute();
$result = $stmt->get_result();
$claimerUser = $result->fetch_assoc();
$claimerUsername = $claimerUser['Username'];
$claimerUserId = $claimerUser['User_ID'];
?>
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
				<div class="right-content d-flex align-items-center gap-4">
					<a href="javascript:void(0);" class="font-24">
						<i class="font-w700 feather icon-more-vertical-"></i>
					</a>
				</div>
			</div>
		</header>
		<!-- Header -->

		<!-- Main Content Start -->
		<main class="page-content space-top p-b60">
			<div class="container">
				<div class="chat-box-area">
					<?php
					// Fetch chat messages
					$stmt = $conn->prepare("SELECT * FROM chat_messages WHERE claim_id = ? ORDER BY timestamp ASC");
					$stmt->bind_param("i", $claimId);
					$stmt->execute();
					$result = $stmt->get_result();
					$messages = $result->fetch_all(MYSQLI_ASSOC);

					foreach ($messages as $message) {
						$senderClass = $message['sender_id'] == $userId ? 'user' : '';
					?>
						<div class="chat-content <?= $senderClass ?>">
							<div class="message-item">
								<?php if ($message['message_image']) : ?>
									<div class="bubble"><img src="<?= htmlspecialchars($message['message_image']) ?>" alt="Image"></div>
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

		<!-- Chat Footer -->
		<div class="chat-footer">
			<form id="messageForm" enctype="multipart/form-data">
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
	</div>
	<!--**********************************
    Scripts
***********************************-->
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
			$("#fileUpload").click(function() {
				$("#messageImage").click();
			});

			$("#messageForm").submit(function(event) {
				event.preventDefault();

				let formData = new FormData(this);
				formData.append('claim_id', <?php echo json_encode($claimId); ?>);
				formData.append('receiver_id', <?php echo json_encode($claimerUserId); ?>);

				$.ajax({
					url: "user-send-message.php",
					type: "POST",
					data: formData,
					contentType: false,
					processData: false,
					success: function(response) {
						console.log(response);
						// Add logic to append the message to the chat box
						let message = $("input[name='message']").val();
						let messageImage = $("#messageImage")[0].files[0];
						let messageContent = message ? `<div class="bubble">${message}</div>` : (messageImage ? `<div class="bubble"><img src="uploads/${messageImage.name}" alt="Image"></div>` : '');

						$(".chat-box-area").append(`
                            <div class="chat-content user">
                                <div class="message-item">
                                    ${messageContent}
                                    <div class="message-time">Now</div>
                                </div>
                            </div>
                        `);
						$("input[name='message']").val('');
						$("#messageImage").val('');
					},
					error: function(xhr, status, error) {
						console.error(xhr.responseText);
					}
				});
			});
		});
	</script>
</body>

</html>