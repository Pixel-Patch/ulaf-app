<?php
include 'dbconn.php';

$response = ['status' => 'error', 'message' => 'An error occurred while submitting your claim.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $claimer_id = $_POST['claimer_id'];
    $item_id = $_POST['item_id'];
    $proof = $_POST['distinguishableMarks'];

    // Handle file upload
    $proof_image = null;
    if (isset($_FILES['proofImage']) && $_FILES['proofImage']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $proof_image = $upload_dir . basename($_FILES['proofImage']['name']);
        if (!move_uploaded_file($_FILES['proofImage']['tmp_name'], $proof_image)) {
            $response['message'] = 'Failed to upload image.';
            echo json_encode($response);
            exit();
        }
    }

    $claim_id = uniqid();
    $stmt = $conn->prepare("INSERT INTO claims (Claim_ID, Item_ID, Claimer_ID, Claim_Status, Proof, Proof_Image) VALUES (?, ?, ?, 'Pending', ?, ?)");
    $stmt->bind_param("sssss", $claim_id, $item_id, $claimer_id, $proof, $proof_image);

    if ($stmt->execute()) {
        $response['status'] = 'success';
        $response['message'] = 'Your claim has been submitted successfully.';
    } else {
        $response['message'] = 'Database error: ' . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
echo json_encode($response);
