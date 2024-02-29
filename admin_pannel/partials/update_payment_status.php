<?php
// update_payment_status.php

session_start();


include("../../db_config.php");
// Assuming you have a database connection already established

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'];
    $paymentMode = $_POST['paymentMode'];

    // Assuming you have an 'orders' table with columns 'order_id', 'payment_status', 'payment_mode'
    // Update the payment_status and payment_mode columns only for the specified order ID
    $updateQuery = "UPDATE orders SET payment_status = 'complete', payment_mode = ? WHERE order_id = ?";
    $stmt = $conn->prepare($updateQuery);

    if ($stmt === false) {
        header('Content-Type: application/json');
        echo json_encode(['success' => false]);
        exit;
    }

    // Bind parameters and execute the update query
    $stmt->bind_param('ss', $paymentMode, $orderId);
    $stmt->execute();

    // Check if the update was successful
    if ($stmt->affected_rows > 0) {
        header('Content-Type: application/json');
        echo json_encode(['success' => true]);
    } else {
        header('Content-Type: application/json');
        echo json_encode(['success' => false]);
    }

    $stmt->close();
} else {
    // Invalid request method
    header('Content-Type: application/json');
    echo json_encode(['success' => false]);
}
?>
