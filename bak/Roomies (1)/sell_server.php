<?php
   $connect=mysqli_connect("localhost","root","","project") or die("can not connect to data base");
   if(isset($_POST['payid']) && isset($_POST['amount']) && isset($_POST['availablebed']) && isset($_POST['bprice']) && isset($_POST['address']) && isset($_POST['pin']) && isset($_POST['mno']) ){
    $pay_id=$_POST['payid'];
    $amount=$_POST['amount'];  
    $available_bed=$_POST['availablebed'];
    $bprice=$_POST['bprice'];
    $address=$_POST['address'];
    $pin=$_POST['pin'];
    $mno=$_POST['mno'];
    session_start();
    if(isset($_SESSION['id'])){
        $sellid=$_SESSION['id'];
    }
    $sql="INSERT INTO `sell` (`bed_available`, `bed_price`, `Address`, `pin`, `mno`, `payid`, `amount`, `sellid`) VALUES ('$available_bed', '$bprice', '$address', '$pin', '$mno', '$pay_id', '$amount', '$sellid')";
    $result=mysqli_query($connect,$sql);
}
?>