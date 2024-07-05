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
    $itemID = $_POST['item_id'];
    $itemName = $_POST['editItemName'];
    $type = $_POST['editType'];
    $categoryID = $_POST['editCategory'];
    $description = $_POST['editDescription'];
    $pinLocation = $_POST['editPinLocation'];
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
    if (!empty($_FILES['editImages']['name'][0])) {
        $imageCount = count($_FILES['editImages']['name']);
        if ($imageCount > 3) {
            showError('You can upload a maximum of 3 images');
        }

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        foreach ($_FILES['editImages']['tmp_name'] as $key => $tmp_name) {
            $fileName = $_FILES['editImages']['name'][$key];
            $fileTmpName = $_FILES['editImages']['tmp_name'][$key];
            $fileSize = $_FILES['editImages']['size'][$key];
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

    if (!empty($imageNames)) {
        $imageNamesString = implode(',', $imageNames);
        $updateImageField = "Image = ?,";
    } else {
        $updateImageField = "";
    }

    $sql = "UPDATE `items` SET `Item_Name`=?, $updateImageField `Type`=?, `Category_ID`=?, `Description`=?, `Pin_Location`=?, `Current_Location`=?, `Latitude`=?, `Longitude`=? WHERE `Item_ID`=?";
    $stmt = $conn->prepare($sql);

    if (!empty($imageNames)) {
        $stmt->bind_param('sssssssssi', $itemName, $imageNamesString, $type, $categoryID, $description, $pinLocation, $currentLocation, $latitude, $longitude, $itemID);
    } else {
        $stmt->bind_param('ssssssssi', $itemName, $type, $categoryID, $description, $pinLocation, $currentLocation, $latitude, $longitude, $itemID);
    }

    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success',
            'alertClass' => 'modal-content alert alert-success alert-dismissible alert-alt fade show',
            'alertTitle' => 'Success!',
            'message' => 'Item details have been successfully updated.',
            'item_id' => $itemID
        ]);
    } else {
        showError('Failed to update item details. Please try again.');
    }
} else {
    showError('Invalid request method');
}
 