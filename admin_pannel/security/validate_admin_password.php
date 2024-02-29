<?php
session_start();

// Assuming you have a function to connect to your database
include("../../db_config.php");

// Check if the admin is logged in
if (!$_SESSION['admin_logedin']) {
    http_response_code(401); // Unauthorized
    exit("Unauthorized access");
}

// Get the entered admin password from the AJAX request
$enteredPassword = isset($_POST['adminPassword']) ? $_POST['adminPassword'] : '';

// Fetch the actual admin password hash from the database
$actualPasswordQuery = "SELECT password FROM admin_users WHERE role = 'admin'";
$result = mysqli_query($conn, $actualPasswordQuery);

if (!$result) {
    http_response_code(500); // Internal Server Error
    exit("Error fetching admin password");
}

$row = mysqli_fetch_assoc($result);
$actualPasswordHash = $row['password'];

// Check if entered password matches the actual hashed password
if (password_verify($enteredPassword, $actualPasswordHash)) {
    echo "valid";
} else {
    echo "invalid";
}

mysqli_close($conn);
?>
