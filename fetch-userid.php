<?php
 

// Include your database connection setup
include 'dbconn.php';

// Check if the user_id is set in the session
if (isset($_SESSION['user_id'])) {
	$userId = $_SESSION['user_id'];
 
} else {
	// Handle the case where user_id is not set
	echo "User ID is not set in the session.";
}
