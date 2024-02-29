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
    isset($_POST['user_name']) &&
    isset($_POST['user_phone']) &&
    isset($_POST['user_email']) &&
    isset($_POST['user_addr']) &&
    isset($_POST['user_pin']) &&
    isset($_POST['user_id']) &&
    isset($_POST['productDetails'])
) {
    // Extract data from POST
    $name = $_POST['user_name'];
    $phone = $_POST['user_phone'];
    $email = $_POST['user_email'];
    $addr = $_POST['user_addr'];
    $pin = $_POST['user_pin'];
    $id = $_POST['user_id'];
    $payment_status = "pending";
    $payment_mode = "Cash-On-Delivery";
    $productDetails = json_decode($_POST['productDetails'], true);

    // Establish database connection (Ensure that $conn is defined in db_config.php)
    // $conn = mysqli_connect("your_host", "your_username", "your_password", "your_database");
    if (!$conn) {
        error_log("Database connection failed: " . mysqli_connect_error(), 3, "debug.log");
        die("Database connection failed: " . mysqli_connect_error());
    }

    // Iterate through each product in the cart
    foreach ($productDetails as $product) {
        $product_id = $product['pr_id'];
        $quantity = $product['quantity'];
        $price = $product['price'];

        // Use real_escape_string to prevent SQL injection
        $id = mysqli_real_escape_string($conn, $id);
        $orderID = mysqli_real_escape_string($conn, $orderID);
        $product_id = mysqli_real_escape_string($conn, $product_id);
        $name = mysqli_real_escape_string($conn, $name);
        $phone = mysqli_real_escape_string($conn, $phone);
        $email = mysqli_real_escape_string($conn, $email);
        $quantity = mysqli_real_escape_string($conn, $quantity);
        $addr = mysqli_real_escape_string($conn, $addr);
        $pin = mysqli_real_escape_string($conn, $pin);
        $payment_status = mysqli_real_escape_string($conn, $payment_status);
        $payment_mode = mysqli_real_escape_string($conn, $payment_mode);

        // Build the SQL query to insert order details
        $insertOrderDetails = "INSERT INTO orders (usr_id, order_id, product_id, name, phone_no, email, quantity, address, pin, payment_status, payment_mode, order_status, payid, shopVisit, amount, date_time) 
                               VALUES ('$id','$orderID', '$product_id', '$name', '$phone', '$email', '$quantity', '$addr', '$pin', '$payment_status', '$payment_mode', 'not_confirmed', '-', '-', '$price', NOW())";

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

    // Close the database connection
    mysqli_close($conn);

    // Provide a success message or redirect as needed
    echo "Order processed successfully";
} else {
    // Log failure message for incomplete or missing POST data
    error_log('Incomplete or missing POST data from Razorpay.', 3, 'debug.log');
    die('Incomplete or missing POST data from Razorpay.');
}
?>
