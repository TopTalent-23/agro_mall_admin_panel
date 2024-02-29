<?php
include '../../db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $otp = $_POST['otp'];

    // Log received data for debugging
    error_log('Received OTP: ' . $otp);

    // Prepare and execute the SQL query to validate the OTP
    $validateOtpQuery = "SELECT * FROM customers WHERE reset_token = '$otp' AND reset_token_expires > NOW()";
    $validateResult = mysqli_query($conn, $validateOtpQuery);

    // Check if the query was successful and if any row was returned
    if ($validateResult && mysqli_num_rows($validateResult) > 0) {
        // OTP is valid
        echo 'success';
    } else {
        // Invalid OTP
        echo 'error';
    }
} else {
    // Invalid request method
    echo 'error';
}
?>
