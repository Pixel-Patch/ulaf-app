<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_FILES['file']) && $_FILES['file']['error'] == UPLOAD_ERR_OK) {
		$uploadDir = 'assets/uploads/removed-bg/';
		if (!is_dir($uploadDir)) {
			mkdir($uploadDir, 0755, true);
		}

		$fileTmpPath = $_FILES['file']['tmp_name'];
		$fileName = $_FILES['file']['name'];
		$fileSize = $_FILES['file']['size'];
		$fileType = $_FILES['file']['type'];
		$fileNameCmps = explode(".", $fileName);
		$fileExtension = strtolower(end($fileNameCmps));
		$newFileName = uniqid() . '.' . $fileExtension;
		$destPath = $uploadDir . $newFileName;

		$allowedfileExtensions = array('jpg', 'jpeg', 'png', 'gif');
		if (in_array($fileExtension, $allowedfileExtensions)) {
			if (move_uploaded_file($fileTmpPath, $destPath)) {
				$response = [
					'status' => 'success',
					'message' => 'File is successfully uploaded.',
					'filePath' => $destPath
				];
			} else {
				$response = [
					'status' => 'error',
					'message' => 'There was an error moving the uploaded file.'
				];
			}
		} else {
			$response = [
				'status' => 'error',
				'message' => 'Upload failed. Allowed file types: ' . implode(',', $allowedfileExtensions)
			];
		}
	} else {
		$response = [
			'status' => 'error',
			'message' => 'No file uploaded or there was an upload error.'
		];
	}
	echo json_encode($response);
}
