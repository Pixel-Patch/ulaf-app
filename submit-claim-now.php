<?php
// Include your database connection file
require_once 'dbconn.php';

// Get the item ID and claim ID from the query string
$itemId = isset($_GET['item_id']) ? intval($_GET['item_id']) : 0;
$claimId = isset($_GET['claim_id']) ? intval($_GET['claim_id']) : 0;

$response = ['success' => true];  // Initialize response array

if ($itemId > 0) {
	// Prepare the SQL statement to update the item status
	$stmt = $conn->prepare("UPDATE items SET Item_Status = 'Retrieving' WHERE Item_ID = ?");
	$stmt->bind_param("i", $itemId);

	// Execute the statement
	if (!$stmt->execute()) {
		$response = ['success' => false, 'error' => $stmt->error];
	}

	// Close the statement
	$stmt->close();
} else {
	$response = ['success' => false, 'error' => 'Invalid item ID'];
}

if ($claimId > 0) {
	// Prepare the SQL statement to update the claim status
	$stmt = $conn->prepare("UPDATE claims SET Claim_Status = 'Retrieving' WHERE Claim_ID = ?");
	$stmt->bind_param("i", $claimId);

	// Execute the statement
	if (!$stmt->execute()) {
		$response = ['success' => false, 'error' => $stmt->error];
	}

	// Close the statement
	$stmt->close();
} else {
	if ($response['success']) {
		$response = ['success' => false, 'error' => 'Invalid claim ID'];
	}
}

// Return the response as JSON
echo json_encode($response);

// Close the database connection
$conn->close();
