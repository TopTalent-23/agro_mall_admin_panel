<?php
require 'db_config.php';

$limit = 6; // Number of products to load per request

if (isset($_GET['offset'])) {
  $offset = $_GET['offset'];
 $sql = "SELECT *, GROUP_CONCAT(product_images.image_content) AS images
                FROM products
                JOIN product_images ON product_images.product_id =
                products.sr_no
                GROUP BY products.sr_no LIMIT $limit OFFSET $offset
                ";
  $result = mysqli_query($conn, $sql);
  $num = mysqli_num_rows($result);

  if ($num > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
                     
                    echo '<div class="col-sm-6 my-3">
                <div class="card m-auto shadow border" style="width: 18rem;">
                    <div class="card-body ">';
                    ?>
                    <div class="">
                        
                        <img src="data:products/jpg;charset=utf8;base64,<?php
                         echo base64_encode($row['image_content']); ?>" height="200" width="200"
                         class="card-img-top">
                        
                       
                    </div>
                    <?php
                     
                    echo '<h5 class="card-title mt-2 text-center text-uppercase fs-3 text-success fw-bold">'.$row['pr_name'].'</h5>
                    <p class="card-title mt-2 text-center"><s class="text-danger fs-5">Rs.'.$row['main_price'].'/-</s> <b class="text-success fs-3">    Rs. '.$row['discounted_price'].'/- </b></p>
                        <p class="card-text text-center">'.
                    substr($row['pr_desc'], 0, 90).'...
                        </p>
                        <a href="product_detail.php?category='.$row['cat_id'].'&&product='.$row['sr_no'].'" class="btn btn-success d-flex justify-content-center"><b>View Product</b></a>
                    </div>
                </div>
            </div>';
                }
  } else {
    echo '<p>No more products to load.</p>';
  }
}
?>
