<?php
require('dbconn.php'); // Include your database connection file

// Check connection
if ($conn->connect_error) {
	die("Connection failed: " . $conn->connect_error);
}

// Query the database for the claim status
$sql = "SELECT Claim_Status FROM claims"; // replace 'claims' with the name of your table if it's different
$result = $conn->query($sql);

// Check if the query was successful
if ($result->num_rows > 0) {
	// Fetch the result as an associative array
	$row = $result->fetch_assoc();

	// Set the appropriate headers
	header('Content-Type: application/json');
	header('Access-Control-Allow-Origin: *');

	// Return the result as a JSON object
	echo json_encode(array('claimStatus' => $row['Claim_Status']));
} else {
	echo "0 results";
}

// Close the connection
$conn->close();
