<?php
require 'header.php';
require 'db_config.php';
?>

<script>
  function applyFilter(categoryId) {
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        document.getElementById("productListing").innerHTML = this.responseText;
      }
    };
    xhttp.open("GET", "filter.php?category=" + categoryId, true);
    xhttp.send();
  }
</script>

<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <?php
        $offer = "SELECT * FROM `offers1`";
        $offerResult = mysqli_query($conn, $offer);
        $no = mysqli_num_rows($offerResult);
        $firstItem = true; // Flag to track the first item

        if ($no > 0) {
            while ($offerData = mysqli_fetch_assoc($offerResult)) {
                // Check if it's the first item
                $activeClass = $firstItem ? 'active' : '';

                echo '
                <div class="carousel-item ' . $activeClass . '">
                    <img src="data:products/jpg;charset=utf8;base64,' . base64_encode($offerData['image']) . '" class="d-block w-100 ideal-size" alt="...">
                    <div class="carousel-caption">
                        <h5>' . $offerData['title'] . '</h5>
                        <p>
                            ' . $offerData['description'] . '
                        </p>
                    </div>
                </div>';

                $firstItem = false; // Update the flag after the first item
            }
        }
        ?>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>



<section class="veg_section layout_paddingn mt-4">
  <div class="container">
    <div class="heading_container text-center mt-2">
      <h2>
        <hr>
        Our Products
      </h2>
      <p>
        which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't an
      </p>
    </div>
    <div class="d-flex justify-content-center">
      <div>
        <button type="button" class="btn btn-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
          Apply Filter
        </button>
        <ul class="dropdown-menu">
          <?php
          $show = "SELECT * FROM `categories`";
          $result = mysqli_query($conn, $show);
          $num = mysqli_num_rows($result);
          if ($num > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              echo '<li><a class="dropdown-item" href="#" onclick="applyFilter(' . $row['cat_id'] . ')">' . $row['cat_name'] . '</a></li>';
            }
          }
          ?>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="#" onclick="applyFilter('')">Cancel Filter</a></li>
        </ul>
      </div>
    </div>
    <style>
      
    </style>
    <div id="productListing" class="row">
      <?php
      $limit = 6; // Number of products to display initially
      $offset = 0; // Initial offset
      $sql = "SELECT *, GROUP_CONCAT(product_images.image_content) AS images
                FROM products
                JOIN product_images ON product_images.product_id =
                products.sr_no
                GROUP BY products.sr_no LIMIT $limit OFFSET $offset
                ";
      
      $result = mysqli_query($conn, $sql);
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
      ?>
    </div>
    <?php
    $sql = "SELECT COUNT(*) AS total FROM `products`";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $totalProducts = $row['total'];
    if ($totalProducts > $limit) {
      echo '<div id="loadMoreContainer" class="text-center">
              <button id="loadMoreButton" class="btn btn-success" onclick="loadMoreProducts(' . $limit . ', ' . $totalProducts . ')">View More</button>
            </div>';
    }
    ?>
    <div id="loadingIndicator" class="text-center" style="display: none;">
      <div class="spinner-border text-success" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
  </div>
  <hr>
</section>

<script>
  function loadMoreProducts(limit, totalProducts) {
    var offset = document.querySelectorAll("#productListing .card").length;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
      if (this.readyState == 4) {
        if (this.status == 200) {
          var productListing = document.getElementById("productListing");
          productListing.innerHTML += this.responseText;
          checkLoadMoreButtonVisibility(limit, totalProducts);
        } else {
          // Handle error case
          console.log("Error: " + this.status);
        }
        hideLoadingIndicator();
      }
    };
    xhttp.open("GET", "load_more.php?limit=" + limit + "&offset=" + offset, true);
    xhttp.send();
    showLoadingIndicator();
  }

  function checkLoadMoreButtonVisibility(limit, totalProducts) {
    var loadMoreButton = document.getElementById("loadMoreButton");
    if (loadMoreButton) {
      var productCount = document.querySelectorAll("#productListing .card").length;
      if (productCount >= totalProducts) {
        loadMoreButton.style.display = "none";
      } else {
        loadMoreButton.style.display = "block";
      }
    }
  }

  function showLoadingIndicator() {
    var loadingIndicator = document.getElementById("loadingIndicator");
    if (loadingIndicator) {
      loadingIndicator.style.display = "block";
    }
  }

  function hideLoadingIndicator() {
    var loadingIndicator = document.getElementById("loadingIndicator");
    if (loadingIndicator) {
      loadingIndicator.style.display = "none";
    }
  }
</script>


<section class="about_section text-center" id="About">

<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">

<div class="carousel-inner">

<div class="carousel-item active">

<img src="https://source.unsplash.com/collection/agriculture/1100x400" class="d-block w-100" alt="...">

<div class="carousel-caption mt-2" style="
position: absolute;
top: 0;
">
<div class="heading_container">
<h2>
<b>About <span>Us</span></b>
</h2>
<hr>
<h2>
We Provide <br>
Agro Products
</h2>
</div>
<p>
Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ad ex, sequi amet similique necessitatibus quas minus repudiandae quae culpa optio ipsum quibusdam praesentium saepe qui dolore voluptate iure sit aut.
</p>
<a href="about.php" class="btn btn-success">Read More</a>
</div>
</div>
</div>
</div>

</section>



<section class="contact_section layout_padding my-4 text-center" id="Contact">
    <div class="container">
        <div class="heading_container">
            <h2>
                <b>Contact <span>Us</span></b>
            </h2>
        </div>
        <div class="row">
            <div class="">
                <div class="form_container contact-form ">
                    <form id="contactForm" class="mx-auto justify-content-center">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" placeholder="E mail" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" name="message" rows="3" placeholder="Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success" style="width: 18rem;">Send</button>
                    </form>
                    <div id="loadingSpinner" class="spinner" style="display: none;"></div>
                </div>
            </div>
        </div>
        <hr>
    </div>
</section>
<style>
  .spinner {
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top: 4px solid #00bcd4;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    position: absolute;
    top: 50%;
    left: 50%;
    margin-top: -20px;
    margin-left: -20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function () {
    $("#contactForm").submit(function (event) {
        event.preventDefault();

        // Display a loading spinner
        $("#loadingSpinner").show();

        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "partials/submitContact.php", // Replace with the path to your PHP script
            data: formData,
            success: function (response) {
                // Example: Display a success message using SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Form submitted successfully!',
                });

                // Reset the form
                $("#contactForm")[0].reset();

                // Hide the loading spinner
                $("#loadingSpinner").hide();
            },
            error: function (error) {
                // Example: Display an error message using SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Error submitting form!',
                });

                // Hide the loading spinner
                $("#loadingSpinner").hide();
            }
        });
    });
});

</script>
<!-- end contact section -->

<section class="client_section layout_padding-bottom">
<div class="container">
<div class="heading_container heading_center">
<h2>

</h2>
</div>
<div class="heading_container text-center mt-2">
<h2>
Owners
</h2>
<p>
which don't look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn't an
</p>
</div>

<div class="row">
<div class="col-sm-6 my-2">
<div class="card m-auto shadow border" style="width: 18rem;">
<div class="card-body">
<img src="mayur.jpg" width="200" height="300" class="card-img-top" alt="...">
<h5 class="card-title mt-2">Mayur Aahire</h5>
<p class="card-text">
With supporting text below as a natural lead-in to additional content.
</p>
<a href="#" class="btn btn-success">Know More</a>
</div>
</div>
</div>
<div class="col-sm-6 my-2">
<div class="card m-auto shadow border " style="width: 18rem;">
<div class="card-body">
<img src="jagdish.jpg" width="200" height="300" class="card-img-top" alt="...">
<h5 class="card-title mt-2">Jagdish Aahire</h5>
<p class="card-text">
With supporting text below as a natural lead-in to additional content.
</p>
<a href="#" class="btn btn-success">Know More</a>
</div>
</div>
</div>
</div>
<hr>

</div>
</section>

<section class="Partner_section layout_padding-bottom my-4">
<div class="container">
<div class="heading_container heading_center">
<h2>

</h2>
</div>
<div class="heading_container text-center mt-2">
<h2>
Authorised Business Partner
</h2>
<p>
We are glad to tell you, we are Authorised Business partner with JAIN IRRIGATION SYSTEM LIMITED, jalgaon...
</p>
</div>

<div id="carouselExampleSlidesOnly" class="carousel slide" data-bs-ride="carousel">
<div class="carousel-inner">
<div class="carousel-item active">
<img src="jain_irrigation.jpg" width="1500" height="300" class="d-block w-100" alt="...">
</div>

</div>
</div>
<hr>

</div>
</section>

<?php
require'footer.php';
?>