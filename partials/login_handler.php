<?php
echo 'Please wait...';
$logedin = false;
$error = false;
session_start();
$path = $_SERVER['HTTP_REFERER'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../db_config.php';

    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $password = $_POST['password'];

    if ($email) {
        $sql = "SELECT * FROM `customers` WHERE cust_email = '$email'";
    } elseif ($phone) {
        $sql = "SELECT * FROM `customers` WHERE cust_phone = '$phone'";
    }

    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            echo '<script>alert("Login successful");</script>';
            $_SESSION['logedin'] = true;
            $_SESSION['id'] = $row['sr_no'];

            echo "<script>window.location.href='".$path."';</script>";
        } else {
            echo '<script>alert("Password not match");</script>';
            $error = true;
            echo "<script>window.location.href='".$path."';</script>";
        }
    } else {
        echo '<script>alert("User not found");</script>';
        echo "<script>window.location.href='".$path."';</script>";
    }
}
?>
