<?php

header('Content-Type: application/json');

require('dbconn.php'); // Include your database connection file

$response = [
	'status' => 'error',
	'alertClass' => 'alert-danger',
	'alertTitle' => 'Error!',
	'message' => 'An unknown error occurred.'
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$usernameEmail = $_POST['usernameEmail'] ?? '';
	$password = $_POST['password'] ?? '';

	if (empty($usernameEmail) || empty($password)) {
		$response['alertClass'] = 'alert-warning';
		$response['alertTitle'] = 'Warning!';
		$response['message'] = 'Please fill in all fields.';
		echo json_encode($response);
		exit;
	}

	try {
		$stmt = $conn->prepare('SELECT User_ID, Username, Password FROM users WHERE Username = ? OR Email = ?');
		if ($stmt === false) {
			throw new Exception('Prepare statement failed: ' . htmlspecialchars($conn->error));
		}

		$stmt->bind_param('ss', $usernameEmail, $usernameEmail);
		$stmt->execute();
		$stmt->store_result();

		if ($stmt->num_rows > 0) {
			$stmt->bind_result($user_id, $username, $hashed_password);
			$stmt->fetch();

			if (password_verify($password, $hashed_password)) {
				session_start();
				$_SESSION['user_id'] = $user_id;
				$_SESSION['username'] = $username;

				$response['status'] = 'success';
				$response['alertClass'] = 'alert-primary';
				$response['alertTitle'] = 'Success!';
				$response['message'] = 'Login successful! Redirecting...';

				// Redirect to a protected page (if necessary)
				// header('Location: protected-page.php');
				// exit();
			} else {
				$response['message'] = 'Invalid username/email or password.';
			}
		} else {
			$response['message'] = 'Invalid username/email or password.';
		}

		$stmt->close();
	} catch (Exception $e) {
		$response['message'] = 'Database error: ' . $e->getMessage();
	}
} else {
	$response['message'] = 'Invalid request method.';
}

$conn->close();
echo json_encode($response);
