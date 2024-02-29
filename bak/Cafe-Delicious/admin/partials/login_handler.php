<?php
echo 'Please wait...';
$logedin = false;
$error = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../../db_config.php';
    $email = $_POST['email'];
    
    $password = $_POST['password'];
    
        $sql = "SELECT * FROM `caffe` where email = '$email'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);
        if ($num == 1) {
            $row = mysqli_fetch_assoc($result);

            if ($password==$row['password']) {
                session_start();
                $_SESSION['logedin'] = true;
                $_SESSION['name'] = $row['cafe_name'];
                echo $_SESSION['name'];
               echo "success";
               header("location:../index.php");
            } else {
                $error = true;
                echo "error";
               
                header("location:../index.php");
            }




        } else {
            $_SESSION['logedin'] = false;
            header("location:../index.php");
        }
    
    
    

}
?>



