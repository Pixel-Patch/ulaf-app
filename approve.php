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
			echo "<script>showSuccessModal('Claim approved successfully.');</script>";
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
