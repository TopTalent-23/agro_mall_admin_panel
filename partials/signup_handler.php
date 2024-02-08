<?php
$showerror = false;
$signup = false;
require '../db_config.php';
 $path = $_SERVER['HTTP_REFERER'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $pincode = $_POST['pincode'];
    $password = $_POST['password'];

    $hash_password = password_hash($password, PASSWORD_DEFAULT);

    $sql = "INSERT INTO `customers` (`password`, `cust_name`, `cust_address`, `cust_phone`, `cust_email`, `cust_pincode`) VALUES ('$hash_password', '$name', '$address', '$phone', '$email', '$pincode')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo'<script> alert("Signup successfull... Please login")</script>';
       echo "<script>window.location.href='".$path."';</script>";
        exit();
    } else {
       echo'<script> alert("Error...! Email or Phone Already Exist")</script>';
        $showerror = true;
        echo "<script>window.location.href='".$path."';</script>";
        exit();
    }
} else {
    $path = $_SERVER['HTTP_REFERER'];
}
?>
