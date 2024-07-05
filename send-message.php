<?php
require('dbconn.php'); // Include your database connection file
session_start();

$claimId = $_POST['claim_id'] ?? null;
$message = $_POST['message'] ?? null;
$receiverId = $_POST['receiver_id'] ?? null;
$userId = $_SESSION['user_id'] ?? null; // Assuming user ID is stored in session
$messageImage = $_FILES['message_image'] ?? null;

if (!$claimId || !$receiverId || !$userId || (!$message && !$messageImage)) {
	die("Invalid input.");
}

$imagePath = null;
if ($messageImage) {
	$targetDir = "assets/uploads/messages/";
	$imagePath = $targetDir . basename($messageImage["name"]);
	if (!move_uploaded_file($messageImage["tmp_name"], $imagePath)) {
		die("Failed to upload image.");
	}
}

try {
	$stmt = $conn->prepare("INSERT INTO chat_messages (claim_id, sender_id, receiver_id, message, message_image, timestamp) VALUES (?, ?, ?, ?, ?, NOW())");
	$stmt->bind_param("iiiss", $claimId, $userId, $receiverId, $message, $imagePath);
	$stmt->execute();
	echo "Message sent successfully.";
} catch (mysqli_sql_exception $e) {
	echo "Error: " . $e->getMessage();
}
