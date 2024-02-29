<?php 
 include 'partials/configure.php';
 if (isset($_GET['id'])) {
    $val=base64_decode( $_GET['id']);
    $sql="DELETE FROM img_upload WHERE id = $val
    ";
    $result=mysqli_query($connect,$sql);

    $sqlcmd="DELETE FROM sell WHERE id = $val";
    $result1=mysqli_query($connect,$sqlcmd);
    header('location:my_rooms.php');
 }
?>