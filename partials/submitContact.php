<?php
// Assuming you have a database connection file, include it here
include("../db_config.php");

// Check if the form is submitted
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Example: Database connection
    include("../db_config.php");

    // Check connection
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Example: Insert data into the "messages1" table
    $sql = "INSERT INTO messages1 (name, phone, email, message) VALUES ('$name', '$phone', '$email', '$message')";

    if (mysqli_query($conn, $sql)) {
        // Successful insertion
        echo "success";
    } else {
        // Error in insertion
        echo "error: " . mysqli_error($conn); // Log MySQL error message
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Invalid request method
    echo "Invalid request.";
}

?>
