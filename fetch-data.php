<?php

include 'dbconn.php'; // Ensure this file includes your database connection setup

$response = ['isRegistered' => false, 'id' => null, 'fields' => [], 'items' => [], 'categories' => [], 'item' => null];

function fetchData($conn, $query, $params = [], $paramTypes = "", $singleRow = false) {
	$data = [];
	if ($stmt = $conn->prepare($query)) {
		if (!empty($params)) {
			$stmt->bind_param($paramTypes, ...$params);
		}
		$stmt->execute();
		$result = $stmt->get_result();

		if ($singleRow) {
			$data = $result->fetch_assoc();
		} else {
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
		}
	}
	return $data;
}

if (isset($_SESSION['user_id'])) {
	$userId = $_SESSION['user_id'];

	// Fetch the user's internal ID from the database
	$userQuery = "SELECT id FROM users WHERE User_ID = ?";
	$userData = fetchData($conn, $userQuery, [$userId], "s", true);

	if (!empty($userData)) {
		$internalId = $userData['id'];

		// Fetch user details
		$userDetailsQuery = "SELECT * FROM `users` WHERE `id` = ?";
		$userDetails = fetchData($conn, $userDetailsQuery, [$internalId], "i", true);
		$response['fields'] = $userDetails;
		$response['isRegistered'] = true;
		$response['id'] = $internalId; // Add the user's internal ID to the response

		// Fetch categories data
		$categoriesQuery = "SELECT * FROM `categories`";
		$response['categories'] = fetchData($conn, $categoriesQuery);

		// Fetch item data based on item_id from URL
		if (isset($_GET['item_id'])) {
			$itemId = $_GET['item_id'];
			$itemQuery = "SELECT * FROM `items` WHERE `item_id` = ?";
			$response['item'] = fetchData($conn, $itemQuery, [$itemId], "i", true);
		}
	}
}

$_SESSION['user_data'] = $response['fields']; // Store user data in session
$_SESSION['user_id_internal'] = $response['id']; // Store the user's internal ID in session
$_SESSION['categories_data'] = $response['categories']; // Store categories data in session
$_SESSION['item_data'] = $response['item']; // Store fetched item data in session if available

?>
