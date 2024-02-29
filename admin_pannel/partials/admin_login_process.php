<?php
// Start the session
session_start();
include("../../db_config.php");
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize user input
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
    $password = $_POST['password'];

    // Prepare the SQL query to fetch admin user from the database
    $stmt = $conn->prepare("SELECT id, username, password, role, status FROM admin_users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        // Verify the password using password_verify()
        $status = $row['status'];
        if ($status === 'blocked') {
            // User is blocked
            $_SESSION['login_error'] = "Your account is blocked. Please contact the admin for assistance.";
            $_SESSION['display_alert'] = true;
            header("Location: admin_login.php");
            exit();
        }

        if (password_verify($password, $row['password'])) {
            // Password is correct, set up the session and redirect to the admin dashboard
            $_SESSION['admin_id'] = $row['id'];
            $_SESSION['admin_username'] = $row['username'];
            $_SESSION['admin_role'] = $row['role']; // Assuming 'role' is a field in the admin_users table

            if (isset($_SESSION['admin_role'])) {
                switch ($_SESSION['admin_role']) {
                    case 'admin':
                        $_SESSION['admin_logedin'] = true;
                        header("Location: ../admin_dashboard.php");
                        exit();
                    case 'deliveryBoy':
                        $_SESSION['deliveryBoy_logedin'] = true;
                        header("Location: ../delivery/deliveryboy.php");
                        exit();
                    case 'salesman':
                        $_SESSION['salesman_logedin'] = true;
                        header("Location: ../make_order.php");
                        exit();
                    case 'manager':
                        $_SESSION['manager_logedin'] = true;
                        header("Location: ../admin_dashboard.php");
                        exit();
                    case 'executiveOfficer':
                        $_SESSION['executiveOfficer_logedin'] = true;
                        header("Location: ../orders.php");
                        exit();
                    default:
                        // Handle unexpected admin role
                        echo "Unknown admin role";
                        exit();
                }
            } else {
                // Invalid password
                $_SESSION['login_error'] = "Invalid username or password.";
                $_SESSION['display_alert'] = true;
                header("Location: admin_login.php");
                exit();
            }
        } else {
            // Invalid password
            $_SESSION['login_error'] = "Invalid username or password.";
            $_SESSION['display_alert'] = true;
            header("Location: admin_login.php");
            exit();
        }
    } else {
        // Admin user not found
        $_SESSION['login_error'] = "Invalid username or password.";
        $_SESSION['display_alert'] = true;
        header("Location: admin_login.php");
        exit();
    }
} else {
    echo "Form not submitted!";
    exit();
}
?>
