<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>inserting value to the database</title>
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="#">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Link</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dropdown
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link disabled">Disabled</a>
        </li>
      </ul>
      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>
<?php
 if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$sid = $_POST['s_id'];
$sname = ($_POST['s_name']);
$saddress = ($_POST['s_address']);
$roll_no = $_POST['rollno'];

 
 $servername = 'localhost';
$username = 'root';
$passwd = '';
$database = 'bhavesh';

//create a connection
$conn = mysqli_connect($servername, $username, $passwd, $database);
$sql = "INSERT INTO `stu` (`sid`, `sname`, `saddress`, `rollno`) VALUES ('$sid', '$sname', '$saddress', '$roll_no')";
$result = mysqli_query($conn, $sql);
//if database connection not successfull
if ($result) {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Success</strong>  Your details are submitted succesfully...
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
else {
    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>Error</strong>  Sorry your details are not-submitted ...'. mysqli_error($conn) . '
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
}
 ?>
 <div class="container mt-4">
    <h2>Please Enter your details</h2> 
 
<form action="inserting.php" method="post">
<div class="column">
  <div class="column">
    <input type="text" class="form-control" placeholder="S_id" name="s_id">
  </div>
  <div class="col">
    <input type="text" class="form-control" placeholder="S_name" name="s_name">
  </div>
  <div class="col">
    <input type="text" class="form-control" placeholder="S_address" name="s_address">
  </div>
  <div class="col">
    <input type="text" class="form-control" placeholder="Roll no." name="rollno">
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</div>
</form>
</div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

 
  </body>
</html>