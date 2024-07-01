<?php
session_start();
require('dbconn.php');

if (!isset($_SESSION['user_id'])) {
	sendResponse('error', 'Error!', 'User is not logged in.', false);
}

$userId = $_SESSION['user_id'];
$role = filter_input(INPUT_POST, 'user-type', FILTER_SANITIZE_STRING);
$fullName = filter_input(INPUT_POST, 'addfullname', FILTER_SANITIZE_STRING);
$college = filter_input(INPUT_POST, 'addcollege', FILTER_SANITIZE_STRING);
$course = filter_input(INPUT_POST, 'addcourse', FILTER_SANITIZE_STRING);
$clsuAddress = filter_input(INPUT_POST, 'addclsuaddress', FILTER_SANITIZE_STRING);
$contact = filter_input(INPUT_POST, 'addcontact', FILTER_SANITIZE_STRING);
$homeAddress = filter_input(INPUT_POST, 'addhomeaddress', FILTER_SANITIZE_STRING);
$socialLinks = filter_input(INPUT_POST, 'addlinks', FILTER_SANITIZE_STRING);

function sendResponse($status, $title, $message, $redirect = true)
{
	echo json_encode([
		'status' => $status,
		'alertClass' => 'modal-content alert alert-' . $status . ' alert-dismissible alert-alt fade show',
		'alertTitle' => $title,
		'message' => $message,
		'redirect' => $redirect
	]);
	exit();
}

function uploadFile($file, $path, $userId)
{
	$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
	$fileName = $file['name'];
	$fileTmpName = $file['tmp_name'];
	$fileSize = $file['size'];
	$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
	$newFileName = $userId . '.' . $fileExtension;
	$targetFilePath = $path . $newFileName;

	if (!in_array($fileExtension, $allowedExtensions)) {
		sendResponse('error', 'Error!', 'Only image files (JPG, JPEG, PNG, GIF) are allowed.');
	}

	if ($fileSize > 5 * 1024 * 1024) {
		sendResponse('error', 'Error!', 'Image size should not exceed 5MB.');
	}

	if (move_uploaded_file($fileTmpName, $targetFilePath)) {
		return $newFileName;
	} else {
		sendResponse('error', 'Error!', 'Failed to upload image: ' . $fileName);
	}
}

$clsuIdImagePath = isset($_FILES['addclsuidimage']) ? uploadFile($_FILES['addclsuidimage'], "assets/uploads/clsu-id/", $userId) : "";
$avatarImagePath = isset($_FILES['addavatar']) ? uploadFile($_FILES['addavatar'], "assets/uploads/user-avatar/", $userId) : "";

$sql = "SELECT id FROM users WHERE User_ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userId);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$internalId = $row['id'];

if (!$internalId) {
	sendResponse('error', 'Error!', 'User not found.', false);
}

$sql = "UPDATE users SET 
    Role=?, 
    FullName=?, 
    Avatar_Image=?, 
    College=?, 
    Course=?, 
    CLSU_ID_Image=?, 
    Home_Address=?, 
    CLSU_Address=?, 
    Contact=?, 
    Social_Links=? 
    WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssssssi", $role, $fullName, $avatarImagePath, $college, $course, $clsuIdImagePath, $homeAddress, $clsuAddress, $contact, $socialLinks, $internalId);

if ($stmt->execute()) {
	sendResponse('success', 'Success!', 'User details updated successfully.');
} else {
	sendResponse('error', 'Error!', 'Error updating record: ' . $stmt->error, false);
}

$stmt->close();
$conn->close();
