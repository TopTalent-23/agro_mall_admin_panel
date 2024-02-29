<?php
include('db_config.php');
date_default_timezone_set('Asia/Kolkata');
$sql = "SET time_zone = '+05:30'";
mysqli_query($conn, $sql);
// Enable error reporting and display errors
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Function to generate a unique order ID
function generateOrderID() {
    $timestamp = time();
    $randomNumber = mt_rand(1000, 9999);
    $uniqueID = uniqid();
    $orderID = 'ORD-' . $randomNumber . $uniqueID;
    return $orderID;
}

// Generate a unique order ID
$orderID = generateOrderID();

// Check if required POST data is set
if (
    isset($_POST['payment_id']) &&
    isset($_POST['user_name']) &&
    isset($_POST['user_phone']) &&
    isset($_POST['user_email']) &&
    isset($_POST['user_addr']) &&
    isset($_POST['user_pin']) &&
    isset($_POST['user_id']) &&
    isset($_POST['productDetails'])
) {
    // Extract data from POST
    $payment_id = $_POST['payment_id'];
    $name = $_POST['user_name'];
    $phone = $_POST['user_phone'];
    $email = $_POST['user_email'];
    $addr = $_POST['user_addr'];
    $pin = $_POST['user_pin'];
    $id = $_POST['user_id'];
    $productDetails = json_decode($_POST['productDetails'], true);
// Add debugging output
error_log("Payment ID: $payment_id", 3, "debug.log");
error_log("Name: $name", 3, "debug.log");
error_log("Phone: $phone", 3, "debug.log");
error_log("Email: $email", 3, "debug.log");
error_log("Address: $addr", 3, "debug.log");
error_log("Pincode: $pin", 3, "debug.log");
error_log("User ID: $id", 3, "debug.log");
error_log("Product Details: " . print_r($productDetails, true), 3, "debug.log");

    // Set initial payment status and mode
    $payment_status = "pending";
    $payment_mode = "Online";

    // Iterate through each product in the cart
    foreach ($productDetails as $product) {
        $product_id = $product['pr_id'];
        $quantity = $product['quantity'];
        $price = $product['price'];

        // Build the SQL query to insert order details
        $insertOrderDetails = "INSERT INTO orders (usr_id, order_id, product_id, name, phone_no, email, quantity, address, pin, payment_status, payment_mode, order_status, payid, shopVisit, amount, date_time) 
                               VALUES ('$id','$orderID', '$product_id', '$name', '$phone', '$email', '$quantity', '$addr', '$pin', '$payment_status', '$payment_mode', 'not_confirmed', '-','-', '$price', NOW())";

        // Log SQL query for debugging
        error_log("SQL Query (Insert): $insertOrderDetails", 3, "debug.log");

        // Execute the SQL query to insert order details
        if (!mysqli_query($conn, $insertOrderDetails)) {
            // Log MySQL error
            $error_message = mysqli_error($conn);
            error_log("Error inserting order details: $error_message", 3, 'debug.log');
            die("Error inserting order details: $error_message");
        }
    }

    // Build the SQL query to update order status and payment details
    $updateQuery = "UPDATE orders SET payment_status='complete', payid='$payment_id', order_status='confirmed' WHERE order_id='$orderID'";

    // Log SQL query for updating order status
    error_log("SQL Query (Update): $updateQuery", 3, "debug.log");

    // Execute the SQL query to update order status
    if (!mysqli_query($conn, $updateQuery)) {
        // Log MySQL error
        $error_message = mysqli_error($conn);
        error_log("Error updating order status: $error_message", 3, 'debug.log');
        die("Error updating order status: $error_message");
    } else {
        // Log success message
        error_log('Order status updated successfully.', 3, 'debug.log');
        echo 'Order status updated successfully.';
    }
} else {
    // Log failure message for incomplete or missing POST data
    error_log('Incomplete or missing POST data from Razorpay.', 3, 'debug.log');
    die('Incomplete or missing POST data from Razorpay.');
}
?>