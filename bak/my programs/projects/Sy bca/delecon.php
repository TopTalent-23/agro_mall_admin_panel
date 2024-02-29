<?php
    if ($_SERVER['REQUEST_METHOD']=='POST') {

    $roll_no=$_POST['roll_no'];
$delete = $_POST['delete'];


    $servername='localhost';
    $username='root';
    $passwd='';
    $database='bhavesh';

    //create a connection
    $conn=mysqli_connect($servername, $username, $passwd, $database);
    if ($result) {
        echo '<script type="text/javascript" charset="utf-8">
            confirm("do you really want to delete post")
        </script>';
    }
    $sql="DELETE FROM `sy_bca_students` WHERE `sy_bca_students`.`Roll_no` = $roll_no";
    $result=mysqli_query($conn, $sql);
    //if database connection not successfull
    if ($result) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success</strong>  Your record has been deleted successfully...
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <a class="btn btn-primary" href="sybca.php" role="button">Home</a>
    </div>';
    }
    else {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error</strong> Please Enter your roll no.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    }
    ?>