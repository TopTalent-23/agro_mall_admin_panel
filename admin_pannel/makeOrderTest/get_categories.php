<?php
// Sample server-side script to fetch categories from the database
include('../../db_config.php'); // Include your database configuration file

// Set proper headers
header('Content-Type: application/json; charset=utf-8');

// Error reporting for debugging (remove in production)
error_reporting(E_ALL);
ini_set('display_errors', 1);

$query = "SELECT * FROM categories";
$result = $conn->query($query);

$categories = array();

if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }

    echo json_encode($categories);
} else {
    // Handle database query error
    http_response_code(500);
    echo json_encode(array('error' => 'Internal Server Error'));
}

$conn->close();
?>
