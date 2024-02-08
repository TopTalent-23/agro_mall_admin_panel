<?php
// Assuming you have a database connection file, include it here
include("../db_config.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = $_POST["name"];
    $phone = $_POST["phone"];
    $email = $_POST["email"];
    $message = $_POST["message"];

    // Example: Database connection
   

    // Check connection
   

    // Example: Insert data into the "messages" table
    $sql = "INSERT INTO messages1 (name, phone, email, message) VALUES ('$name', '$phone', '$email', '$message')";

    if (mysqli_query($conn, $sql)) {
        // Successful insertion
        echo "success";
    } else {
        // Error in insertion
        echo "error";
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Invalid request method
    echo "Invalid request.";
}
?>
