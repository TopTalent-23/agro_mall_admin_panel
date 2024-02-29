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
    $username=$_SESSION['admin_username'];
    // Update order status to delivered
    $updateOrderStatusQuery = "UPDATE orders SET order_status = 'delivered' WHERE order_id = '$orderId'";
    $updateOrderStatusResult = mysqli_query($conn, $updateOrderStatusQuery);

    if ($updateOrderStatusResult) {
        $sql = "INSERT INTO `delivery` (`orderId`, `username`, `paymentMode`, `collectedAmt`, `datetime`) VALUES ('$orderId', '$username', 'online', '00', current_timestamp());"; // Corrected from collectedAmt to $collectedAmt
        $result = mysqli_query($conn, $sql);
        // Successfully updated order status
        echo json_encode(['status' => 'success', 'message' => 'Order status updated to delivered.']);
    } else {
        // Failed to update order status
        echo json_encode(['status' => 'error', 'message' => 'Failed to update order status.']);
    }
} else {
    // Invalid request method
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
