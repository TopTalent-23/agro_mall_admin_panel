<?php
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$name = $_POST['name'];
$roll_no = $_POST['roll_no'];
$email_id = $_POST['email_id'];
$phone_no = $_POST['phone_no'];
$address = $_POST['address'];
$i_sem_sgpa = $_POST['i_sem_sgpa'];
$ii_sem_sgpa = $_POST['ii_sem_sgpa'];
$fy_cgpa = $_POST['fy_cgpa'];

 
 $servername = 'localhost';
$username = 'root';
$passwd = '';
$database = 'bhavesh';

//create a connection
$conn = mysqli_connect($servername, $username, $passwd, $database);
$sql = "INSERT INTO `sy_bca_students` (`Name`, `Roll_no`, `Email_id`, `Phone_no`, `Address`, `I_sem-sgpa`, `II_sem_sgpa`, `FY_cgpa`) VALUES ('$name', '$roll_no', '$email_id', '$phone_no', '$address', '$i_sem_sgpa', '$ii_sem_sgpa', '$fy_cgpa')";
$result = mysqli_query($conn, $sql);
//if database connection not successfull
if ($result) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success</strong>  Your details are submitted succesfully...
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  <a class="btn btn-primary" href="sybca.php" role="button">Home</a>
</div>';
}
else {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error</strong> roll no ' . $roll_no .' is already exists..
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
}
 ?>