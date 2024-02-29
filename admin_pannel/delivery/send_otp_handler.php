<?php
require_once '../../db_config.php';
require_once('../../PHPMailer/PHPMailer/src/PHPMailer.php');
require_once('../../PHPMailer/PHPMailer/src/SMTP.php');
require_once('../../PHPMailer/PHPMailer/src/Exception.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    // Validate the email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo 'Invalid email address.';
        exit();
    }

    $user = getUserByEmail($email);

    if ($user) {
        $customerEmail = $user['cust_email'];

        $token = generateRandomOTP();
        $tokenExpiration = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Store the token and its expiration timestamp in the database
        updateResetToken($user['sr_no'], $token, $tokenExpiration);

        // Send the reset email with "Reply-To" set to the customer's email
        sendResetEmail($customerEmail, $token);
        echo 'success';
    } else {
        echo 'Email not found in our records.';
    }
} else {
    echo 'Invalid request.';
}

function generateRandomOTP() {
    return str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);
}

function getUserByEmail($email) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM customers WHERE cust_email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

function updateResetToken($userId, $token, $expiration) {
    global $conn;
    $stmt = $conn->prepare("UPDATE customers SET reset_token = ?, reset_token_expires = ? WHERE sr_no = ?");
    $stmt->bind_param("ssi", $token, $expiration, $userId);
    $stmt->execute();
}

function sendResetEmail($email, $token) {
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';  // Specify your SMTP server
        $mail->SMTPAuth   = true;
        $mail->Username   = 'bhavesh002jadhav@gmail.com'; // SMTP username (full email address)
        $mail->Password   = '40Z3cb6hxrXRzgpL'; // App Password generated from Gmail
        $mail->SMTPSecure = 'tls'; // Enable TLS encryption
        $mail->Port       = 587; // TCP port for TLS connection

        // Recipients
        $mail->setFrom('bhavesh002jadhav@gmail.com', 'Ahire Agro Mall');
        $mail->addAddress($email); // Add a recipient

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "Your order is out for delivery. To ensure a smooth delivery process, please provide the following OTP: $token";


        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
