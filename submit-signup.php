<?php
include 'dbconn.php';

$response = ['status' => 'error', 'alertClass' => 'modal-content alert alert-danger alert-dismissible alert-alt fade show', 'alertTitle' => 'Error!', 'message' => 'System error occurred. Please try again.'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$user_id = $_POST['userId'];
	$username = $_POST['username'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$confirm_password = $_POST['confirmPassword'];

	if ($password !== $confirm_password) {
		$response = ['status' => 'error', 'alertClass' => 'modal-content alert alert-warning alert-dismissible alert-alt fade show', 'alertTitle' => 'Warning!', 'message' => 'Passwords do not match.'];
	} else {
		// Check if the user ID already exists
		$stmt = $conn->prepare("SELECT User_ID FROM users WHERE User_ID = ?");
		$stmt->bind_param("s", $user_id);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			$response = ['status' => 'error', 'alertClass' => 'modal-content alert alert-warning alert-dismissible alert-alt fade show', 'alertTitle' => 'Warning!', 'message' => 'User ID already exists. Please sign in.'];
			$stmt->close();
			$conn->close();
			echo json_encode($response);
			exit();
		}
		$stmt->close();

		// Check if the username already exists
		$stmt = $conn->prepare("SELECT Username FROM users WHERE Username = ?");
		$stmt->bind_param("s", $username);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			$response = ['status' => 'error', 'alertClass' => 'modal-content alert alert-warning alert-dismissible alert-alt fade show', 'alertTitle' => 'Warning!', 'message' => 'Username already exists. Please choose another one.'];
			$stmt->close();
			$conn->close();
			echo json_encode($response);
			exit();
		}
		$stmt->close();


		// Check if the email already exists
		$stmt = $conn->prepare("SELECT Email FROM users WHERE Email = ?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();
		if ($stmt->num_rows > 0) {
			$response = ['status' => 'error', 'alertClass' => 'modal-content alert alert-warning alert-dismissible alert-alt fade show', 'alertTitle' => 'Warning!', 'message' => 'Email already exists. Please sign in.'];
			$stmt->close();
			$conn->close();
			echo json_encode($response);
			exit();
		}
		$stmt->close();

		// Hash the password
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		// Insert new user into the database
		$stmt = $conn->prepare("INSERT INTO users (User_ID, Username, Email, Password) VALUES (?, ?, ?, ?)");
		$stmt->bind_param("ssss", $user_id, $username, $email, $hashed_password);
		if ($stmt->execute()) {
			$response = ['status' => 'success', 'alertClass' => 'modal-content alert alert-primary alert-dismissible alert-alt fade show', 'alertTitle' => 'Success!', 'message' => 'Account created successfully.'];
		} else {
			$response['message'] = 'Database error: ' . $stmt->error;
		}
		$stmt->close();
	}
}

$conn->close();
echo json_encode($response);
