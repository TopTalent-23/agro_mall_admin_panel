<?php
require_once '../db_config.php';
require_once('../PHPMailer/PHPMailer/src/PHPMailer.php');
require_once('../PHPMailer/PHPMailer/src/SMTP.php');
require_once('../PHPMailer/PHPMailer/src/Exception.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $orderId = $_POST['orderId'];
    $newStatus = $_POST['newStatus'];

    // Get customer email address based on the order ID
    $customerEmail = getCustomerEmailByOrderId($orderId);

    if ($customerEmail) {
        // Send email to the customer informing about the new order status
        $result = sendStatusUpdateEmailToCustomer($customerEmail, $newStatus, $orderId);
        
        if ($result) {
            echo 'success';
        } else {
            echo 'error';
        }
    } else {
        echo 'Customer email not found for the given order ID.';
    }
} else {
    echo 'Invalid request.';
}

function getCustomerEmailByOrderId($orderId) {
    global $conn;

    $query = "SELECT email FROM orders WHERE order_id = '$orderId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['email'];
    } else {
        return null;
    }
}

function getOrderDetails($orderId) {
    global $conn;
    $orderId = mysqli_real_escape_string($conn, $orderId);
    $query = "SELECT orders.*, products.pr_name 
              FROM orders
              INNER JOIN products ON orders.product_id = products.sr_no
              WHERE orders.order_id = '$orderId'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $details = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $details[] = $row;
        }
        return $details;
    } else {
        return null;
    }
}

function sendStatusUpdateEmailToCustomer($customerEmail, $newStatus, $orderId) {
    global $conn;
    // Fetch additional order details from the database
    $orderDetails = getOrderDetails($orderId);

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bhavesh002jadhav@gmail.com';
        $mail->Password   = '40Z3cb6hxrXRzgpL';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // Recipients
        $mail->setFrom('bhavesh002jadhav@gmail.com', 'Ahire Agro Mall');
        $mail->addAddress($customerEmail);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Order Status Update';

        // Include order details in the email body
       $mail->Body = "<p>Dear Customer, your order status has been updated to: $newStatus</p>";
$mail->Body .= "<p>Order ID: $orderId</p>";

if (!empty($orderDetails)) {
    $mail->Body .= "<p><strong>Order Details:</strong></p>";
    foreach ($orderDetails as $product) {
        $mail->Body .= "<p><strong>Product Name:</strong> {$product['pr_name']}</p>";
        $mail->Body .= "<p><strong>Quantity:</strong> {$product['quantity']}</p>";
        // Add more details as needed
        
        $mail->Body .= "<hr>"; // Add a horizontal line to separate product details
    }
    $mail->Body .= "<p><strong>View Bill:</strong> <a href='https://ahireagromall.000webhostapp.com/admin_pannel/partials/invoice.php?orderID=$orderId'>Click here</a></p>";
        }

        $mail->send();

        return true;
    } catch (Exception $e) {
        // Log the error or handle it as needed
        error_log('Error sending email: ' . $mail->ErrorInfo);
        return false;
    }
}
?>
