<?php
session_start();
include '../../db_config.php';
date_default_timezone_set('Asia/Kolkata');

// Set timezone for MySQL connection
$sql = "SET time_zone = '+05:30'";
mysqli_query($conn, $sql);
if (!isset($_SESSION['deliveryBoy_logedin']) && !isset($_SESSION['admin_logedin'])) {
    session_destroy();
    header("Location: ../partials/admin_login.php");
    exit();
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'];
    $collectedAmt=$_POST['totalAmount'];
    $paymentMode = $_POST['paymentMode'];
    $username=$_SESSION['admin_username'];

    // Update payment status and mode
    $updateQuery = "UPDATE orders SET payment_status = 'complete', payment_mode = 'cash-on-delivery-$paymentMode', order_status='delivered' WHERE order_id = '$orderId'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        $sql = "INSERT INTO `delivery` (`orderId`, `username`, `paymentMode`, `collectedAmt`, `datetime`) VALUES ('$orderId', '$username', 'cod', '$collectedAmt', current_timestamp());"; // Corrected from collectedAmt to $collectedAmt
        $result = mysqli_query($conn, $sql);
        // Successfully updated
        echo json_encode(['status' => 'success', 'message' => 'Payment status and mode updated successfully.']);
    } else {
        // Failed to update
        echo json_encode(['status' => 'error', 'message' => 'Failed to update payment status and mode.']);
    }
} else {
    // Invalid request method
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
