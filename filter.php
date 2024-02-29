<?php
require 'db_config.php';

$category = $_GET['category'];

if (!empty($category)) {
   $sql = "SELECT *, GROUP_CONCAT(product_images.image_content) AS images
                FROM products
                JOIN product_images ON product_images.product_id =
                products.sr_no
                WHERE `products`.`cat_id` = $category
                GROUP BY products.sr_no 
                ";
  
} else {
  $sql ="SELECT *, GROUP_CONCAT(product_images.image_content) AS images
                FROM products
                JOIN product_images ON product_images.product_id =
                products.sr_no
                
                GROUP BY products.sr_no 
                ";
}

$result = mysqli_query($conn, $sql);
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
            }
            else {
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
