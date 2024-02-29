<?php
   $connect=mysqli_connect("localhost","root","","project") or die("can not connect to data base");
   if(isset($_POST['payid']) && isset($_POST['amount']) && isset($_POST['availablebed']) && isset($_POST['bprice']) && isset($_POST['state']) && isset($_POST['district_list']) && isset($_POST['taluka']) && isset($_POST['village']) && isset($_POST['nearby']) && isset($_POST['pin']) && isset($_POST['mno']) && isset($_POST['discription']) ){
    $pay_id=$_POST['payid'];
    $amount=$_POST['amount'];  
    $available_bed=$_POST['availablebed'];
    $bprice=$_POST['bprice'];
    $state=$_POST['state'];
    $district_list=$_POST['district_list'];
    $taluka=$_POST['taluka'];
    $village=$_POST['village'];
    $nearby=$_POST['nearby'];
    $discription=$_POST['discription'];
    $pin=$_POST['pin'];
    $mno=$_POST['mno'];
    session_start();
    if(isset($_SESSION['id'])){
        $sellid=$_SESSION['id'];
    }
    $sql="INSERT INTO `sell` (`bed_available`, `bed_price`, `state`, `district`, `taluka`, `village`, `nearby`, `pin`, `mno`, `discription`, `payid`, `amount`, `sellid`) VALUES ('$available_bed', '$bprice', '$state', '$district', '$taluka', '$village', '$nearby', '$pin', '$mno', '$discription', '$pay_id', '$amount', '$sellid')";
    $result=mysqli_query($connect,$sql);
}
?>