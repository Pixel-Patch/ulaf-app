<?php
include 'dbconn.php';

if (isset($_GET['claimId'])) {
	$claimId = $_GET['claimId'];
	$status = 'Approved';
	$verificationDate = new DateTime("now", new DateTimeZone('Asia/Manila'));
	$formattedDate = $verificationDate->format('Y-m-d H:i:s');

	// Start a transaction
	$conn->begin_transaction();

	try {
		// Prepare the claim update statement
		$sqlClaimUpdate = "UPDATE claims SET
                            Verification_Status = ?,
                            Verification_Date = ?,
                            Claim_Status = 'Claimed'
                        WHERE Claim_ID = ?";

		if ($stmt = $conn->prepare($sqlClaimUpdate)) {
			$stmt->bind_param('ssi', $status, $formattedDate, $claimId);
			if (!$stmt->execute()) {
				throw new Exception("Error executing claim update query: " . $stmt->error);
			}
			$stmt->close();
		} else {
			throw new Exception("Error preparing claim update statement: " . $conn->error);
		}

		// Get the Item_ID from the claims table
		$sqlSelect = "SELECT Item_ID FROM claims WHERE Claim_ID = ?";
		if ($stmtSelect = $conn->prepare($sqlSelect)) {
			$stmtSelect->bind_param('i', $claimId);
			if (!$stmtSelect->execute()) {
				throw new Exception("Error executing item ID fetch query: " . $stmtSelect->error);
			}
			$stmtSelect->bind_result($itemId);
			if (!$stmtSelect->fetch()) {
				throw new Exception("Error fetching item ID.");
			}
			$stmtSelect->close();
		} else {
			throw new Exception("Error preparing item ID fetch statement: " . $conn->error);
		}

		// Update the Item_Status to 'Claimed' in the items table
		$sqlUpdateItem = "UPDATE items SET Item_Status = 'Claimed' WHERE Item_ID = ?";
		if ($stmtUpdateItem = $conn->prepare($sqlUpdateItem)) {
			$stmtUpdateItem->bind_param('i', $itemId);
			if (!$stmtUpdateItem->execute()) {
				throw new Exception("Error executing item update query: " . $stmtUpdateItem->error);
			}
			$stmtUpdateItem->close();
		} else {
			throw new Exception("Error preparing item update statement: " . $conn->error);
		}

		// Commit the transaction
		$conn->commit();
		echo "<script>showSuccessModal('Claim approved and item status updated successfully.');</script>";
		echo "<script>setTimeout(() => {
            window.location.href = 'view-verify-claims.php?claim_id=$claimId';
        }, 2000);</script>";
	} catch (Exception $e) {
		// Rollback the transaction if any error occurs
		$conn->rollback();
		echo "<script>showErrorModal('" . $e->getMessage() . "');</script>";
	}
} else {
	echo "<script>showWarningModal('No claim ID provided.');</script>";
}
