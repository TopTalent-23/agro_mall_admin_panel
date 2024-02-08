<?php
session_start();
include('db.php');
if(isset($_POST['amt']) && isset($_POST['name']) && isset($_POST['pno']) && isset($_POST['email']) && isset($_POST['addr']) && isset($_POST['pin']) && isset($_POST['quantity']) && isset($_POST['pr_id']) ){
  $usr_id=34;
    $amt=$_POST['amt'];
    $name=$_POST['name'];
    $pno=$_POST['pno'];
    $email=$_POST['email'];
    $quantity=$_POST['quantity'];
    $addr=$_POST['addr'];
    $pin=$_POST['pin'];
    $pr_id=$_POST['pr_id'];
    $payment_status="pending";
    $added_on=date('Y-m-d h:i:s');
    mysqli_query($con,"INSERT INTO `orders` (`usr_id`, `product_id`, `name`, `phone_no`, `email`, `quantity`, `address`, `pin`, `payment_status`, `amount`, `date_time`)
VALUES ('$usr_id', '$pr_id', '$name', '$pno', '$email', '$quantity', '$addr', '$pin', '$payment_status', '$amt', '$added_on')");
    $_SESSION['OID']=mysqli_insert_id($con);
}


if(isset($_POST['payment_id']) && isset($_SESSION['OID'])){
    $payment_id=$_POST['payment_id'];
    $usr_id=34;
    mysqli_query($con,"update orders set payment_status='complete',payid='$payment_id' where usr_id='$usr_id'");
}
?>