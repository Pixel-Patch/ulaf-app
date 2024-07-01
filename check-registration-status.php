<?php
session_start();
include 'dbconn.php'; // Ensure this file includes your database connection setup

$response = ['isRegistered' => false, 'id' => null, 'fields' => []];

if (isset($_SESSION['user_id'])) {
	$userId = $_SESSION['user_id'];

	// Fetch the user's internal ID from the database
	$sql = "SELECT id FROM users WHERE User_ID = ?";
	if ($stmt = $conn->prepare($sql)) {
		$stmt->bind_param("s", $userId);
		$stmt->execute();
		$result = $stmt->get_result();

		if ($result->num_rows > 0) {
			$row = $result->fetch_assoc();
			$internalId = $row['id'];

			$query = "SELECT `User_ID`, `Role`, `Username`, `FullName`, `Password`, `Email`, `Avatar_Image`, `College`, `Course`, `CLSU_ID_Image`, `Home_Address`, `CLSU_Address`, `Contact`, `Social_Links`
                      FROM `users`
                      WHERE `id` = ?";

			if ($stmt = $conn->prepare($query)) {
				$stmt->bind_param('i', $internalId);
				$stmt->execute();
				$result = $stmt->get_result();

				if ($result->num_rows > 0) {
					$row = $result->fetch_assoc();
					$fields = ['User_ID', 'Role', 'Username', 'FullName', 'Password', 'Email', 'Avatar_Image', 'College', 'Course', 'CLSU_ID_Image', 'Home_Address', 'CLSU_Address', 'Contact', 'Social_Links'];
					$isRegistered = true;

					foreach ($fields as $field) {
						if (empty($row[$field])) {
							$isRegistered = false;
							$response['fields'][$field] = 0;
						} else {
							$response['fields'][$field] = 1;
						}
					}

					$response['isRegistered'] = $isRegistered;
					$response['id'] = $internalId; // Add the user's internal ID to the response
				}
			}
		}
	}
}

echo json_encode($response);
