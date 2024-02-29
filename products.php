<?php
ob_start();
include 'header.php';

// Check if the 'logedin' key is set and its value is true
if (!isset($_GET['search'])&&(!isset($_GET['category']) || $_GET['category']==null)) {
    // Redirect to the specified address
    header("Location: /index.php");
    exit(); // Ensure that code execution stops after redirection
}

require 'db_config.php';


// Fetch products for the current page
if (isset($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $sql = "SELECT *, GROUP_CONCAT(product_images.image_content) AS images
            FROM products
            JOIN product_images ON product_images.product_id = products.sr_no
            WHERE CONCAT(products.pr_manufacturer, ' ', products.pr_state, ' ', products.seed_type, ' ', products.sr_no, ' ', products.pr_name, ' ',products.pr_desc, ' ', products.discounted_price, ' ', products.wholesale_price, ' ') LIKE '%$search%'
            GROUP BY products.sr_no";
} else {
    $cat_id = isset($_GET['category']) ? $_GET['category'] : 0;
    $sql = "SELECT *, GROUP_CONCAT(product_images.image_content) AS images
            FROM products
            JOIN product_images ON product_images.product_id = products.sr_no
            WHERE products.cat_id = $cat_id
            GROUP BY products.sr_no";
}

$result = mysqli_query($conn, $sql);


// Check for query errors
if (!$result) {
    die('Error in query: ' . mysqli_error($conn));
}

?>
<section class="veg_section layout_paddingn mt-4">
    <div class="container">
        <div class="heading_container text-center mt-2">
            <?php
            if (isset($_GET['category'])) {
                $cat_id = $_GET['category'];
                $cat_sql = "SELECT * FROM `categories` WHERE `categories`.`cat_id` = $cat_id";
                $cat_result = mysqli_query($conn, $cat_sql);
                $cat_num = mysqli_num_rows($cat_result);
                if ($cat_num > 0) {
                    while ($row = mysqli_fetch_assoc($cat_result)) {
                        echo '<h2>
                                <hr>
                                ' . $row['cat_name'] . '
                            </h2>
                            <div class="card card-body text-left">
                                <span>' . substr($row['cat_desc'], 0, 90) . '
                                    <p class="collapse" id="collapseExample">' . substr($row['cat_desc'], 90) . '</p>
                                </span>
                                <a data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample"> More</a>
                            </div>';
                    }
                }
            }
            ?>
        </div>
        <div class="row">
            <?php
            $num = mysqli_num_rows($result);
            if ($num > 0) {?>
                <style>
                .card {
                  transition: transform 0.3s ease;
              }
            
              
                .card:hover {
                  /* Define your hover effect styles here */
                  /* For example, change background color */
                  transform: scale(1.1);
                  background-color: #f0f0f0;
              }
              @media (max-width: 768px) {
                    .card {
                        max-width: 100%; /* Adjust the max-width for smaller screens */
                        max-height: 200px; /* Adjust the max-height for smaller screens */
                        display: flex; /* Ensure horizontal layout on small screens */
                        flex-direction: row; /* Ensure horizontal layout on small screens */
                    }
                    .card .col-md-4 {
                        flex: 0 0 30%; /* Adjust width of the image column */
                        max-width: 30%; /* Adjust width of the image column */
                    }
                    .card .col-md-8 {
                        flex: 0 0 70%; /* Adjust width of the content column */
                        max-width: 70%; /* Adjust width of the content column */
                    }
                    .card img {
                        width: 100%; /* Make image fill the width on smaller screens */
                        height: auto; /* Maintain aspect ratio */
                    }
                    .card-body {
                        font-size: smaller; /* Adjust text size for smaller screens */
                    }
                }
            </style>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo '
                <div class="col-sm-4 my-3">
                <a href="product_detail.php?category=' . $row['cat_id'] . '&&product=' . $row['sr_no'] . '" style="text-decoration: none; color: black;">
                    <div class="card m-auto shadow border" style="max-width: 540px;">
                        <div class="row g-0">
                            <div class="col-md-4">
                                <img src="data:products/jpg;charset=utf8;base64,' . base64_encode($row['image_content']) . '" class="img-fluid rounded-start" alt="Product Image" style="height: 150px; width: 150px; ">
                            </div>
                            <div class="col-md-8">
                                <div class="card-body">
                                    <h5 class="card-title text-uppercase text-success fw-bold" style="font-size:20px;">' . $row['pr_name'] . '</h5>
                        <p class="card-title" style="margin-top:-5px;">
                            <s class="text-danger" style="font-size:18px;">Rs.' . $row['main_price'] . '/-</s> 
                            <b class="text-success "style="font-size:20px;">Rs. ' . $row['discounted_price'] . '/-</b>
                        </p>
                                    <p class="card-text">' . substr($row['pr_desc'], 0, 30) . '...</p>
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                    </a>
                </div>';
            }
            }else {
                echo '
<style>#no-products-found {
  height: 200px; /* Adjust the height as needed */
  /* Add custom styles for the "no products found" container */
}

#no-products-found .text-center {
  margin-top: 10px; /* Adjust the margin as needed */
  /* Add custom styles for the text center container */
}
</style>
<div id="no-products-found" >
  <div class="text-center">
    <img src="nodata.gif">
    <p>Not Available...</p>
  </div>
</div>
  ';
            }
            ?>
        </div>
    </div>
    
    <hr>
</div>
</section>

<?php
ob_end_flush();
require 'footer.php';

?>
