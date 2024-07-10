<?php
include 'dbconn.php';

if (isset($_GET['claimId'])) {
	$claimId = $_GET['claimId'];
	$status = 'Declined';
	$verificationDate = new DateTime("now", new DateTimeZone('Asia/Manila'));
	$formattedDate = $verificationDate->format('Y-m-d H:i:s');

	// Add Claim_Again column to be updated
	$sql = "UPDATE claims SET
                Verification_Status = ?,
                Verification_Date = ?,
                Claim_Again = 1
            WHERE Claim_ID = ?";

	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param('ssi', $status, $formattedDate, $claimId);
		if ($stmt->execute()) {
			echo "<script>showSuccessModal('Claim updated successfully.');</script>";
			echo "<script>setTimeout(() => {
                        window.location.href = 'view-verify-claims.php?claim_id=$claimId';
                    }, 2000);</script>";
		} else {
			echo "<script>showErrorModal('Error executing query: " . $stmt->error . "');</script>";
		}
		$stmt->close();
	} else {
		echo "<script>showErrorModal('Error preparing statement: " . $conn->error . "');</script>";
	}
} else {
	echo "<script>showWarningModal('No claim ID provided.');</script>";
}
