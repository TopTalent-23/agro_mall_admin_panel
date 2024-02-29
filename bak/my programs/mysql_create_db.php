<?php 
echo 'wellcome to the creating process of mysql database <br>';
//connecting mto the database
$servername = 'localhost';
$username = 'root';
$passwd = '';
//create a connection
$conn = mysqli_connect($servername, $username, $passwd);

//if connection was not successfull
if (!$conn) {
    echo 'connecting to the database not successful<br>';
}
else {
    echo 'database connection successful <br>';
}
//creating a database
$sql = "CREATE DATABASE bhavesh4";
$result = mysqli_query($conn, $sql);
//if database connection not successfull
if ($result) {
    echo 'database created successfully';
}
else {
    echo "database was not created successfully b'coz of this error-----> ". mysqli_error($conn);
    
    
}




?>