<?php
include ("../db_config.php");

session_start();

if (isset($_SESSION['logedin']) && $_SESSION['logedin'] == true) {
    $logedin = true;
    echo "success";
} else {
    $logedin = false;

}
?>
<!DOCTYPE html>

<php lang="en">

    <head>
        <meta charset="utf-8">
        <title><?php if ($logedin == true) {
            echo $_SESSION['name'];
        } ?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">


        <!-- Favicon -->
        <link href="img/favicon.ico" rel="icon">

        <!-- Google Web Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&family=Pacifico&display=swap" rel="stylesheet">

        <!-- Icon Font Stylesheet -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!-- Libraries Stylesheet -->
        <link href="lib/animate/animate.min.css" rel="stylesheet">
        <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
        <link href="lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <!-- Customized Bootstrap Stylesheet -->
        <link href="css/bootstrap.min.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">
    </head>

    <body onload="getLocation()">
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get" id="form">
            <p id="demo">

                <script>
                    var x = document.getElementById("demo");
                    getCurrentPosition()
                    function getLocation() {
                        if (navigator.geolocation) {

                            navigator.geolocation.getCurrentPosition(showPosition);
                        } else {
                            x.innerHTML = "Geolocation is not supported by this browser.";
                        }
                    }

                    function showPosition(position) {
                        var lattitude = position.coords.latitude;
                        var longitude = position.coords.longitude;

                        x.innerHTML = "Latitude: " + lattitude +
                        "<br>Longitude: " + longitude;
                        console.log (lattitude);


                    }




                </script>
            </p>
        </form>



        <div class="container-xxl bg-white p-0">
            <!-- Spinner Start -->
            <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!-- Spinner End -->


            <!-- Navbar & Hero Start -->
            <div class="container-xxl position-relative p-0">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0">
                    <a href="" class="navbar-brand p-0">
                        <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i><?php if ($logedin == true) {
                            echo $_SESSION['name'];
                        } ?></h1>
                        <!-- <img src="img/logo.png" alt="Logo"> -->
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars"></span>
                    </button>
                    <div class="collapse navbar-collapse" id="navbarCollapse">
                        <div class="navbar-nav ms-auto py-0 pe-4">
                            <a href="index.php" class="nav-item nav-link active">Home</a>
                            <a href="about.php" class="nav-item nav-link">About</a>
                            <a href="service.php" class="nav-item nav-link">Service</a>
                            <a href="menu.php" class="nav-item nav-link">Menu</a>
                            <div class="nav-item dropdown">
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                                <div class="dropdown-menu m-0">
                                    <a href="booking.php" class="dropdown-item">Booking</a>
                                    <a href="team.php" class="dropdown-item">Our Team</a>
                                    <a href="testimonial.php" class="dropdown-item">Testimonial</a>
                                </div>
                            </div>
                            <a href="contact.php" class="nav-item nav-link">Contact</a>

                        </div>
                        <?php
                        if ($logedin) {
                            echo ' <a  data-bs-toggle="modal" data-bs-target="#logout" class="btn btn-primary py-2 px-4">Logout</a>';

                        }
                        ?>

                    </div>
                </nav>

                <!-- Button trigger modal -->

                <?php
                include "partials/logoutmodal.php";
                ?>