<?php
require 'header.php';
require_once 'dbConfig.php';


?>


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
                                '.($row['pr_name']).'
                            </a>
                            <div class="price_box">
                            <span>Rs. '.($row['price']).'/-</span>
                                <h3 class="price_heading">
                                    <div class="btn-box">
                        <a href="edit_product.php?sr_no='.($row['sr_no']).'">
                            Edit
                        </a>
                        <a href="">
                            Delete
                        </a>
                    </div>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>';
                }
            } ?>
            <div class="btn-box">
                <a href="">
                    View More
                </a>
            </div>
        </div>
    </section>


    <?php

    require 'footer.php';
    ?>