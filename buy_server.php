<?php
include('db_config.php');

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

// Example usage
$orderID = generateOrderID();

if (isset($_POST['amt']) && isset($_POST['name']) && isset($_POST['pno']) && isset($_POST['email']) && isset($_POST['addr']) && isset($_POST['pin']) && isset($_POST['quantity']) && isset($_POST['pr_id']) && isset($_POST['usr'])) {
    $usr_id = $_POST['usr'];
    $amt = $_POST['amt'];
    $name = $_POST['name'];
    $pno = $_POST['pno'];
    $email = $_POST['email'];
    $quantity = $_POST['quantity'];
    $addr = $_POST['addr'];
    $pin = $_POST['pin'];
    $pr_id = $_POST['pr_id'];
    $payment_status = "pending";
    if (isset($_POST['shopVisit'])) {
        $shopVisit=$_POST['shopVisit'];
       }
    $payment_mode = "Online";
    mysqli_query($conn, "INSERT INTO `orders` (`order_id`, `usr_id`, `product_id`, `name`, `phone_no`, `email`, `quantity`, `address`, `pin`, `payment_status`, `payment_mode`, `amount`, `shopVisit`)
        VALUES ('$orderID', '$usr_id', $pr_id, '$name', '$pno', '$email', '$quantity', '$addr', '$pin', '$payment_status', '$payment_mode', '$amt','$shopVisit')");
    
    $_SESSION['OID'] = mysqli_insert_id($conn);
    
    if (isset($_POST['payment_id'])) {
        $payment_id = $_POST['payment_id'];
        mysqli_query($conn, "UPDATE orders SET payment_status='complete', payid='$payment_id', order_status='confirmed' WHERE order_id='$orderID'");
    }
}
?>
