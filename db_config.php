<?php
// Database configuration
$dbHost = "localhost";
//$dbPort = 8120;  // Change this to the port you are using
$dbUsername = "root";
$dbPassword = "Mo21nu94@jadhav";
$dbName = "id21908296_ahire_agro_mall";

// Create database connection
$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
// if (!$conn) {
//     die("Connection failed: " . mysqli_connect_error());
// } else {
//     echo 'Database connection successful <br>';
// }
?>
