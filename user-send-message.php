<?php
require('dbconn.php'); // Include your database connection file

$claimId = $_POST['claim_id'] ?? null;
$senderId = $_POST['sender_id'] ?? null;
$receiverId = $_POST['receiver_id'] ?? null;
$message = $_POST['message'] ?? '';
$messageImage = '';
$timestamp = date('Y-m-d H:i:s', time());

// Handle file upload
if (isset($_FILES['message_image']) && $_FILES['message_image']['error'] === UPLOAD_ERR_OK) {
	$targetDir = "assets/uploads/messages/";
	$targetFile = $targetDir . basename($_FILES["message_image"]["name"]);
	move_uploaded_file($_FILES["message_image"]["tmp_name"], $targetFile);
	$messageImage = $targetFile;
}

// Ensure all necessary data is available
if (!$claimId || !$senderId || !$receiverId) {
	echo json_encode(['status' => 'error', 'message' => 'Missing required parameters.']);
	exit();
}

// Insert message into the database
$stmt = $conn->prepare("INSERT INTO chat_messages (claim_id, sender_id, receiver_id, message, message_image, timestamp) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $claimId, $senderId, $receiverId, $message, $messageImage, $timestamp);
if ($stmt->execute()) {
	echo json_encode(['status' => 'success', 'message' => 'Message sent successfully.']);
} else {
	echo json_encode(['status' => 'error', 'message' => 'Failed to send message.']);
}
exit();
