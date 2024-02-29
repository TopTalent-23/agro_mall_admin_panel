<?php
// Include necessary files and start the session if not started already
session_start();
include("../../db_config.php");

// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input data
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT); // Hash the password
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Your update query
    $updateQuery = "UPDATE admin_users SET name='$name', phone='$phone', email='$email', password='$password', username='$username', role='$role' WHERE id='$id'";

    // Perform the update query
    if (mysqli_query($conn, $updateQuery)) {
        // If the query was successful, return a success message
        echo json_encode(array("status" => "success"));
    } else {
        // If the query failed, return an error message
        echo json_encode(array("status" => "error", "message" => "Failed to update user information."));
    }
} else {
    // If the request is not a POST request, return an error message
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
}
?>
