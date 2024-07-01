<?php
session_start();
require("dbconn.php");

function sendResponse($status, $title, $message, $redirect = true)
{
	echo json_encode([
		'status' => $status,
		'alertClass' => 'modal-content alert alert-' . $status . ' alert-dismissible alert-alt fade show',
		'alertTitle' => $title,
		'message' => $message,
		'redirect' => $redirect
	]);
	exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_SESSION['user_id'])) {
		$userId = $_SESSION['user_id'];

		// Fetch the user's internal ID and hashed password from the database
		$sql = "SELECT id, Password FROM users WHERE User_ID = ?";
		if ($stmt = $conn->prepare($sql)) {
			$stmt->bind_param("s", $userId);
			$stmt->execute();
			$result = $stmt->get_result();

			if ($result->num_rows > 0) {
				$row = $result->fetch_assoc();
				$internalId = $row['id'];
				$hashedPassword = $row['Password'];
			} else {
				sendResponse('danger', 'Error!', 'User not found.', false);
			}
		} else {
			sendResponse('danger', 'Error!', $conn->error, false);
		}

		$currentPassword = $_POST['currentpassword'];
		$newPassword = $_POST['editpassword'];
		$confirmPassword = $_POST['editconfirmpassword'];

		$passwordUpdate = false;

		if (!empty($currentPassword) || !empty($newPassword) || !empty($confirmPassword)) {
			if (!password_verify($currentPassword, $hashedPassword)) {
				sendResponse('danger', 'Error!', 'Incorrect current password.', false);
			}

			if ($newPassword !== $confirmPassword) {
				sendResponse('danger', 'Error!', 'Password mismatch.', false);
			}

			$newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
			$passwordUpdate = true;
		}

		$username = $_POST['editusername'];
		$contact = $_POST['editcontact'];
		$homeAddress = $_POST['edithomeaddress'];
		$socialLinks = $_POST['editlinks'];
		$clsuAddress = $_POST['editclsuaddress'];

		$avatarImage = $_SESSION['user_data']['Avatar_Image'];

		if (!empty($_FILES['avatar']['name'])) {
			$allowedExtensions = ['png', 'jpg', 'jpeg'];
			$avatarExtension = strtolower(pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION));

			if (in_array($avatarExtension, $allowedExtensions)) {
				$avatarImage = $userId . '.' . $avatarExtension;
				$avatarTmpName = $_FILES['avatar']['tmp_name'];
				$avatarUploadPath = "assets/uploads/user-avatar/" . $avatarImage;

				if (!is_dir('assets/uploads/user-avatar')) {
					mkdir('assets/uploads/user-avatar', 0777, true);
				}

				foreach ($allowedExtensions as $extension) {
					$existingImage = "assets/uploads/user-avatar/" . $userId . '.' . $extension;
					if (file_exists($existingImage) && $existingImage !== $avatarUploadPath) {
						unlink($existingImage);
					}
				}

				if (move_uploaded_file($avatarTmpName, $avatarUploadPath)) {
					$_SESSION['user_data']['Avatar_Image'] = $avatarImage;
				} else {
					sendResponse('danger', 'Error!', 'Error uploading file.', false);
				}
			} else {
				sendResponse('danger', 'Error!', 'Invalid file type.', false);
			}
		}

		$query = "UPDATE users SET 
                    Username = ?, 
                    Contact = ?, 
                    Home_Address = ?, 
                    Social_Links = ?, 
                    CLSU_Address = ?, 
                    Avatar_Image = ?";
		if ($passwordUpdate) {
			$query .= ", Password = ?";
		}
		$query .= " WHERE id = ?";

		if ($stmt = $conn->prepare($query)) {
			if ($passwordUpdate) {
				$stmt->bind_param("sssssssi", $username, $contact, $homeAddress, $socialLinks, $clsuAddress, $avatarImage, $newHashedPassword, $internalId);
			} else {
				$stmt->bind_param("ssssssi", $username, $contact, $homeAddress, $socialLinks, $clsuAddress, $avatarImage, $internalId);
			}
			$stmt->execute();
			$stmt->close();

			$_SESSION['user_data']['Username'] = $username;
			$_SESSION['user_data']['Contact'] = $contact;
			$_SESSION['user_data']['Home_Address'] = $homeAddress;
			$_SESSION['user_data']['Social_Links'] = $socialLinks;
			$_SESSION['user_data']['CLSU_Address'] = $clsuAddress;

			sendResponse('success', 'Success!', 'User details updated successfully.');
		} else {
			sendResponse('danger', 'Error!', $conn->error, false);
		}
	} else {
		sendResponse('danger', 'Error!', 'User not logged in.', false);
	}
}

$conn->close();
