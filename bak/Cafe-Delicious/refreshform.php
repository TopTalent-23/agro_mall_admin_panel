<?php
// Establishing connection with server by passing "server_name", "user_id", "password".
$dbHost     = "localhost";  
$dbUsername = "root";  
$dbPassword = "";  
$dbName     = "global_cafe_system";  
  
// Create database connection  
  $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
$name2=$_POST['name1']; // Fetching Values from URL
$email2=$_POST['email1'];
$contact2=$_POST['contact1'];
$gender2=$_POST['gender1'];
$msg2=$_POST['msg1'];
$sql = "insert into form_element(name, email, contact, gender, message) values ('$name2','$email2','$contact2','$gender2','$msg2')"; //Insert query
$result = mysqli_query($conn, $sql);
if($result){
echo "Data Submitted succesfully";
}

?>