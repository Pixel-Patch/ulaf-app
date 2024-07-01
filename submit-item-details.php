<?php
session_start();
require 'dbconn.php';

function showError($message)
{
	echo json_encode([
		'status' => 'error',
		'alertClass' => 'modal-content alert alert-danger alert-dismissible alert-alt fade show',
		'alertTitle' => 'Error!',
		'message' => $message
	]);
	exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$itemName = $_POST['addItemName'];
	$type = $_POST['addType'];
	$categoryID = $_POST['addCategory'];
	$description = $_POST['addDescription'];
	$pinLocation = $_POST['addPinLocation'];
	$latitude = $_POST['latitude'];
	$longitude = $_POST['longitude'];
	$currentLocation = isset($_POST['itemCurrentLocation']) ? $_POST['itemCurrentLocation'] : null;
	$posterID = $_SESSION['user_id'];
	$postedDate = date('Y-m-d H:i:s');
	$itemStatus = 'Posted';
	$targetDir = "assets/uploads/items/";

	if (!$itemName || !$type || !$categoryID || !$description || !$pinLocation || !$latitude || !$longitude) {
		showError('All fields are required');
	}

	if ($type === 'found' && !$currentLocation) {
		showError('Current location is required for found items');
	}

	$imageNames = [];
	if (!empty($_FILES['addImages']['name'][0])) {
		$imageCount = count($_FILES['addImages']['name']);
		if ($imageCount > 3) {
			showError('You can upload a maximum of 3 images');
		}

		$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
		foreach ($_FILES['addImages']['tmp_name'] as $key => $tmp_name) {
			$fileName = $_FILES['addImages']['name'][$key];
			$fileTmpName = $_FILES['addImages']['tmp_name'][$key];
			$fileSize = $_FILES['addImages']['size'][$key];
			$fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
			$newFileName = $categoryID . '-' . $posterID . '-' . time() . '-' . $key . '.' . $fileExtension;
			$targetFilePath = $targetDir . $newFileName;

			if (!in_array($fileExtension, $allowedExtensions)) {
				showError('Only image files (JPG, JPEG, PNG, GIF) are allowed');
			}

			if ($fileSize > 5 * 1024 * 1024) {
				showError('Image size should not exceed 5MB');
			}

			if (move_uploaded_file($fileTmpName, $targetFilePath)) {
				$imageNames[] = $newFileName;
			} else {
				showError('Failed to upload image: ' . $fileName);
			}
		}
	}

	$imageNamesString = implode(',', $imageNames);

	$stmt = $conn->prepare("INSERT INTO `items` (`Item_Name`, `Image`, `Type`, `Category_ID`, `Description`, `Pin_Location`, `Posted_Date`, `Current_Location`, `Poster_ID`, `Item_Status`, `Latitude`, `Longitude`) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	$stmt->bind_param('ssssssssssss', $itemName, $imageNamesString, $type, $categoryID, $description, $pinLocation, $postedDate, $currentLocation, $posterID, $itemStatus, $latitude, $longitude);

	if ($stmt->execute()) {
		echo json_encode([
			'status' => 'success',
			'alertClass' => 'modal-content alert alert-success alert-dismissible alert-alt fade show',
			'alertTitle' => 'Success!',
			'message' => 'Item details have been successfully submitted.'
		]);
	} else {
		showError('Failed to submit item details. Please try again.');
	}
} else {
	showError('Invalid request method');
}
