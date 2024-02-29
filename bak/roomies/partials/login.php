<?php
    require 'configure.php';
    session_start();
    if(isset($_POST['submit'])){
        echo 'welcome';
        $pass=$_POST['password'];
        $email=$_POST['email'];
        $sql = "SELECT * FROM `register` WHERE email='$email' AND password='$pass';";
        $result=mysqli_query($connect,$sql);
        if (mysqli_num_rows($result)>0) {
            while ($row=mysqli_fetch_array($result)) {
                $_SESSION['name']=$row['name'];
                $_SESSION['id']=$row['Id'];
                $_SESSION['email']=$row['email'];
                echo'<script> alert("Login successfull")</script>';
                header('location:../index.php');
            }
        }else{
            echo '<script> alert("Email And Password Not match")</script>';
            header('refresh:0; url=../register.php');
        }
    }else{
        header('location:../index.php');
    }
?>