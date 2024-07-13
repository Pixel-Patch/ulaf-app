<?php
require('dbconn.php');

// Get the last checked claim ID (you might want to store this in a separate table or file)
$last_checked_id = 0; // Replace with actual last checked ID

$sql = "SELECT c.Claim_ID, c.Item_ID, i.Poster_ID 
        FROM claims c
        JOIN items i ON c.Item_ID = i.Item_ID
        WHERE c.Claim_ID > ?
        ORDER BY c.Claim_ID ASC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $last_checked_id);
$stmt->execute();
$result = $stmt->get_result();

$new_claims = array();
while ($row = $result->fetch_assoc()) {
	$new_claims[] = $row;
}

// Update last checked ID
if (!empty($new_claims)) {
	$last_checked_id = end($new_claims)['Claim_ID'];
	// Save the new last_checked_id (to a file or database)
}

$conn->close();

echo json_encode(array('newClaims' => $new_claims));
