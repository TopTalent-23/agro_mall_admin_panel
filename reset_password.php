        <!DOCTYPE html>

<html>

<head>
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Include SweetAlert library -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

   
</head>
<body>
<?php
require_once 'db_config.php';
require_once('PHPMailer/PHPMailer/src/PHPMailer.php');
require_once('PHPMailer/PHPMailer/src/SMTP.php');
require_once('PHPMailer/PHPMailer/src/Exception.php');
//require 'vendor/autoload.php';
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

        echo '

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="">
                <div class="card">
                
                    <div class="card-header bg-success text-white">
                        <h4 class="mb-0">Reset Password</h4>
                    </div>
                   
                    <div class="card-body">
                        
                        
                        <form action="resetPasswordForm">
                        An otp has been sent to your email address.
                            <div class="form-group">
                             
                                <label for="otp">otp</label>
                                <input type="text" class="form-control" id="otp" name="otp" required>
                            </div>
                            <div class="form-group">
                                <label for="password">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirmPassword">Confirm Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="button" onclick="resetPassword()" class="btn btn-outline-success">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>';?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
function resetPassword() {
    // Get values from form fields
    var otp = $('#otp').val();
    var newPassword = $('#new_password').val();
    var confirmPassword = $('#confirm_password').val();

    // Perform client-side validation if needed

    // Send AJAX request to reset password
   $.ajax({
        type: "POST",
        url: "reset_password_handler.php",
        data: {
            otp: otp,
            new_password: newPassword,
            confirm_password: confirmPassword
        },
        success: function (response) {
            if (response === "success") {
                // Password reset successfully
                Swal.fire({
                    icon: "success",
                    title: "Password Reset Successful!",
                    text: "Your password has been reset successfully.",
                    confirmButtonColor: "#28a745",
                    confirmButtonText: "OK",
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Redirect to the previous page
                        window.history.back();
                    }
                });
            } else {
                // Display the error message using SweetAlert
                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "otp or password not matched",
                    confirmButtonColor: "#d33",
                    confirmButtonText: "OK",
                });
            }
        },
        error: function () {
            console.error("Error in AJAX request");
        },
    });
    
}
</script>

<?php echo '


        ';
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
        //$mail->addReplyTo('shweta1862004@gmail.com', 'Shweta'); // Set "Reply-To" to the customer's email

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset Request';
        $mail->Body    = "To reset your password, use the following OTP: $token";

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
</body>
</html>
