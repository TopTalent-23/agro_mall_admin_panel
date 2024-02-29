<?php
require_once 'db_config.php';

// Set response header to JSON

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = $_POST['otp'];
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    // Initialize the response string
    $response = 'error'; // Default to 'error'

    // Validate OTP and Password
    if (validateOTP($otp) && validatePassword($newPassword, $confirmPassword)) {
        // Get user details using the validated OTP
        $user = getUserByValidOTP($otp);

        if ($user) {
            // Update the password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
            updatePassword($user['sr_no'], $hashedPassword);

            // Clear the OTP and its expiration in the database
            clearOTP($user['sr_no']);

            // Update the response for success
            $response = 'success';
        }
    }

    // Send the response
    echo $response;
    exit();
}

// Send an error response for invalid request method

echo 'error';
exit();

function validateOTP($otp) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM customers WHERE reset_token = ? AND reset_token_expires > NOW()");
    $stmt->bind_param("s", $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->num_rows > 0;
}

function validatePassword($password, $confirmPassword) {
    return $password === $confirmPassword;
}

function getUserByValidOTP($otp) {
    global $conn;
    $stmt = $conn->prepare("SELECT * FROM customers WHERE reset_token = ? AND reset_token_expires > NOW()");
    $stmt->bind_param("s", $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    return $result->fetch_assoc();
}

function updatePassword($userId, $hashedPassword) {
    global $conn;
    $stmt = $conn->prepare("UPDATE customers SET password = ?, reset_token = NULL, reset_token_expires = NULL WHERE sr_no = ?");
    $stmt->bind_param("si", $hashedPassword, $userId);
    $stmt->execute();
}

function clearOTP($userId) {
    global $conn;
    $stmt = $conn->prepare("UPDATE customers SET reset_token = NULL, reset_token_expires = NULL WHERE sr_no = ?");
    $stmt->bind_param("i", $userId);
    $stmt->execute();
}
?>
