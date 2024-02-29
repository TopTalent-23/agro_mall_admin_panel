
<?php

$shopName = '';
$aboutHeading = '';
$address = '';
$phone = '';
$email = '';
$facebook = '';
$twitter = '';
$linkedin = '';
$instagram = '';

$sqlAbout = "SELECT * FROM about_us WHERE id = 1"; // Assuming the about_us table has a single row with id = 1
$resultAbout = mysqli_query($conn, $sqlAbout);

if (mysqli_num_rows($resultAbout) > 0) {
    $rowAbout = mysqli_fetch_assoc($resultAbout); // Fetch the row from the result set

    // Now you can access the values from the fetched row
    $shopName = $rowAbout['shop_name'];
    $aboutHeading = $rowAbout['about_heading'];
    $address = $rowAbout['address'];
    $phone = $rowAbout['phone1'];
    $email = $rowAbout['email'];
    $facebook = $rowAbout['facebook'];
    $twitter = $rowAbout['twitter'];
    $linkedin = $rowAbout['linkedin'];
    $instagram = $rowAbout['instagram'];
    
}
?>

<section class="  bg-dark text-light ">
    <div class="container">
        <div class="row ">
            <div class="col-sm-6 col-md-4 col-lg-3 footer-col mt-4">
                <div class="footer_detail">
                    <a href="index.html" class="text-light text-decoration-none">
                        <h3 class="text-success">
                            <b><?php echo $shopName;?></b>
                        </h3>
                    </a>
                    <p>
                    <?php echo $aboutHeading;?>
                    </p>
                    <div class="social_box p-0">
    <a href="<?php echo $facebook; ?>" class="text-light text-decoration-none m-1">
        <i class="fa fa-facebook" aria-hidden="true"></i>
    </a>
    <a href="<?php echo $twitter; ?>" class="text-light text-decoration-none m-2">
        <i class="fa fa-twitter" aria-hidden="true"></i>
    </a>
    <a href="<?php echo $linkedin; ?>" class="text-light text-decoration-none m-2">
        <i class="fa fa-linkedin" aria-hidden="true"></i>
    </a>
    <a href="<?php echo $instagram; ?>" class="text-light text-decoration-none m-2">
        <i class="fa fa-instagram" aria-hidden="true"></i>
    </a>
</div>

                </div>
                <style>
                    .social_box a:hover {
    color: #ffc107 !important;  /* Change the color on hover */
}
</style>
            </div>
            <div class="col-sm-6 col-md-4 col-lg-3 mx-auto footer-col mt-4">
    <h4>Contact us</h4>
    <p>Contact us for assistance with any inquiries or issues you may have.</p>
    <div class="contact_nav text-light">
        <i class="fa fa-solid fa-phone m-2"></i>
        <span>
            : <a class="contact-link text-success" href="tel:<?php echo $phone; ?>" style="text-decoration: none; color: white;"><?php echo $phone; ?></a>
        </span>
        <div>
            <i class="fa fa-solid fa-envelope m-2"></i>
            <span>
                : <a class="contact-link text-success" href="mailto:<?php echo $email; ?>" style="text-decoration: none; color: white;"><?php echo $email; ?></a>
            </span>
        </div>
    </div>
</div>

            <style>
  .contact-link:hover {
    color: #ffc107 !important; 
    text-decoration: none;
}
</style>
           <div class="col-md-4 footer-col mt-4">
    <div class="footer_form">
        <div class="nav-item dropdown">
            <span class="dropdown-item-header text-white"><h4>Select the Category</h4></span>
            <div class=" row text-white">
                <?php
                $show = "SELECT * FROM `categories`";
                $result = mysqli_query($conn, $show);
                $num = mysqli_num_rows($result);
                if ($num > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<div class="col-md-6 col-lg-4">
                                <a class="" style="text-decoration: none; color: white;" href="products.php?category=' . $row['cat_id'] . '">
                                    <span style="display: block;">&bull; ' . $row['cat_name'] . '</span>
                                </a>
                            </div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>


<style>
    .nav-item .text-white a:hover {
        color: #ffc107 !important; /* Change the color on hover */
    }
</style>



                </div>
            </div>
        </div>
        <hr>
        <div class="developer">
    <p class="text-center">Developed and Managed by<br> <b>Bhavesh Jadhav</b></p>
    <div class="social-links text-center">
    <div class="social_box p-0 m-2">
    <a  class="text-light text-decoration-none m-2">
        <i class="fa fa-facebook" aria-hidden="true"></i>
    </a>
    <a  class="text-light text-decoration-none m-2">
        <i class="fa fa-twitter" aria-hidden="true"></i>
    </a>
    <a href="https://www.linkedin.com/in/bhavesh-jadhav-82b956280?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=android_app" class="text-light text-decoration-none m-2">
        <i class="fa fa-linkedin" aria-hidden="true"></i>
    </a>
    <a href="https://www.instagram.com/sonar_bhavesh_/" class="text-light text-decoration-none m-2">
        <i class="fa fa-instagram" aria-hidden="true"></i>
    </a>
</div>
    </div>
    <p class="text-center">Contact: <a class="contact-link" href="mailto:bhavesh002jadhav@gmail.com" style="text-decoration: none; color: green;">bhavesh002jadhav@gmail.com</a> | Phone: <a class="contact-link" href="tel: +919067872194" style="text-decoration: none; color: green;">+919067872194</a></p>
</div>
        <div class="footer-info text-center my-1 ">
            <p class="">
                &copy; <span id="displayYear"></span><?php echo date('Y'); ?> | All Rights Reserved By
                <a href="/aahire_agro_mall_2.0" class="text-success text-decoration-none"><b>Agro Mall pvt ltd.</b></a>
            </p>
        </div>
    </div>
</section>



<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
</script>
<!--js files-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

<!-- Option 2: Separate Popper and Bootstrap JS -->
<!--
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
            -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
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



$(function() {
    $('.email, .phone').hide(); // hide div1 and div2 on page load

    $('[name=btnradio]').on('change', function() { // bind an onchange function to the inputs
        if ($('[name=btnradio]:checked').val() == 'btnradio1') { // get the value that is checked
            $('.email').show(); // show div1
            $('.phone, .default').hide(); // hide other divs
        } else {
            $('.phone').show(); // show div2
            $('.email, .default').hide(); // hide other divs
        }
    });
});
</script>

</body>

</html>