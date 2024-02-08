<?php
include('../../db_config.php');

function generateOrderID() {
    // Get the current timestamp
    $timestamp = time();

    // Generate a random number between 1000 and 9999
    $randomNumber = mt_rand(1000, 9999);

    // Generate a unique identifier using uniqid()
    $uniqueID = uniqid();

    // Concatenate the timestamp, random number, and unique identifier
    $orderID = 'ORD-' . $randomNumber . $uniqueID;

    // Return the generated order ID
    return $orderID;
}

$orderID = generateOrderID();

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$address = $_POST['address'];
$pin = $_POST['pin'];
$paymentStatus = $_POST['paymentStatus'];
$paymentMode = $_POST['paymentMode'];

// Initialize total amount
$totalAmount = 0;

// Get and insert product details
$productDetails = $_POST['products'];
foreach ($productDetails as $product) {
    $productID = $product['productID'];
    $quantity = $product['quantity'];
    $price = $product['price'];

   

    // Insert customer and product details into the orders table
    $insertOrderDetails = "INSERT INTO orders (order_id, product_id, name, phone_no, email, quantity, address, pin, payment_status, payment_mode, order_status, shopVisit, payid, amount) 
                           VALUES ('$orderID', $productID, '$name', '$phone', '$email', $quantity, '$address', '$pin', '$paymentStatus', '$paymentMode', 'delivered', 'ShopVisit', '', $price)";
    $resultOrderDetails = mysqli_query($conn, $insertOrderDetails);

    if (!$resultOrderDetails) {
        die('Error inserting order details: ' . mysqli_error($conn));
    }
}

// Send the order ID as JSON response
echo json_encode(['orderID' => $orderID]);

mysqli_close($conn);
?>
