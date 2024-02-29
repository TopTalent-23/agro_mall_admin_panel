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
    <a class="navbar-brand" href="sybca.php">SY BBA(CA) student details</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/my programs/projects/Sy bcasybca.php">Home</a>
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
require 'addcon.php';
?>
 <div class="container mt-4">
    <h2>Please Enter your details</h2> 
 
<form action="addRecord.php" method="post">
<div class="column mt-4">
  <div class="column mt-4">
      <h5>Your Name</h5>
    <input type="text" class="form-control" placeholder="Your name here" name="name">
  </div>
  <div class="col mt-4">
      <h5>Roll no.</h5>
    <input type="number" class="form-control" placeholder="Your roll no. here" name="roll_no">
  </div>
  <div class="col mt-4">
      <h5>Email</h5>
    <input type="email" class="form-control" placeholder="Your Email id here" name="email_id">
  </div>
  <div class="col mt-4">
      <h5>Phone no.</h5>
    <input type="number" class="form-control" placeholder="Your Phone no here" name="phone_no">
  </div>
  <div class="col mt-4">
      <h5>Address</h5>
      <textarea name="address" class="form-control" placeholder="Your Address here" rows="8" cols="40"></textarea>
    
  </div>
  <div class="col mt-4">
      <h5>1st sem sgpa</h5>
    <input type="text" class="form-control" placeholder="Your 1st sem sgpa here" name="i_sem_sgpa">
  </div>
  <div class="col mt-4">
      <h5>2nd sem sgpa</h5>
    <input type="text" class="form-control" placeholder="Your 2nd sem sgpa here" name="ii_sem_sgpa">
  </div>
  <div class="col mt-4">
      <h5>Fy cgpa</h5>
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
</html>