<?php
// Include your database connection setup
include 'dbconn.php';


// Check if the user_id is set in the session
if (isset($_SESSION['user_id'])) {
	$userId = $_SESSION['user_id'];

	// Prepare the SQL statement to fetch the username
	$sql = "SELECT `Username` FROM `users` WHERE `User_ID` = ?";

	// Initialize prepared statement
	if ($stmt = $conn->prepare($sql)) {
		// Bind parameters to the prepared statement
		$stmt->bind_param("s", $userId);

		// Execute the prepared statement
		$stmt->execute();

		// Get the result
		$result = $stmt->get_result();

		// Check if the user exists
		if ($result->num_rows > 0) {
			// Fetch user data
			$user = $result->fetch_assoc();

			// Access username
			$username = $user['Username'];
		}

		// Close the statement
		$stmt->close();
	} else {
		echo "Failed to prepare the SQL statement.";
	}

} else {
	// Handle the case where user_id is not set
	echo "User ID is not set in the session.";
}
