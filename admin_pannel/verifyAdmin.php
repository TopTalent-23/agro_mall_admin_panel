<?php
session_start();
if (!isset($_SESSION['admin_logedin']))  {
    // Display an alert using JavaScript
    echo "<script>alert('You do not have access to this page. Please go back.')</script>";
  
    // Redirect the user to the previous page
    echo "<script>window.history.back();</script>";
  
    // Exit the script to prevent further execution
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Verification</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <script>
        // Function to prompt for admin password and set the session
        function promptForAdminPassword(callback) {
            var adminPassword = prompt("Enter Admin Password:");

            if (adminPassword) {
                // Make an AJAX request to validate the admin password
                $.ajax({
                    type: "POST",
                    url: "security/validate_admin_password.php", // Replace with the actual path to your server-side validation script
                    data: { adminPassword: adminPassword },
                    success: function (response) {
                        if (response === "valid") {
                            // Redirect to manageUsers.php if the admin password is valid
                            window.location.href = "manageUsers.php";
                        } else {
                            alert("Incorrect Admin Password!");
                            callback(false);
                        }
                    },
                    error: function () {
                        alert("Error validating admin password.");
                        callback(false);
                    }
                });
            } else {
                callback(false);
            }
        }

        // Prompt for admin password before allowing the page to load
        promptForAdminPassword(function (isAdminAuthenticated) {
            if (!isAdminAuthenticated) {
                // If admin is not authenticated, prevent the page from loading
                alert("Access denied. Incorrect Admin Password.");
                window.stop();
            }
        });
    </script>
</body>
</html>
