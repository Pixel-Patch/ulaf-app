<?php
include 'dbconn.php';

if (isset($_GET['claimId'])) {
	$claimId = $_GET['claimId'];
	$status = 'Approved';
	$verificationDate = new DateTime("now", new DateTimeZone('Asia/Manila'));
	$formattedDate = $verificationDate->format('Y-m-d H:i:s');

	$sql = "UPDATE claims SET 
                Verification_Status = ?, 
                Verification_Date = ? 
            WHERE Claim_ID = ?";

	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param('ssi', $status, $formattedDate, $claimId);
		if ($stmt->execute()) {
			echo "Claim approved successfully.";
		} else {
			echo "Error executing query: " . $stmt->error;
		}
		$stmt->close();
	} else {
		echo "Error preparing statement: " . $conn->error;
	}
} else {
	echo "No claim ID provided.";
}
