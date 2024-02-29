<?php
// Establishing connection with server by passing "server_name", "user_id", "password".
$dbHost     = "localhost";  
$dbUsername = "root";  
$dbPassword = "";  
$dbName     = "global_cafe_system";  
  
// Create database connection  
  $conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
$cafe_id2=$_POST['cafe_id1']; // Fetching Values from URL
$dish_id2=$_POST['dish_id1'];
$dish_name2=$_POST['dish_name1'];
$cust_id2=$_POST['cust_id1'];
$quantity2=$_POST['quantity1'];
$table_no2=$_POST['table_no1'];
$sql = "insert into orders(cafe_id, dish_name, dish_id, customer_id, quantity, table_no) values ('$cafe_id2', '$dish_name2','$dish_id2','$cust_id2','$quantity2','$table_no2')"; //Insert query
$result = mysqli_query($conn, $sql);
if($result){
echo "Data Submitted succesfully";
}

?>