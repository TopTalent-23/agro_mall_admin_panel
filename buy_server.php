<?php
include('db_config.php');
session_start();
date_default_timezone_set('Asia/Kolkata');
$sql = "SET time_zone = '+05:30'";
mysqli_query($conn, $sql);
function generateOrderID() {
    $timestamp = time();
    $randomNumber = mt_rand(1000, 9999);
    $uniqueID = uniqid();
    $orderID = 'ORD-' . $randomNumber . $uniqueID;
    return $orderID;
}


$orderID = generateOrderID();

if (
    isset($_POST['amt']) && isset($_POST['name']) && isset($_POST['pno']) &&
    isset($_POST['email']) && isset($_POST['addr']) && isset($_POST['pin']) &&
    isset($_POST['quantity']) && isset($_POST['pr_id']) && isset($_POST['usr'])
) {
    $usr_id = $_POST['usr'];
    $amt = $_POST['amt'];
    $name = $_POST['name'];
    $pno = $_POST['pno'];
    $email = $_POST['email'];
    $quantity = isset($_POST['quantity']) ? intval($_POST['quantity']) : 0;
    $addr = $_POST['addr'];
    $pin = isset($_POST['pin']) ? intval($_POST['pin']) : 0;
    $pr_id = isset($_POST['pr_id']) ? intval($_POST['pr_id']) : 0;
    $payment_status = "pending";
    $payment_mode = "Online";

    $insertQuery = "INSERT INTO `orders` (`order_id`, `usr_id`, `product_id`, `name`, `phone_no`, `email`, `quantity`, `address`, `pin`, `payment_status`, `order_status`, `payment_mode`, `shopVisit`, `payid`, `amount`, `date_time`)
        VALUES ('$orderID', '$usr_id', '$pr_id', '$name', '$pno', '$email', '$quantity', '$addr', '$pin', '$payment_status', '-', '$payment_mode', '-', '-', '$amt', NOW())";

    if (mysqli_query($conn, $insertQuery)) {
        $_SESSION['OID'] = mysqli_insert_id($conn);
        
        if (isset($_POST['payment_id'])) {
            $payment_id = $_POST['payment_id'];
            $updateQuery = "UPDATE orders SET payment_status='complete', payid='$payment_id', order_status='confirmed' WHERE order_id='$orderID'";

            if (mysqli_query($conn, $updateQuery)) {
                // Payment and order update successful
                echo 'success';
            } else {
                // Error updating order status
                echo 'Error updating order status: ' . mysqli_error($conn);
            }
        } else {
            // Payment not received, still mark order as successful
            echo 'success';
        }
    } else {
        // Error inserting order data
        echo 'Error inserting order data: ' . mysqli_error($conn);
    }
} else {
    // Incomplete data received
    echo 'Incomplete data received';
}
?>
