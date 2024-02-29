<?php
session_start();
if (isset($_GET['cust'])) {
    $customer_id = $_POST['cust'];
    $_SESSION['customer'] = $customer_id;
}
$cafe_id = $_GET['cafe'];
echo $cafe_id;

include ("db_config.php");
if ($_GET['cust']) {
$new_cust="INSERT INTO `daily_customers` (`cust_id`) VALUES (NULL)";
$result = mysqli_query($conn, $new_cust);
}


$cafe_id = $_GET['cafe'];
echo $cafe_id;

$show = "SELECT * FROM `caffe` WHERE `cafe_id`=$cafe_id";
$result = mysqli_query($conn, $show);
$num = mysqli_num_rows($result);
if ($num == 1) {
    $row = mysqli_fetch_assoc($result);
}
$mysql = "SELECT MAX(cust_id) AS maximum FROM daily_customers";
$result = mysqli_query($conn, $mysql);
$id = mysqli_fetch_assoc($result);
$cust_id = $id['maximum'];
echo $cust_id;







?>

<!DOCTYPE html>
<php lang="en">

    <head>
        <meta charset="utf-8">
        <title><?php echo $row['cafe_name']; ?></title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport">
        <meta content="" name="keywords">
        <meta content="" name="description">

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
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

        <!-- Template Stylesheet -->
        <link href="css/style.css" rel="stylesheet">


        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    </head>
    <body onload="startTimer()">



        <div class="container-xxl bg-white p-0">
            <!-- Spinner Start-->
            <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
                <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            <!--Spinner End


                        Navbar & Hero Start-->
            <div class="container-xxl position-relative p-0">
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark px-4 px-lg-5 py-3 py-lg-0 fixed-top">
                    <a href="" class="navbar-brand p-0">
                        <h1 class="text-primary m-0"><i class="fa fa-utensils me-3"></i><?php echo $row['cafe_name']; ?></h1>
                        <!-- <img src="img/logo.png" alt="Logo">-->
                    </a>
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                        <span class="fa fa-bars"></span>
                    </button>

                    <a class="btn btn-primary py-2 px-4">
                        <div class="container">
                            <div id="stopwatch">
                                00:00:00
                            </div>
                        </div>
                    </a>

                </nav>
            </div>


            <!-- Menu Start-->
            <div class="container-xxl py-5">
                <div class="container">
                    <div class="text-center wow fadeInUp" data-wow-delay="0.1s">
                        <h5 class="section-title ff-secondary text-center text-primary fw-normal">Food Menu</h5>
                        <h1 class="mb-5">Most Popular Items</h1>
                    </div>
                    <div class="tab-class text-center wow fadeInUp" data-wow-delay="0.1s">
                        <ul class="nav nav-pills d-inline-flex justify-content-center border-bottom mb-5">
                            <li class="nav-item">
                                <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3 active" data-bs-toggle="pill" href="#tab1">
                                    <i class="fa fa-coffee fa-2x text-primary"></i>
                                    <div class="ps-3">
                                        <small class="text-body">Popular</small>
                                        <h6 class="mt-n1 mb-0">Cofee</h6>
                                    </div>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="d-flex align-items-center text-start mx-3 ms-0 pb-3" data-bs-toggle="pill" href="#tab2">
                                    <i class="fa fa-food fa-2x text-primary"></i>
                                    <div class="ps-3">
                                        <small class="text-body">Popular</small>
                                        <h6 class="mt-n1 mb-0">Food</h6>
                                    </div>
                                </a>
                            </li>



                        </ul>
                        <div class="tab-content">
                            <div id="tab1" class="tab-pane fade show p-0 active">
                                <div class="row g-4">

                                    <?php
                                    $sql = "SELECT * FROM `menu` WHERE `cafe_id`=$cafe_id && `category`= 'coffee'";
                                    $result = mysqli_query($conn, $sql);
                                    $num = mysqli_num_rows($result);
                                    if ($num > 0) {

                                        while ($category = mysqli_fetch_assoc($result)) {
                                            echo '
                                    <div class="col-lg-6">
                                    <div class="d-flex align-items-center">
                                        <img class="flex-shrink-0 img-fluid rounded" src="img/menu-1.jpg" alt="" style="width: 80px;">
                                        <div class="w-100 d-flex flex-column text-start ps-4">
                                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                <span>'.$category['dish_name'].'</span>
                                                <span class="text-primary">Rs.'.$category['dish_prize'].'/-</span>
                                                <span><a class="btn btn-primary py-2 px-4" data-bs-toggle="modal" data-bs-target="#order">Order</a></span>
                                            </h5>
                                            <small class="fst-italic">'.$category['dish_desc'].'</small>
                                        </div>
                                    </div>
                                </div>';
                                ?>
                                <!--order modal-->
<div class="modal fade  modal-dialog-scrollable" id="order" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="staticBackdropLabel">Order Dish</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
<form class="mx-auto justify-content-center" id="form" name="form">

<div class="row">
<div class="col-lg-2 mb-3">
<lable class="mb-3">Quantity : </lable>
<div class="input-group">
<span class="input-group-btn">
<button type="button" class="quantity-left-minus btn btn-danger btn-number fa fa-minus" data-type="minus" data-field="">
<span class="glyphicon glyphicon-minus"></span>
</button>
</span>

<input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="1000" placeholder="Quantity" required>
<span class="input-group-btn">
<button type="button" class="quantity-right-plus btn btn-primary btn-number fa fa-plus" data-type="plus" data-field="">
<span class="glyphicon glyphicon-plus"></span>
</button>
</span>
</div>
 <input type="hidden" id="cafe_id" value="<?php echo $cafe_id;?>">
 <input type="hidden" id="dish_id" value="<?php echo $category['dish_id'];?>">
  
 <input type="hidden" id="dish_name" value="<?php echo $category['dish_name'];?>">
 <input type="hidden" id="cust_id" value="<?php echo $cust_id;?>">
 <input type="hidden" id="table_no" value="<?php echo $_GET['table_no'];?>">
</div>
</div>




</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<input type="button" id="place_order" class="btn btn-primary" data-bs-dismiss="modal" value="Order">

</div>
</form>
</div>
</div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
        var conn = new WebSocket('ws://localhost:8080');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };

       
        jQuery('#place_order').click(function() {
           
            var dish_id = jQuery('#dish_id').val();
            var dish_name = jQuery('#dish_name').val();
            var cust_id = jQuery('#cust_id').val();
            var table_no = jQuery('#table_no').val();
            var quantity = jQuery('#quantity').val();
            
            var content = {
               
                dish_id: dish_id,
                dish_name: dish_name,
                cust_id: cust_id,
                table_no: table_no,
                quantity: quantity
            };
            conn.send(JSON.stringify(content));
          
        
        });
    </script>



<script>
    $(document).ready(function() {
$("#place_order").click(function() {
var cafe_id = $("#cafe_id").val();
var dish_name = $("#dish_name").val();
var dish_id = $("#dish_id").val();
var cust_id = $("#cust_id").val();
var quantity = $("#quantity").val();
var table_no = $("#table_no").val();
alert("Thank you for Order.. pls wait for some time..");
// Returns successful data submission message when the entered information is stored in database.
$.post("post_order.php", {
cafe_id1: cafe_id,
dish_name1: dish_name,
dish_id1: dish_id,
cust_id1: cust_id,
quantity1: quantity,
table_no1: table_no
}, function(data) {


});

});
});
</script>
                                <?php

                                        }
                                    }
                                    ?>

                                </div>
                            </div>
                            <div id="tab2" class="tab-pane fade show p-0">
                                <div class="row g-4">
                                    <div class="col-lg-6">
                                        <div class="d-flex align-items-center">
                                            <img class="flex-shrink-0 img-fluid rounded" src="img/menu-1.jpg" alt="" style="width: 80px;">
                                            <div class="w-100 d-flex flex-column text-start ps-4">
                                                <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                    <span>Chicken Burger</span>
                                                    <span class="text-primary">$115</span>
                                                </h5>
                                                <small class="fst-italic">Ipsum ipsum clita erat amet dolor justo diam</small>
                                            </div>
                                        </div>
                                    </div>
                                 



                        </div>
                    </div>
                </div>
            </div>
            <!--Menu End
                        Footer Start-->
            <div class="container-fluid bg-dark text-light footer pt-5 mt-5 wow fadeIn" data-wow-delay="0.1s">
                <div class="container py-5">
                    <div class="row g-5">
                        <div class="col-lg-3 col-md-6">
                            <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Company</h4>
                            <a class="btn btn-link" href="">About Us</a>
                            <a class="btn btn-link" href="">Contact Us</a>
                            <a class="btn btn-link" href="">Reservation</a>
                            <a class="btn btn-link" href="">Privacy Policy</a>
                            <a class="btn btn-link" href="">Terms & Condition</a>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Contact</h4>
                            <p class="mb-2">
                                <i class="fa fa-map-marker-alt me-3"></i>123 Street, New York, USA
                            </p>
                            <p class="mb-2">
                                <i class="fa fa-phone-alt me-3"></i>+012 345 67890
                            </p>
                            <p class="mb-2">
                                <i class="fa fa-envelope me-3"></i>info@example.com
                            </p>
                            <div class="d-flex pt-2">
                                <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-twitter"></i></a>
                                <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-facebook-f"></i></a>
                                <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-youtube"></i></a>
                                <a class="btn btn-outline-light btn-social" href=""><i class="fab fa-linkedin-in"></i></a>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Opening</h4>
                            <h5 class="text-light fw-normal">Monday - Saturday</h5>
                            <p>
                                09AM - 09PM
                            </p>
                            <h5 class="text-light fw-normal">Sunday</h5>
                            <p>
                                10AM - 08PM
                            </p>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <h4 class="section-title ff-secondary text-start text-primary fw-normal mb-4">Newsletter</h4>
                            <p>
                                Dolor amet sit justo amet elitr clita ipsum elitr est.
                            </p>
                            <div class="position-relative mx-auto" style="max-width: 400px;">
                                <input class="form-control border-primary w-100 py-3 ps-4 pe-5" type="text" placeholder="Your email">
                                <button type="button" class="btn btn-primary py-2 position-absolute top-0 end-0 mt-2 me-2">SignUp</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="copyright">
                        <div class="row">
                            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                                &copy; <a class="border-bottom" href="#">Your Site Name</a>, All Right Reserved.

                                <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->
                                Designed By <a class="border-bottom">Global Cafe Management System</a><br><br>
                                Distributed By <a class="border-bottom" href="https://themewagon.com" target="_blank">Bhavesh Jadhav & Shubham Hire</a>
                            </div>
                            <div class="col-md-6 text-center text-md-end">
                                <div class="footer-menu">
                                    <a href="">Home</a>
                                    <a href="">Cookies</a>
                                    <a href="">Help</a>
                                    <a href="">FQAs</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Footer End
                       Back to Top
                      -->


            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
        </div>

        <!-- JavaScript Libraries -->

        <script src="js/jquery-3.5.1.min.js"></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="lib/wow/wow.min.js"></script>
        <script src="lib/easing/easing.min.js"></script>
        <script src="lib/waypoints/waypoints.min.js"></script>
        <script src="lib/counterup/counterup.min.js"></script>
        <script src="lib/owlcarousel/owl.carousel.min.js"></script>
        <script src="lib/tempusdominus/js/moment.min.js"></script>
        <script src="lib/tempusdominus/js/moment-timezone.min.js"></script>
        <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
        <!-- Template Javascript -->
        <script src="js/main.js"></script>
        <script>
            const timer = document.getElementById("stopwatch");
            var hr = 0;
            var min = 0;
            var sec = 0;
            var stoptime = true;

            function startTimer() {
                if (stoptime == true) {
                    stoptime = false;
                    timerCycle();
                }
            }


            function timerCycle() {
                if (stoptime == false) {
                    sec = parseInt(sec);
                    min = parseInt(min);
                    hr = parseInt(hr);

                    sec = sec + 1;

                    if (sec == 60) {
                        min = min + 1;
                        sec = 0;
                    }
                    if (min == 60) {
                        hr = hr + 1;
                        min = 0;
                        sec = 0;
                    }

                    if (sec < 10) {
                        sec = "0" + sec;
                    }
                    if (min < 10) {
                        min = "0" + min;
                    }
                    if (hr < 10) {
                        hr = "0" + hr;
                    }
                    var total_time = hr + ":" + min + ":" + sec;
                    time = total_time;
                    localStorage.setItem("time", JSON.stringify(time));
                    timer.innerHTML = time;
                    setTimeout("timerCycle()", 1000);
                }
            }
        </script>


        <?php

        if (!$_GET['table_no']) {

            echo '
<script>
	$(document).ready(function(){
		$("#myModal").modal("show");
	});
</script>

<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">What is your table No. ?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-footer">';

            $i = 0;




            while ($i < $row['no_of_tables']) {
                echo '
                <form method="post">
                <a href="order.php?table_no='.($i+1).'&&cafe='.$cafe_id.'&&cust='.($cust_id+1).'"type="submit" class="btn btn-primary py-2 px-4">'.($i+1).'</a>
                </form>';


                $i++;
            }
        }
        ?>




    </div>
</div>
</div>
</div>



</body>
<script>
$(document).ready(function() {

var quantitiy = 0;
$('.quantity-right-plus').click(function(e) {

// Stop acting like a button
e.preventDefault();
// Get the field name
var quantity = parseInt($('#quantity').val());

// If is not undefined

$('#quantity').val(quantity + 1);


// Increment

});

$('.quantity-left-minus').click(function(e) {
// Stop acting like a button
e.preventDefault();
// Get the field name
var quantity = parseInt($('#quantity').val());

// If is not undefined

// Increment
if (quantity > 0) {
$('#quantity').val(quantity - 1);
}
});

});
</script>
</html>