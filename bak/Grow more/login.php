<?php
$logedin=false;
$error=false;
$not_matched=false;
if ($_SERVER['REQUEST_METHOD']=='POST') {
include 'connection.php';
$username=$_POST['Username'];
$password=$_POST['Password'];
$cpassword=$_POST['cPassword'];
$sql="SELECT * FROM `admin` where username = '$username' AND password = '$password'";
$result=mysqli_query($conn, $sql);
$num=mysqli_num_rows($result);
if ($num==1 && $password==$cpassword) {

$logedin=true;
session_start();
$_SESSION['logedin']=true;
$_SESSION['username']=$username;
header("location: home.php");
} elseif ($password !=$cpassword) {

$not_matched=true;
} else {

$error=true;


}
}
?>
<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Login Grow More</title>
</head>
<body>
    <?php
    include 'navbar.php';

    if ($logedin) {
    echo '<div class="alert alert-Success alert-dismissible fade show" role="alert">
    <strong>Success!</strong> You are loged in
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }

    if ($error) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error!</strong> Invalid credentils...
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    }
    ?>

    <div class=" m-auto mt-4 container">
        <h2 class="m-auto text-center container">Log in</h2>

    </div>
    <form class="m-5 container" action="login.php" method="post">
        <div class="row mb-3">
            <label for="Username" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="Username" name="Username">
            </div>
        </div>
        <div class="row mb-3">
            <label for="Password" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="Password" name="Password">
            </div>
        </div>
        <div class="row mb-3">
            <label for="cPassword" class="col-sm-2 col-form-label">Confirm Password</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" id="cPassword" name="cPassword">
                <small></small>
                <?php
                if ($not_matched) {
                echo '<div> <small style="color:red;">Password not matched</small></div>';
                }
                ?>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Sign in</button>
    </form>

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