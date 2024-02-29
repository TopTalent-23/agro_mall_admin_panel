<?php
require 'header.php';
require_once 'dbConfig.php';
?>
        <!-- end header section -->
        <!-- slider section -->
        <section class="slider_section ">
             <div class="hero_bg_box">
            <img src="images/banner1.jpg" alt="">
        </div>
            <div id="customCarousel1" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-box">
                
                                        <h5>
                                            01
                                        </h5>
                                        <h1>
                                            product<br />
                                            no.1
                                        </h1>
                                        <a href="" class="">
                                            buy Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item ">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="detail-box">
                                        <h5>
                                            02
                                        </h5>
                                        <h1>
                                            prodct<br />
                                            no.2
                                        </h1>
                                        <a href="" class="">
                                            buy Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <ol class="carousel-indicators">
                    <li data-target="#customCarousel1" data-slide-to="0" class="active"></li>
                    <li data-target="#customCarousel1" data-slide-to="1"></li>
                </ol>
            </div>
        </section>
        <!-- end slider section -->
    </div>

    <!-- veg section -->

    <section class="veg_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    Our Products
                </h2>
                <p>
                    which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't an
                </p>
            </div>
            <div class="row">
                    <?php
            $show = "SELECT * FROM `products`";
            $result = mysqli_query($conn, $show);
            $num = mysqli_num_rows($result);
            if ($num > 0) {

                while ($row = mysqli_fetch_assoc($result)) {
                    echo '<div class="col-md-6 col-lg-4">
                    <div class="box">
                        <div class="img-box">';
                    ?>
                    <img src="data:products/jpg;charset=utf8;base64,<?php echo base64_encode($row['img1']); ?>" />
                    <?php
                    echo '</div>
                        <div class="detail-box">
                            <a href="">
                                Product
                            </a>
                            <div class="price_box">
                                <h6 class="price_heading">
                                    <span>Rs.</span> 100.00
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>';
                   }
                   }?>
            <div class="btn-box">
                <a href="">
                    View More
                </a>
            </div>
        </div>
    </section>

    <!-- end veg section -->

    <!-- about section -->

    <section class="about_section ">
        <div class="about_bg_box">
            <img src="images/banner2.jpg" alt="">
        </div>
        <div class="container ">
            <div class="row">
                <div class="col-md-6 ml-auto ">
                    <div class="detail-box">
                        <div class="heading_container">
                            <h2>
                                We Provide <br>
                                Agro Products
                            </h2>
                        </div>
                        <p>
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ad ex, sequi amet similique necessitatibus quas minus repudiandae quae culpa optio ipsum quibusdam praesentium saepe qui dolore voluptate iure sit aut.
                        </p>
                        <a href="" class="mt_20">
                            Read More
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- end about section -->

    <!-- contact section -->
    <section class="contact_section layout_padding">
        <div class="container">
            <div class="heading_container">
                <h2>
                    Contact <span>Us</span>
                </h2>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form_container contact-form">
                        <form action="">
                            <div>
                                <input type="text" placeholder="Your Name" />
                            </div>
                            <div>
                                <input type="text" placeholder="Phone Number" />
                            </div>
                            <div>
                                <input type="email" placeholder="Email" />
                            </div>
                            <div>
                                <input type="text" class="message-box" placeholder="Message" />
                            </div>
                            <div class="btn_box">
                                <button>
                                    SEND
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="map_container">
                        <div class="map">
                            <div id="googleMap"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end contact section -->

    <!-- client section -->

    <section class="client_section layout_padding-bottom">
        <div class="container">
            <div class="heading_container heading_center">
                <h2>
                    What Says Our Customers
                </h2>
            </div>
            <div class="col-md-9 col-lg-7 mx-auto px-0">
                <div class="box">
                    <div class="b-1">
                        <div class="client_id">
                            <div class="img-box">
                                <img src="images/user1.jpg" alt="">
                            </div>
                            <div class="name">
                                <h5>
                                    Ramakant Bhamre
                                </h5>
                                <h6>
                                    farmer
                                </h6>
                            </div>
                        </div>
                    </div>
                    <div class="client_detail">
                        <p>
                            It is a long established fact that a reader will be distracted by the readable content of a page when
                            looking at its layout. The point of using Lorem
                        </p>
                    </div>
                </div>
                <div class="box">
                    <div class="client_id">
                        <div class="img-box">
                            <img src="images/user2.jpg" alt="">
                        </div>
                        <div class="name">
                            <h5>
                                Chingya pansare
                            </h5>
                            <h6>
                                farmer
                            </h6>
                        </div>
                    </div>
                    <div class="client_detail">
                        <p>
                            It is a long established fact that a reader will be distracted by the readable content of a page when
                            looking at its layout. The point of using Lorem
                        </p>
                    </div>
                </div>
            </div>
            <div class="btn-box">
                <a href="">
                    View More
                </a>
            </div>
        </div>
    </section>

    <!-- end client section -->

    <!-- footer section -->
   <?php
   require 'footer.php';
   ?>