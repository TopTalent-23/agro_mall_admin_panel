<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "aahire_agro_mall";


// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch data from the 'orders' table grouped by year
$query = "SELECT YEAR(date_time) AS year, SUM(amount) AS total_amount FROM orders GROUP BY year";
$result = $conn->query($query);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

// Close connection
$conn->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($data);
?>
