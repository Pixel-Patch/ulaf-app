<?php
// Include database connection
include 'dbconn.php';

// Define the timezone
date_default_timezone_set('Asia/Manila');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $item_id = $_POST['item_id'];
    $claimer_id = $_POST['claimer_id'];
    $claim_id = $_POST['claim_id'];
    $remarks = $_POST['remarks'];

    // Process uploaded images
    $returned_images = [];
    if (isset($_FILES['returnedImage']) && count($_FILES['returnedImage']['name']) > 0) {
        $upload_directory = 'assets/uploads/returned-proof/';
        foreach ($_FILES['returnedImage']['name'] as $key => $image_name) {
            $image_tmp_name = $_FILES['returnedImage']['tmp_name'][$key];
            $image_path = $upload_directory . basename($image_name);
            if (move_uploaded_file($image_tmp_name, $image_path)) {
                $returned_images[] = $image_path;
            }
        }
    }

    // Convert images array to JSON
    $returned_images_json = json_encode($returned_images);

    // Current date and time
    $current_date = date('Y-m-d H:i:s');

    // Update claims table
    $claims_query = "UPDATE claims 
                     SET Returned_Image='$returned_images_json', Claim_Status='Returned', Verification_Date='$current_date', Remarks='$remarks' 
                     WHERE Claim_ID='$claim_id'";

    // Update items table
    $items_query = "UPDATE items 
                    SET Item_Status='Returned', Retrieved_Date='$current_date', Retrieved_By='$claimer_id' 
                    WHERE Item_ID='$item_id'";

    // Execute queries
    if (mysqli_query($conn, $claims_query) && mysqli_query($conn, $items_query)) {
        echo json_encode(['success' => true, 'message' => 'Claim updated successfully!', 'item_id' => $item_id]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error: ' . mysqli_error($conn)]);
    }

    // Close the database connection
    mysqli_close($conn);
}
