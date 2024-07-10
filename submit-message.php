<?php
require('dbconn.php');
require('fetch-userid.php');

$claimId = $_POST['claim_id'] ?? null;
$userId = $_SESSION['user_id'] ?? null;

if (!$claimId || !$userId) {
	echo json_encode(['status' => 'error', 'message' => 'Invalid access.']);
	exit();
}

// Fetch claim details
$stmt = $conn->prepare("SELECT * FROM claims WHERE Claim_ID = ?");
$stmt->bind_param("s", $claimId);
$stmt->execute();
$result = $stmt->get_result();
$claim = $result->fetch_assoc();

if (!$claim || $claim['Verification_Status'] != 'Approved') {
	echo json_encode(['status' => 'error', 'message' => 'Claim Invalid']);
	exit();
}

// Fetch claimer details
$stmt = $conn->prepare("SELECT * FROM users WHERE User_ID = ?");
$stmt->bind_param("s", $claim['Claimer_ID']);
$stmt->execute();
$result = $stmt->get_result();
$claimerUser = $result->fetch_assoc();
$claimerUserId = $claimerUser['User_ID'];

// Handle form submission
$message = $_POST['message'] ?? '';
$messageImage = '';

date_default_timezone_set('Asia/Manila');
$timestamp = date('Y-m-d H:i:s');

if (isset($_FILES['message_image']) && $_FILES['message_image']['error'] === UPLOAD_ERR_OK) {
	$targetDir = "assets/uploads/messages/";
	$targetFile = $targetDir . basename($_FILES["message_image"]["name"]);
	move_uploaded_file($_FILES["message_image"]["tmp_name"], $targetFile);
	$messageImage = $targetFile;
}

$stmt = $conn->prepare("INSERT INTO chat_messages (claim_id, sender_id, receiver_id, message, message_image, timestamp) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $claimId, $userId, $claimerUserId, $message, $messageImage, $timestamp);

if ($stmt->execute()) {
	echo json_encode(['status' => 'success', 'message' => $message]);
} else {
	echo json_encode(['status' => 'error', 'message' => 'Failed to save message.']);
}
exit();
