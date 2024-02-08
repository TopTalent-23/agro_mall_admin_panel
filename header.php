<?php
 session_start();
require'db_config.php';
if (isset($_SESSION['logedin']) && $_SESSION['logedin'] == true) {
    $logedin=true;

}
else {
    $logedin=false;
   
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
    <!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-vzQWpNu6BFZYiwDKB3hNlFeqvei21bBBQaG+D5+gD4XYbmiiqGXW8eIR9c1hUzIcvoXQeB7Z2oPkm5o17pMqQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">-->
    <link href="css/style.css" rel="stylesheet" />
    
   <!-- this is for razorpay -->

<!-- end razorpay links -->

    <title>Agro Mall</title>
    
    <style>
      #loading-indicator {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(255, 255, 255, 0.8);
  z-index: 9999;
  display: flex;
  justify-content: center;
  align-items: center;
}

.spinner {
  border: 4px solid #f3f3f3;
  border-top: 4px solid green;
  border-radius: 50%;
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

    </style>
    <script>
      window.onload = function() {
  // Show the loading indicator
  document.getElementById('loading-indicator').style.display = 'block';
};

window.addEventListener('load', function() {
  // Hide the loading indicator
  document.getElementById('loading-indicator').style.display = 'none';
});

    </script>
</head>
<body class="m-auto">
  <div id="loading-indicator">
  <div class="spinner"></div>
</div>

    <nav class="navbar  navbar-expand-lg navbar-dark bg-dark">

        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <img src="logo.png" alt="" width="55" height="40">  <b>Agro Mall</b>
            </a>


            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                    <li class="nav-item">


                        <a class="nav-link " aria-current="page" href="index.php">Home</a>
                    </li>
                  
                      <?php
                      if ($logedin) {
  echo '<li><a class="nav-link "  href="profile.php">My Profile</a></li>';
  echo '<li><a class="nav-link "  href="my_order.php">My Orders</a></li>';
}
                      ?>
                   
                    <?php
                    $currentURL = $_SERVER['REQUEST_URI'];


                 if ($currentURL == "/Aahire_Agro_Mall_2.0/" || $currentURL == "/Aahire_Agro_Mall_2.0/index.php") {
                        echo '  <li class="nav-item">
          <a class="nav-link" href="#About">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#Contact">Contact Us</a>
        </li>';
                    } else {
                        echo ' <li class="nav-item">
          <a class="nav-link" href="about.php">About Us</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact Us</a>
        </li> ';
                    }
                    ?>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle " href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Categories
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                            <?php

                            $show = "SELECT * FROM `categories`";
                            $result = mysqli_query($conn, $show);
                            $num = mysqli_num_rows($result);
                            if ($num > 0) {

                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo '<li><a class="dropdown-item " href="products.php?category='.($row['cat_id']).'">'.$row['cat_name'].'</a></li>';
                                }
                            }
                            ?>



                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link disabled">Link</a>
                    </li>
                </ul>
                <form class="d-flex">
                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" href="#" type="submit">Search</button>
                </form>

 <div class="mt-2">
<?php
if ($logedin) {
  echo ' <button type="button" data-bs-toggle="modal" data-bs-target="#logout" class="btn btn-outline-success">Logout</button>';
}
elseif (!$logedin) {
   echo ' <button type="button" data-bs-toggle="modal" data-bs-target="#login" class="btn btn-outline-success">Login</button>
                    <button type="button" data-bs-toggle="modal" data-bs-target="#signup" class="btn btn-outline-success">Signup</button>';
}
?>
    </div>
               

            </div>
        </div>
    </nav>
<?php

//if ($_GET['signup']==true) {
// echo '<div class="alert alert-danger alert-dismissible fade show my-0" role="alert">
//  <strong>Error : </strong> Email or phone already exists...
//  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//</div>';
//
//}
//elseif ($_GET['signup']==false) {
// echo '<div class="alert alert-success alert-dismissible fade show my-0" role="alert">
//  <strong>Success : </strong> Account created successfully please <button type="button" data-bs-toggle="modal" //data-bs-target="#login" class="btn btn-outline-success my-0">Login</button>
//  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//</div>';
//}

?>
 
    <?php
    
    include 'partials/logoutmodal.php';
    include 'partials/loginmodal.php';
    include 'partials/loginmodal.php';
    ?>

    <!-- signup Modal -->