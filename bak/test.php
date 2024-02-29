<?php
require 'header.php';
require 'db_config.php';

// Check if the category ID is provided in the URL parameter
if (isset($_GET['category'])) {
    $categoryID = $_GET['category'];

    // Get the category name from the database based on the category ID
    $categoryQuery = "SELECT * FROM `categories` WHERE `cat_id` = '$categoryID'";
    $categoryResult = mysqli_query($conn, $categoryQuery);
    $categoryRow = mysqli_fetch_assoc($categoryResult);
    $categoryName = $categoryRow['cat_name'];

    // Get the products for the selected category from the database
    $productsQuery = "SELECT * FROM `products` WHERE `cat_id` = '$categoryID'";
    $productsResult = mysqli_query($conn, $productsQuery);
?>

<section class="veg_section layout_paddingn mt-4">
    <div class="container">
        <div class="heading_container text-center mt-2">
            <h2>
                <hr>
                <?php echo $categoryName; ?> Products
            </h2>
        </div>
        <div class="row">
            <?php
            if (mysqli_num_rows($productsResult) > 0) {
                while ($productRow = mysqli_fetch_assoc($productsResult)) {
                    echo '<div class="col-sm-6 my-3">
                        <div class="card m-auto shadow border" style="width: 18rem;">
                            <div class="card-body">
                                <img src="data:products/jpg;charset=utf8;base64,'.base64_encode($productRow['img1']).'" height="200" width="200" class="card-img-top"/>
                                <h5 class="card-title mt-2 text-center">'.$productRow['pr_name'].'</h5>
                                <p class="card-text text-center">'.$productRow['pr_desc'].'</p>
                                <a href="#" class="btn btn-success d-flex justify-content-center">Add to Cart</a>
                            </div>
                        </div>
                    </div>';
                }
            } else {
                echo '<div class="col-12 text-center">No products found for this category.</div>';
            }
            ?>
        </div>
    </div>
</section>

<?php
    } else {
        echo '<div class="container text-center">Invalid category ID.</div>';
    }

    require 'footer.php';
?>
