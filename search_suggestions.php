<?php
require("dbconn.php");

$search = filter_input(INPUT_GET, 'search', FILTER_SANITIZE_STRING);

function fetchData($conn, $query, $params = [])
{
	$data = [];
	if ($stmt = $conn->prepare($query)) {
		if (!empty($params)) {
			$stmt->bind_param(...$params);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		if ($result) {
			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}
		} else {
			error_log("Database Query Error: " . $stmt->error);
		}
		$stmt->close();
	} else {
		error_log("Database Query Error: " . $conn->error);
	}
	return $data;
}

header('Content-Type: application/json');
if ($search) {
	$searchQuery = "
        SELECT Item_ID, Item_Name, Image 
        FROM items 
        WHERE Item_Name LIKE CONCAT('%', ?, '%')";
	$searchResults = fetchData($conn, $searchQuery, ['s', $search]);
	echo json_encode($searchResults);
} else {
	echo json_encode([]);
}
