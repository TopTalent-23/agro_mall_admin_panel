<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
          <?php
    include 'navbar.php';
    ?>
    <?php
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$clients_name = $_POST['clients_name'];
$clients_email = $_POST['clients_email'];
$clients_phone = $_POST['clients_phone'];
$clients_pan = $_POST['clients_pan'];
$clients_aadhar = $_POST['clients_aadhar'];
$clients_photo = $_POST['clients_photo'];
$clients_address = $_POST['clients_address'];

include 'connection.php';
$sql = "INSERT INTO `clients` (`clients_id`, `clients_name`, `clients_email`, `clients_phone`, `clients_pan`, `clients_aadhar`,`clients_photo`, `clients_address`, `registering_date`) VALUES (NULL, '$clients_name', '$clients_email', '$clients_phone', '$clients_pan', '$clients_aadhar', '$clients_photo', '$clients_address', CURRENT_TIMESTAMP);";
$result = mysqli_query($conn, $sql);
//if database connection not successfull
if ($result) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success</strong>  Your details are submitted succesfully...
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  <a class="btn btn-primary" href="home.php" role="button">Home</a>
</div>';
}
else {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error</strong> ' . mysqli_error($conn) .'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
}
 ?>
  <div class="container mt-4">
    <h2>Please Enter your details</h2> 
 
<form action="new_client.php" method="post" enctype="multipart/form-data">
<div class="column mt-4">
  <div class="column mt-4">
      <h5>Client's Name</h5>
    <input type="text" class="form-control" placeholder="Client's name here" name="clients_name">
  </div>
  <div class="col mt-4">
  <div class="col mt-4">
      <h5>Email</h5>
    <input type="email" class="form-control" placeholder="Client's Email id here" name="clients_email">
  </div>
  <div class="col mt-4">
      <h5>Phone no.</h5>
    <input type="number" class="form-control" placeholder="Client's Phone no here" name="clients_phone">
  </div>
  <div class="col mt-4">
      <h5>Pan no.</h5>
    <input type="text" class="form-control" placeholder="Client's pan no. here" name="clients_pan">
  </div>
  <div class="col mt-4">
      <h5>Aadhar</h5>
    <input type="number" class="form-control" placeholder="Clients aadhar here" name="clients_aadhar">
  </div>
  
  <div class="col mt-4">
      <h5>Upload client's photo</h5>
      <label for="img">Select image:</label>
   <input type="file"  class="form-control" name="clients_photo" accept="image/*">
  </div>
  
  <div class="col mt-4">
      <h5>Address</h5>
      <textarea name="clients_address" class="form-control" placeholder="Client's Address here" rows="8" cols="40"></textarea>
    
  </div>
  
  <div class="container mt-4 mb-4">
  <button type="submit" class="btn btn-primary" name="submit">Submit</button>
</div>
</div>
</form>
</div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>