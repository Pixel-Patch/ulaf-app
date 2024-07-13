<?php
require('dbconn.php');
require('fetch-userid.php'); // Ensure this file sets $userId

// Fetch new claims for items posted by the current user
$sql = "
    SELECT claims.Claim_ID, claims.Item_ID, items.Poster_ID
    FROM claims
    JOIN items ON claims.Item_ID = items.Item_ID
    WHERE items.Poster_ID = ? AND claims.Claim_Status = 'Pending'
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
	$itemId = $row['Item_ID'];
	$notificationText = "Claim on Item # $itemId";

	// Insert notification
	$insertSql = "
        INSERT INTO notifications (User_ID, Notification_Text, Timestamp)
        VALUES (?, ?, NOW())
    ";
	$insertStmt = $conn->prepare($insertSql);
	$insertStmt->bind_param("is", $userId, $notificationText);
	$insertStmt->execute();
}

$stmt->close();
$conn->close();
