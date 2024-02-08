<?php
require 'header.php';
  
  
$pr_id = $_GET['product'];
$cat_id = $_GET['category'];

  $sql = "SELECT *, GROUP_CONCAT(product_images.image_content) AS images
                FROM products
                JOIN product_images ON product_images.product_id =
                products.sr_no
                WHERE `products`.`sr_no` = $pr_id
                GROUP BY products.sr_no 
                ";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
if ($num > 0) {

  while ($row = mysqli_fetch_assoc($result)) {
    
    echo '<h1 class="card-title mt-2 text-center text-uppercase fs-1 text-success fw-bold">'.$row['pr_name'].'</h1>';

    ?>
    
    <div class="row">

      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
      <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
       
  <div class="carousel-inner">
    <?php
    $sql1 = "SELECT * FROM product_images WHERE product_id = $pr_id";
    $res1 = mysqli_query($conn, $sql1);

    $firstImage = true; // To set the first image as active

    if (mysqli_num_rows($res1)) {
      while ($row1 = mysqli_fetch_array($res1)) {
        $imageContent = base64_encode($row1['image_content']);
        $carouselClass = $firstImage ? 'carousel-item active' : 'carousel-item';
    ?>
  
        <div class="<?php echo $carouselClass; ?>">
          <div class="image-container">
            <div class="image-wrapper text-center">
              <img src="data:products/jpg;charset=utf8;base64,<?php echo $imageContent; ?>" alt="...">
            </div>
          </div>
        </div>
    <?php
        $firstImage = false; // Set to false for subsequent images
      }
    }
    ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

<style>
.carousel-inner {
  text-align: center;
}

.image-container {
  width: 300px; /* Set the desired fixed width */
  height: 400px; /* Set the desired fixed height */
  display: inline-block;
}

.image-wrapper img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}
</style>

          
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card">
          <div class="card-body">
            <?php

            echo '
                    <h class="card-title mt-6 text-uppercase fs-3 text-success fw-bold">'.$row['pr_name'].' <p class= "fs-5 fw-light">( '.$row['pr_manufacturer'].' )</p></h>
                    <p class="card-title mt-6 "><s class="text-danger fs-5">Rs.'.$row['main_price'].'/-</s> <b class="text-success fs-4">    Rs. '.$row['discounted_price'].'/- </b></p>
                    <hr>
                      <h class="card-title mt-3 text-uppercase fs-5 ">Details :</h>
            ';
            switch ($cat_id) {
              case 1:
                echo '
                    <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Seed type :</div>
    <div class="col-4 text-success">'. $row['seed_type'].'</div>
  </div>
  <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Net. wt :</div>
    <div class="col-4 text-success">'. $row['net_wt'].' kg.</div>
  </div>
           ';
                break;

              case 2:
                echo '     <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">size :</div>
    <div class="col-6 text-success">'. $row['width'].' x '.$row['breadth'].' metre</div>
  </div>';
                break;
              case 3:
                echo '     <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Form :</div>
    <div class="col-4 text-success">'. $row['pr_state'].'</div>
  </div>
   <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Net. wt :</div>
    <div class="col-4 text-success">'. $row['net_wt'].' ml.</div>
  </div>
  ';
                break;
              case 4:
                echo '     <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Form :</div>
    <div class="col-4 text-success">'. $row['pr_state'].'</div>
  </div>
   <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Net. wt :</div>
    <div class="col-4 text-success">'. $row['net_wt'].' kg.</div>
  </div>
  ';
                break;
              case 5:
                echo '     <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Form :</div>
    <div class="col-4 text-success">'. $row['pr_state'].'</div>
  </div>
   <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Net. wt :</div>
    <div class="col-4 text-success">'. $row['net_wt'].' kg.</div>
  </div>
  ';
                break;
              case 6:
                echo '     <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Form :</div>
    <div class="col-4 text-success">'. $row['pr_state'].'</div>
  </div>
   <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Net. wt :</div>
    <div class="col-4 text-success">'. $row['net_wt'].' kg.</div>
  </div>
  ';
                break;
              case 7:
                echo '     <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Form :</div>
    <div class="col-4 text-success">'. $row['pr_state'].'</div>
  </div>
   <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Net. wt :</div>
    <div class="col-4 text-success">'. $row['net_wt'].' kg.</div>
  </div>
  ';
                break;
              case 8:
                echo '     <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Form :</div>
    <div class="col-4 text-success">'. $row['pr_state'].'</div>
  </div>
   <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Net. wt :</div>
    <div class="col-4 text-success">'. $row['net_wt'].' kg.</div>
  </div>
  ';
                break;
              case 9:
                echo '     <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Form :</div>
    <div class="col-4 text-success">'. $row['pr_state'].'</div>
  </div>
   <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Net. wt :</div>
    <div class="col-4 text-success">'. $row['net_wt'].' kg.</div>
  </div>
  ';
                break;
              case 10:
                echo '     <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Form :</div>
    <div class="col-4 text-success">'. $row['pr_state'].'</div>
  </div>
   <div class="row text-uppercase fs-6 fw-normal mt-2">
    <div class="col-6">Net. wt :</div>
    <div class="col-4 text-success">'. $row['net_wt'].' kg.</div>
  </div>
  ';
                break;
            }

            echo '
            <div class="row text-uppercase  fw-normal mt-2">
             <div class="col-6 fs-6">Average Rating :</div>
             <div class="col-4 text-success fs-6 fw-bold" id="averageRating">0.0</div>
             </div>
        <!-- Display rating stars (using font-awesome icons) -->
        <div class="row text-uppercase  fw-normal mt-2">
             <div class="col-1 fs-6"></div>
             <div class="col-9 rating-stars  fs-6 " id="averageRatingStars"> </div>
             </div>
        
             <div class = "mt-2">
              <h class="card-title text-uppercase fs-5 ">Discription :</h>
            <p class="lead">
 '.$row['pr_desc'].'
</p> </div>';
   if (isset($_GET['shopVisit'])) {
  echo '<a class="btn btn-success d-flex mt-2 justify-content-center" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><b>Buy Now</b></a>';
}
elseif (!$logedin) {
              echo '<a class="btn btn-success d-flex mt-2 justify-content-center" data-bs-toggle="modal" data-bs-target="#login"><b>Buy Now</b></a>';
            } 
            else {
              echo '<a class="btn btn-success d-flex mt-2 justify-content-center" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><b>Buy Now</b></a>';
            }
            
               
           
           ?>
            <!-- Button trigger modal -->

 <?php
 if(isset($_SESSION['id'])){
 $usr= $_SESSION['id'];
   $sql1 = "SELECT * FROM `customers` WHERE `sr_no` = '$usr'";
$result1 = mysqli_query($conn, $sql1);
$num1 = mysqli_num_rows($result1);
if ($num1 > 0) {

  while ($row1 = mysqli_fetch_assoc($result1)) { 
    
    $name= $row1['cust_name'];
    $phone= $row1['cust_phone'];
    $email= $row1['cust_email'];
    $pincode= $row1['cust_pincode'];
    $address= $row1['cust_address'];
  }
}
 }
?>

<div class="modal fade  modal-dialog-scrollable" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="mx-auto justify-content-center" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Buy Now</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
    <div class="mb-3">
        <input type="text" class="form-control" id="name" name="name" 
        <?php 
        if (!isset($_GET['shopVisit'])) {
          echo 'value="'.$name.'"';
        }elseif ($logedin) {
          echo 'value="'.$name.'"';
        }
        else {
          echo 'placeholder="Enter Name:"';
        }?>>
    </div>

    <div class="mb-3">
        <input type="number" class="form-control" id="pno" name="phone"
        <?php 
        if (!isset($_GET['shopVisit'])) {
          echo 'value="'.$phone.'"';
        }elseif ($logedin) {
          echo 'value="'.$phone.'"';
        }
        else {
          echo 'placeholder="Enter Phone:"';
        }?> >
    </div>

    <div class="mb-3">
        <input type="email" class="form-control" id="email" name="email"
        <?php 
        if (!isset($_GET['shopVisit'])) {
          echo 'value="'.$email.'"';
        }elseif ($logedin) {
          echo 'value="'.$email.'"';
        }
        else {
          echo 'placeholder="Enter Email:"';
        }?>>
    </div>

    <div class="row">
    <div class="">
        <label class="mb-3">Quantity : </label>
        <div class="input-group">
            <div class="input-group-prepend">
                <button type="button" class="quantity-left-minus btn btn-danger btn-number fa fa-minus" data-type="minus" data-field="">
                    <span class="glyphicon glyphicon-minus"></span>
                </button>
            </div>

            <input type="text" id="quantity" name="quantity" class="form-control input-number"  min="1" max="1000" placeholder="Quantity" value='1'>

            <div class="input-group-append">
                <button type="button" class="quantity-right-plus btn btn-success btn-number fa fa-plus" data-type="plus" data-field="">
                    <span class="glyphicon glyphicon-plus"></span>
                </button>
            </div>
        </div>
    </div>
</div>



    <div class="mb-3">
      Address:
        <textarea class="form-control" id="addr" rows="3" placeholder="Address"> <?php 
        if (!isset($_GET['shopVisit'])) {
          echo $address;
        }elseif ($logedin) {
          echo 'value="'.$address.'"';
        }
        else {
         
        }?></textarea>
    </div>

    <div class="mb-3">
        <input type="text" class="form-control" id="pin" placeholder="Pincode"  <?php 
        if (!isset($_GET['shopVisit'])) {
          echo 'value="'.$pincode.'"';
        }elseif ($logedin) {
          echo 'value="'.$pincode.'"';
        }
        else {
          echo 'placeholder="Enter pincode:"';
        }?>>
        <input type="text" class="form-control" hidden id="pr_id" placeholder="Pincode" value="<?php echo $pr_id; ?>">
        <input type="text" class="form-control" hidden id="amt" placeholder="Pincode" value="<?php echo $row['discounted_price']; ?>">
        <input type="text" class="form-control" hidden id="usr" placeholder="Pincode"  <?php 
        if (!isset($_GET['shopVisit'])) {
          echo 'value="'.$usr.'"';
        }elseif ($logedin) {
          echo 'value="'.$usr.'"';
        }
        else {
          echo 'placeholder="Enter Email:"';
        }?>>

         <?php 
        if (isset($_GET['shopVisit']) && $_GET['shopVisit']== 1 ) {
          echo '<input type="text" class="form-control" hidden id="shopVisit" placeholder="Pincode" value="ShopVisit">';
        }?>
    </div>



<?php
}
        } 
           ?>

                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    
                     <input type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#payNow"  value="Pay Now" />
                     <input type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cod" value="Cash On Delivery"/>
                  
                 
                  
                  
                    </div>
                  
                </div>
                
                </form>
                
              </div>
              <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>


<script>
    function pay_now() {
  var name = jQuery('#name').val();
  var amt = jQuery('#amt').val();
  var pno = jQuery('#pno').val();
  var email = jQuery('#email').val();
  var quantity = jQuery('#quantity').val();
  var addr = jQuery('#addr').val();
  var pin = jQuery('#pin').val();
  var usr = jQuery('#usr').val();
  var pr_id = jQuery('#pr_id').val();
  var amt = amt * quantity;
  <?php
  if (isset($_GET['shopVisit']) && $_GET['shopVisit']== 1 ) {?>
  var shopVisit = jQuery('#shopVisit').val();
  <?php }?>
  var options = {
    key: "rzp_test_XkyAfIibqTU8Oz",
    amount: amt * 100,
    currency: 'INR',
    name: 'Acme Corp',
    description: 'Test Transaction',
    image: 'https://image.freepik.com/free-vector/logo-sample-text_355-558.jpg',
    handler: function (response) {
      jQuery.ajax({
        type: 'post',
        url: 'buy_server.php',
        data: {
          payment_id: response.razorpay_payment_id,
          amt: amt,
          name: name,
          pno: pno,
          email: email,
          quantity: quantity,
          addr: addr,
          pin: pin,
          pr_id: pr_id,
          usr: usr,
          <?php
  if (isset($_GET['shopVisit']) && $_GET['shopVisit']== 1 ) {?>
  shopVisit: shopVisit
  <?php }?>
        },
        success: function (result) {
          <?php
  if (isset($_GET['shopVisit']) && $_GET['shopVisit']== 1 ) {?>
  window.location.href='admin_pannel/admin_dashboard.php';
  <?php }else{?>
          window.location.href = 'my_order.php';
       <?php }?> }
      });
    }
  };

  var rzp1 = new Razorpay(options);
  rzp1.open();
}

 function processCashOnDelivery() {
  // Retrieve form data
  var name = document.getElementById('name').value;
  var phone = document.getElementById('pno').value;
  var email = document.getElementById('email').value;
  var quantity = document.getElementById('quantity').value;
  var address = document.getElementById('addr').value;
  var pincode = document.getElementById('pin').value;
  var pr_id = document.getElementById('pr_id').value;
  var amt = document.getElementById('amt').value;
  var usr = document.getElementById('usr').value;
  <?php
  if (isset($_GET['shopVisit']) && $_GET['shopVisit']== 1 ) {?>
  var shopVisit = document.getElementById('shopVisit').value;
  <?php }?>
  // Validate form inputs (perform any necessary validation)

  // Create a new form object
  var form = document.createElement('form');
  form.action = 'cod_process.php'; // Set the PHP file to handle the cash on delivery order processing
  form.method = 'post';

  // Create input fields and append to the form
  var nameInput = document.createElement('input');
  nameInput.type = 'text';
  nameInput.name = 'name';
  nameInput.value = name;
  form.appendChild(nameInput);

  var phoneInput = document.createElement('input');
  phoneInput.type = 'number';
  phoneInput.name = 'phone';
  phoneInput.value = phone;
  form.appendChild(phoneInput);

  var emailInput = document.createElement('input');
  emailInput.type = 'email';
  emailInput.name = 'email';
  emailInput.value = email;
  form.appendChild(emailInput);

  var quantityInput = document.createElement('input');
  quantityInput.type = 'number';
  quantityInput.name = 'quantity';
  quantityInput.value = quantity;
  form.appendChild(quantityInput);

  var addressInput = document.createElement('input');
  addressInput.type = 'text';
  addressInput.name = 'address';
  addressInput.value = address;
  form.appendChild(addressInput);

  var pincodeInput = document.createElement('input');
  pincodeInput.type = 'text';
  pincodeInput.name = 'pincode';
  pincodeInput.value = pincode;
  form.appendChild(pincodeInput);

  var prIdInput = document.createElement('input');
  prIdInput.type = 'text';
  prIdInput.name = 'pr_id';
  prIdInput.value = pr_id;
  form.appendChild(prIdInput);

  var amtInput = document.createElement('input');
  amtInput.type = 'text';
  amtInput.name = 'amt';
  amtInput.value = amt;
  form.appendChild(amtInput);

  var usrInput = document.createElement('input');
  usrInput.type = 'text';
  usrInput.name = 'usr';
  usrInput.value = usr;
  form.appendChild(usrInput);

  <?php
  if (isset($_GET['shopVisit']) && $_GET['shopVisit']== 1 ) {?>
  var shopVisitInput = document.createElement('input');
  shopVisitInput.type = 'text';
  shopVisitInput.name = 'shopVisit';
  shopVisitInput.value = shopVisit;
  form.appendChild(shopVisitInput);
  <?php }?>
  // Submit the form
  document.body.appendChild(form);
  form.submit();
}

</script>
            </div>
    
         
      </div>
    </div>
  </div>
</div>
</div>
</div>
</div>

<!-- rating and reiew -->
<!-- Existing code... -->
<!-- Product information section -->
<!-- Existing code... -->
 <!-- Rating and Review Section -->
<!-- Rating and Review Section -->
<style>
      /* Custom CSS for font-awesome stars */
.average-rating {
  font-size: 5px; /* Adjust the font size to your preference */
  color: #FFD700; /* Color for filled stars (yellow in this example) */
}

.average-rating .fa-star-o {
  color: #ccc; /* Color for empty stars (light gray in this example) */
}
    </style>
<div class="container mt-3">
  
  <div class="row justify-content-center">
    <div class="col-md-8">
      <div class="border p-4 rounded">
        <!-- Display average rating -->
       
        
        <!-- Display all reviews -->
        <h4>Customer Reviews:</h4>
        <hr>
        <div class="mt-3" id="reviewsContainer">
          <!-- Reviews will be populated dynamically with JavaScript -->
          <!-- Add the loader/spinner HTML inside the "reviewsContainer" div -->

  <!-- Loader -->
  <div id="loader" style="display: none;">
    <div id="loading-indicator" class="text-center mt-3">
      <div class="spinner-border text-success" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>

        </div>
        
        <!-- "View More Reviews" button -->
        <div id="viewMoreButtonContainer" class="text-center mt-3">
  <div class="row justify-content-between">
    <div class="col-auto">
      <button id="prev" class="btn btn-outline-success btn-sm" style="display: none">Prev</button>
    </div>
    
    <div class="col-auto">
      <button id="next" class="btn btn-outline-success btn-sm">Next</button>
    </div>
  </div>
</div>
        
        <hr>
        <!-- Review Form -->
        <h4>Write a Review:</h4>
        <div id="successMessage" style="display: none;" class="alert alert-success">Review submitted successfully!</div>
        <form action="submit_review.php" method="post" id="reviewForm">
          <div class="form-group">
            <label for="rating">Your Rating:</label>
            <div class="rating-stars" id="userRatingStars">
              <!-- Stars will be populated dynamically with JavaScript -->
              <i class="fa fa-star-o user-rating-star" data-rating="1"></i>
              <i class="fa fa-star-o user-rating-star" data-rating="2"></i>
              <i class="fa fa-star-o user-rating-star" data-rating="3"></i>
              <i class="fa fa-star-o user-rating-star" data-rating="4"></i>
              <i class="fa fa-star-o user-rating-star" data-rating="5"></i>
            </div>
            <input type="hidden" name="user_rating" id="userRating" value="0">
          </div>
          
          <?php
          if (!$logedin) {
            echo '<a class="btn btn-success mt-2 justify-content-center" data-bs-toggle="modal" data-bs-target="#login"><b>Login to Review</b></a>';
          } else {
            echo ' 
            <div class="form-group">
            <label for="review_text">Your Review:</label>
            <textarea class="form-control" name="review_text" id="review_text" rows="4"></textarea>
          </div>
          <input type="hidden" name="product_id" value="'.$pr_id.'">
            <button type="submit" class="btn btn-success mt-2 justify-content-center">Submit Review</button>';
          }
          ?>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Loader -->
<div id="loader" style="display: none;">
  <div id="loading-indicator">
    <div class="spinner"></div>
  </div>
</div>

<!-- JavaScript -->
<script>
  document.addEventListener("DOMContentLoaded", function () {
    const reviewForm = document.querySelector("#reviewForm");
    const loader = document.querySelector("#loader");
    const averageRating = document.querySelector("#averageRating");
    const averageRatingStars = document.querySelector("#averageRatingStars");
    const reviewsContainer = document.querySelector("#reviewsContainer");
    const viewMoreButtonContainer = document.querySelector("#viewMoreButtonContainer");
    const next = document.querySelector("#next");
    const prev = document.querySelector("#prev");

    // Number of reviews to display initially
    const reviewsPerPage = 3;

    // Variables to keep track of current reviews page and total reviews count
    let currentPage = 1;
    let totalReviewsCount = 0;
    let allReviews = [];

    reviewForm.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(reviewForm);

      // Display the loader while processing the form submission
      loader.style.display = "block";

      // Implement AJAX request to submit the review
      fetch(reviewForm.action, {
        method: "POST",
        body: formData,
      })
        .then((response) => response.json())
        .then((data) => {
          // If the review was successfully submitted, fetch and display updated reviews
          if (data.success) {
            fetchAndDisplayReviews();
            // Show the success message
            successMessage.style.display = "block";
            // Hide the success message after 3 seconds
            setTimeout(function () {
              successMessage.style.display = "none";
            }, 3000);
          } else {
            // If the review submission failed, you can handle the error here if needed.
            // For example, you can display an error message or perform any other actions.
          }

          // Hide the loader
          loader.style.display = "none";
        })
        .catch((error) => {
          console.error("Error:", error);
          alert("error");
          // Hide the loader on error
          loader.style.display = "none";
        });
    });

    // Function to fetch and display reviews based on the current page
    function fetchAndDisplayReviews() {
      const productId = <?php echo $pr_id; ?>;

      // Fetch the average rating
fetch(`get_average_rating.php?product_id=${productId}`)
  .then((response) => response.json())
  .then((data) => {
    const averageRatingValue = data.averageRating.toFixed(1);
    averageRating.textContent = averageRatingValue;

    // Display rating stars (using font-awesome icons)
    averageRatingStars.innerHTML = "";
    for (let i = 1; i <= 5; i++) {
      const star = document.createElement("i");
      if (i <= averageRatingValue) {
        star.className = "fa fa-star text-warning";
      } else {
         star.classList.remove("fa-star-o");
      }
      averageRatingStars.appendChild(star);
    }
  })
  .catch((error) => {
    console.error("Error fetching average rating:", error);
  });

      // Fetch all reviews
      fetch(`get_product_reviews.php?product_id=${productId}`)
        .then((response) => response.json())
        .then((data) => {
          allReviews = data.reviews;
          totalReviewsCount = allReviews.length;
          displayReviews();
          
          // Hide the loader after reviews are fetched
      loader.style.display = "none";
        })
        .catch((error) => {
          console.error("Error fetching reviews:", error);
          
          // Hide the loader after reviews are fetched
      loader.style.display = "none";
        });
    }

   // Function to display reviews for the current page
function displayReviews() {
  const startIndex = (currentPage - 1) * reviewsPerPage;
  const endIndex = startIndex + reviewsPerPage;
  const reviewsForCurrentPage = allReviews.slice(startIndex, endIndex);

  if (reviewsForCurrentPage.length > 0) {
    reviewsContainer.innerHTML = "";
    reviewsForCurrentPage.forEach((review) => {
      const reviewDiv = document.createElement("div");
      reviewDiv.className = "mb-3";
      reviewDiv.innerHTML = `
        <p class="fw-bold small">${review.user_name}</p>
        <p class="mb-0 small">${review.review_text}</p>
        <div class="rating-stars mt-2 fs-6">
      `;

      for (let i = 1; i <= 5; i++) {
        const star = document.createElement("i");
        if (i <= review.rating) {
          star.className = "fa fa-star text-warning";
        } else {
          star.classList.remove("fa-star-o");
        }
        reviewDiv.querySelector(".rating-stars").appendChild(star);
      }

      reviewDiv.innerHTML += "</div>";
      reviewsContainer.appendChild(reviewDiv);
    });

    // Check if there are more reviews to show
    if (endIndex < totalReviewsCount) {
      // Show the "Next" button if there are more reviews
      next.style.display = "inline-block";
    } else {
      // Hide the "Next" button if all reviews are shown
      next.style.display = "none";
    }
  } else {
    // Hide the "View More Reviews" button if there are no reviews to display
    viewMoreButtonContainer.style.display = "none";
    reviewsContainer.innerHTML = "<p>No reviews yet. <br> Be the first person to review..</p>";
  }
}


     // Handle user rating selection
    const userRatingStars = document.querySelectorAll(".user-rating-star");
    const userRatingInput = document.querySelector("#userRating");
 function updateUserRating(rating) {
      userRatingInput.value = rating;

      // Update the visual display of stars based on the selected rating
      userRatingStars.forEach((star, index) => {
        if (index < rating) {
          star.classList.add("text-warning"); // Fill stars with warning color
          star.classList.remove("fa-star-o"); // Remove empty star class
          star.classList.add("fa-star"); // Add filled star class
        } else {
          star.classList.remove("text-warning"); // Empty stars
          star.classList.remove("fa-star"); // Remove filled star class
          star.classList.add("fa-star-o"); // Add empty star class
        }
      });
    }

    // Initially set the user rating to 0 (empty stars)
    updateUserRating(0);

    userRatingStars.forEach((star) => {
      star.addEventListener("click", function () {
        const rating = parseInt(this.dataset.rating);
        updateUserRating(rating);
      });

      star.addEventListener("mouseover", function () {
        const rating = parseInt(this.dataset.rating);
        updateUserRating(rating);
      });

      star.addEventListener("mouseout", function () {
        const userRating = parseInt(userRatingInput.value);
        updateUserRating(userRating);
      });
    });
    // Function to handle "View More Reviews" button click
    next.addEventListener("click", function () {
      currentPage++; // Move to the next page
      displayReviews();

// Show the loader while fetching the next page reviews
  loader.style.display = "block";
      // Show the "Prev" button when on the second page or beyond
      if (currentPage > 1) {
        prev.style.display = "inline-block";
      }
    });

    prev.addEventListener("click", function () {
      currentPage--; // Move to the previous page
      displayReviews();

      // Hide the "Prev" button if on the first page
      if (currentPage === 1) {
        prev.style.display = "none";
      }
 // Show the loader while fetching the previous page reviews
  loader.style.display = "block";
      // Show the "Next" button when going back to a previous page
      next.style.display = "inline-block";
    });

    // Fetch and display initial reviews on page load
    fetchAndDisplayReviews();
  });
</script>
<!-- relatate products css -->
<style>
  .scrollbar-horizontal {
    overflow-x: scroll;
  }

  .scrollbar-horizontal__wrapper {
    display: inline-flex;
  }

  .scrollbar-horizontal__content {
    white-space: nowrap;
  }

  .related-product-card {
   
    margin-bottom: 30px;
    margin-right: 5px;
    display: inline-block;
  }
  .card-body{
    margin: 5px;
  }
 .card-body a{
    text-decoration: none;
  }
  .card-body img{
    /* aspect-ratio: 3/2; */
  }

  .related-product-card .card-img-top {
    height: 150px;
    /* object-fit: cover; */
  }
</style>

<?php
// Display related products
echo '<h2 class="text-center mt-4 mb-3 text-success">Related Products</h2>';
echo '<div class="row justify-content-center">
        <div class="col-10">
          <div class="scrollbar-horizontal">
            <div class="scrollbar-horizontal__wrapper">
              <div class="scrollbar-horizontal__content">';

 $sql8 = "SELECT *, GROUP_CONCAT(product_images.image_content) AS images
                FROM products
                JOIN product_images ON product_images.product_id =
                products.sr_no
                WHERE `products`.`cat_id` = $cat_id
                GROUP BY products.sr_no LIMIT 10 
                ";

$result8 = mysqli_query($conn, $sql8);

if (!$result8) {
  echo "Error executing query: " . mysqli_error($conn);
} else {
  $num8 = mysqli_num_rows($result8);
  if ($num8 > 0) {
    while ($row8 = mysqli_fetch_assoc($result8)) {
    

      echo '<div class="related-product-card">
              <div class="card m-auto shadow border">
                <div class="card-body">
                  <a href="product_detail.php?category=' . $cat_id . '&&product=' . $row8['sr_no'] . '" >';
echo ' <img src="data:products/jpg;charset=utf8;base64,'.
                         base64_encode($row8['image_content']).'" height="200" width="200"
                         class="card-img-top">';
     

      echo '<p class="card-text card-title mt-2 text-uppercase fs-5 text-success fw-bold text-center related-product-card-text">' . $row8['pr_name'] . '</p>
            <p class="card-title mt-2 text-center">
              <s class="text-danger fs-6">Rs.' . $row8['main_price'] . '/-</s> 
              <b class="text-success fs-5">Rs. ' . $row8['discounted_price'] . '/-</b>
            </p>
           
          </a>
          </div>
        </div>
      </div>';
    }
  } else {
    echo "No related products found.";
  }
}

echo '</div>
      </div>
    </div>
  </div>
</div>';

include 'partials/loginmodal.php';
include 'partials/loginmodal.php';
?>


 <?php
include 'partials/payNow_confirm_modal.php';
include 'partials/cod_confirm_modal.php';
?>

<?php

require "footer.php";
?>


