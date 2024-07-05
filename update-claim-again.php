<?php
require('dbconn.php');

$data = json_decode(file_get_contents('php://input'), true);
$claimId = $data['claim_id'] ?? null;

$response = ['success' => false];

if ($claimId) {
    $updateQuery = "UPDATE claims SET Claim_Again = 1 WHERE Claim_ID = ?";
    if ($stmt = $conn->prepare($updateQuery)) {
        $stmt->bind_param("i", $claimId);
        if ($stmt->execute()) {
            $response['success'] = true;
        }
        $stmt->close();
    }
}

echo json_encode($response);
