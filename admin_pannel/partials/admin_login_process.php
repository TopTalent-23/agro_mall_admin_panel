<?php
// Start the session
$logedin = false;
session_start();
include ("../../db_config.php");

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize user input
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    // Prepare the SQL query to fetch admin user from the database
    $stmt = $conn->prepare("SELECT id, username, password, role FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Verify the password
        if ($password==$row['password']) {
            // Password is correct, set up the session and redirect to the admin dashboard
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $row['username'];
            $_SESSION['admin_role'] = $row['role']; // Assuming 'role' is a field in the admin_users table
            $_SESSION['admin_logedin'] = true;
            header("Location: ../admin_dashboard.php");
            
            exit();
        } else {
            // Invalid password
            $_SESSION['login_error'] = "Invalid username or password.";
            header("Location: admin_login.php");
            exit();
        }
    } else {
        // Admin user not found
        $_SESSION['login_error'] = "Invalid username or password.";
        header("Location: admin_login.php");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Form not submitted!";
}
?>
