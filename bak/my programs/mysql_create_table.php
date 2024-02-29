<?php 
echo 'wellcome to the creating process of mysql table in a exists database <br>';
//connecting mto the database
$servername = 'localhost';
$username = 'root';
$passwd = '';
$database = 'bhavesh';
//create a connection
$conn = mysqli_connect($servername, $username, $passwd, $database);

//if connection was not successfull
if (!$conn) {
    echo 'connecting to the database not successful<br>';
}
else {
    echo 'database connection successful <br>';
}
//creating a table
$sql = 'CREATE TABLE `stu` ( `sid` INT(4) NOT NULL AUTO_INCREMENT , `sname` VARCHAR(50) NOT NULL , `saddress` VARCHAR(50) NOT NULL , `rollno` INT(3) NOT NULL , PRIMARY KEY (`sid`))';
$result = mysqli_query($conn, $sql);
//if database connection not successfull
if ($result) {
    echo 'TABLE created successfully';
}
else {
    echo "tabble was not created successfully b'coz of this error-----> ". mysqli_error($conn);
    
    
}




?>