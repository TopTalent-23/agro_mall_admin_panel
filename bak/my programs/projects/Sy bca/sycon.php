<?php 
echo '<hr>';
//connecting mto the database
$servername = 'localhost';
$username = 'root';
$passwd = '';
$database = 'bhavesh';
//create a connection
$conn = mysqli_connect($servername, $username, $passwd, $database);

//if connection was not successfull
if (!$conn) {
    echo 'Sorry for your inconvinience ... site under construction';
}
else {
    
}
$sql = "SELECT * FROM `sy_bca_students`";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);

if ($num>0) {
     $sno = 0; 
  
 
  
  echo '<div class="">
  <table style="width:100%" class ="table" id ="myTable" m-auto>
  <thead>
   <tr>
   <th>Sr.no</th>
   <th>Name</th>
    <th>Roll no</th>
     <th>Email Id</th>
       <th>Phone no</th>
       <th>Address</th>
       <th>I sem sgpa</th>
        <th>II sem sgpa</th>
         <th>FY cgpa</th>
   </tr>   
  </thead>
  <tbody>'; 
  while($row = mysqli_fetch_assoc($result)){ 
  
  $sno +=1;
  echo '<tr>
    
    <td>'. $sno . '</td>
    <td>'. $row['Name'] . '</td>
    
   
   
    <td>'. $row['Roll_no'] . '</td>
    
    
    
    <td>'. '<a href="mailto:'.$row['Email_id'].'">'. $row['Email_id'] . '</td>
    
  
  
    <td>'. '<a href="tel:'.$row['Phone_no'].'">'. $row['Phone_no'] . '</td>
    
   
    <td>'. $row['Address'] . '</td>
    
   
    <td>'. $row['I_sem-sgpa'] . '</td>
 
    <td>'. $row['II_sem_sgpa'] . '</td>
   
    <td>'. $row['FY_cgpa'] . '</td>
  </tr>';
  }
  echo 
  ' </tbody>
</table> </div><br>';
}

else {
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
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Success</strong>  Your details are submitted succesfully...
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  <a class="btn btn-primary" href="sybca.php" role="button">Home</a>
</div>';
}
else {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Error</strong>  Sorry your details are not-submitted ...'. mysqli_error($conn) . '
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
} 

echo '<div class="container mt-4">
    <h2>Please Enter your details</h2> 
 
<form action="sybca.php" method="post">
<div class="column mt-4">
  <div class="column mt-4">
    <input type="text" class="form-control" placeholder="Your name here" name="name">
  </div>
  <div class="col mt-4">
    <input type="number" class="form-control" placeholder="Your roll no. here" name="roll_no">
  </div>
  <div class="col mt-4">
    <input type="email" class="form-control" placeholder="Your Email id here" name="email_id">
  </div>
  <div class="col mt-4">
    <input type="number" class="form-control" placeholder="Your Phone no here" name="phone_no">
  </div>
  <div class="col mt-4">
    <textarea name="address" class="form-control" placeholder="Your Address here" rows="8" cols="40"></textarea>
  </div>
  <div class="col mt-4">
    <input type="tex" class="form-control" placeholder="Your 1st sem sgpa here" name="i_sem_sgpa">
  </div>
  <div class="col mt-4">
    <input type="text" class="form-control" placeholder="Your 2nd sem sgpa here" name="ii_sem_sgpa">
  </div>
  <div class="col mt-4">
    <input type="text" class="form-control" placeholder="Your 1st year cgpa here" name="fy_cgpa">
  </div>
  <div class="container mt-4 mb-4">
  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
</div>
</div>
</form>
</div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

 
  </body>
</html>';

}
?>