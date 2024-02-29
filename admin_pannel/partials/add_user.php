<?php
// Include necessary files and start the session if not started already
session_start();
include("../../db_config.php");

if (!isset($_SESSION['admin_logedin'])) {
  header("Location: partials/admin_login.php");
  exit; // Stop further execution
}
// Check if the request is a POST request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate and sanitize the input data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT); // Hash the password
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    // Your insert query
    $insertQuery = "INSERT INTO admin_users (name, phone, email, username, password, role) 
                    VALUES ('$name', '$phone', '$email', '$username', '$password', '$role')";

    if (mysqli_query($conn, $insertQuery)) {
        // If the query was successful, return a success message
        echo json_encode(array("status" => "success"));
    } else {
        // If the query failed, return an error message
        echo json_encode(array("status" => "error", "message" => "Failed to add user."));
    }
} else {
    // If the request is not a POST request, return an error message
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
}
?>
