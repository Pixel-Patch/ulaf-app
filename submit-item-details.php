<?php
require('dbconn.php');
session_start(); // Ensure the session is started

$response = array('success' => false, 'message' => '');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	// Sanitize and validate inputs
	$itemId = filter_var($_POST['item_id'] ?? null, FILTER_VALIDATE_INT);
	$userId = $_SESSION['user_id'] ?? null; // Assuming user_id is stored in session
	$distinguishableMarks = htmlspecialchars($_POST['distinguishableMarks'] ?? '', ENT_QUOTES, 'UTF-8');
	$proofImages = $_FILES['proofImages'] ?? [];

	if (!$itemId || empty($distinguishableMarks)) {
		$response['message'] = 'All fields are required.';
	} else {
		// Check if user already submitted a pending claim
		$claimQuery = "
            SELECT * 
            FROM claims 
            WHERE Item_ID = ? AND Claimer_ID = ? AND Verification_Status = 'Pending'
            LIMIT 1";

		$stmt = $conn->prepare($claimQuery);
		if (!$stmt) {
			$response['message'] = 'Failed to prepare statement: ' . $conn->error;
		} else {
			$stmt->bind_param("ii", $itemId, $userId);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				$response['message'] = 'You have already submitted a pending claim for this item.';
			} else {
				// Create the target directory if it doesn't exist
				$targetDir = "assets/uploads/proofs/";
				if (!file_exists($targetDir)) {
					mkdir($targetDir, 0777, true);
				}

				// Process each uploaded file
				$uploadedFiles = [];
				foreach ($proofImages['name'] as $key => $filename) {
					$extension = pathinfo($filename, PATHINFO_EXTENSION);
					$newFilename = $itemId . '-' . $userId . '-' . ($key + 1) . '.' . $extension;
					$targetFilePath = $targetDir . $newFilename;
					if (move_uploaded_file($proofImages['tmp_name'][$key], $targetFilePath)) {
						$uploadedFiles[] = $newFilename;
					}
				}

				// Insert claim into database
				$insertClaimQuery = "
                    INSERT INTO claims (Item_ID, Claimer_ID, Claim_Status, Proof, Proof_Image, Claim_Date, Verification_Status) 
                    VALUES (?, ?, 'Claiming', ?, ?, NOW(), 'Pending')";

				$stmt = $conn->prepare($insertClaimQuery);
				if (!$stmt) {
					$response['message'] = 'Failed to prepare statement: ' . $conn->error;
				} else {
					$proofImagesStr = implode(',', $uploadedFiles);
					$stmt->bind_param("isss", $itemId, $userId, $distinguishableMarks, $proofImagesStr);

					if ($stmt->execute()) {
						$insertedClaimId = $stmt->insert_id; // Get the inserted Claim_ID
						$response['success'] = true;
						$response['message'] = 'Claim submitted successfully. Please wait for the item founder to verify your claim.';
						$response['claimId'] = $insertedClaimId; // Include Claim_ID in response
					} else {
						$response['message'] = 'An error occurred while submitting your claim. Please try again later.';
					}
				}
			}
		}
	}
} else {
	$response['message'] = 'Invalid request method.';
}

// Ensure the correct content type header for JSON response
header('Content-Type: application/json');
echo json_encode($response);
