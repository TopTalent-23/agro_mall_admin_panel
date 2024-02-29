<?php
// update_delivery_status.php

// Replace with your actual database connection code
$servername = "localhost";
//$dbPort = 8120;  // Change this to the port you are using
$username = "id21908296_root";
$password = "Mo21nu94@jadhav";
$dbname = "id21908296_ahire_agro_mall";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get order ID and new status from AJAX request
$orderID = $_POST['order_id'];
$newStatus = $_POST['new_status'];

// Update the delivery status in the orders table
$updateQuery = "UPDATE orders SET order_status = ? WHERE order_id = ?";
$stmt = $conn->prepare($updateQuery);

if ($stmt === false) {
    echo "Error in prepared statement: " . $conn->error;
} else {
    $stmt->bind_param("ss", $newStatus, $orderID);

    if ($stmt->execute()) {
        echo "Success";
    } else {
        echo "Error updating status: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
