<?php 
echo 'wellcome to the connection process of mysql database <br>';
//connecting mto the database
$servername = 'localhost';
$username = 'root';
$passwd = '';
//create a connection
$conn = mysqli_connect($servername, $username, $passwd);
//if connection was not successfull
if (!$conn) {
    echo 'connecting to the database not successful';
}
else {
    echo 'database connection successful';
}



?>