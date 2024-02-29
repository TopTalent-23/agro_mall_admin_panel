<?php
require 'header.php';
require_once 'dbConfig.php';
?>

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

            <!-- footer section -->
            <?php
            require 'footer.php';
            ?>