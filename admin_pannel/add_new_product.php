<?php
session_start();
if (!$_SESSION['admin_logedin']) {
  header("Location: partials/admin_login.php");
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New Product</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
       <link rel="stylesheet" href="css/admin.css">
  </head>
  <body>
   <?php
    include("../db_config.php");
    include("navbar.php");
   ?>
  <div class="container-fluid mt-4">
    <div class=" d-flex justify-content-center align-items-center">
    <h3><strong>Add New Product</strong></h3></div>
   
  

<div class="m-4">
     
        <label><h4>Please select category: </h4></label>
        <select class="form-select" name="category"
        onchange="loadCategoryForm(this.value)" id="category" aria-label="Floating
        label select example">
            <option selected value="0">Select</option>
           <?php

                $show = "SELECT * FROM `categories` ORDER BY `categories`.`cat_id` ASC";
                $result = mysqli_query($conn, $show);
                $num = mysqli_num_rows($result);
                if ($num > 0) {

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="'.($row['cat_id']).'">'.$row['cat_name'].'</option>';
                    }
                }
                ?>
        </select>
  <form id="myForm" method="post" enctype="multipart/form-data">
    <div class="container">
        <div id="categoryFormContainer">
            <!-- Dynamic content will be inserted here -->
        </div>
    </div>
    </form>
     <!-- Progress bar container -->
    <div class="progress mb-3">
        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <!-- Server response container -->
   <div class="alert alert-success" id="responseAlert" role="alert" style="display: none;"></div>


<!-- ... Your existing HTML code ... -->



</div>



 
   </div>
   <footer>
    Admin Panel &copy; <?php echo date('Y'); ?> Ahire Agro Mall
  </footer>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
        $(document).ready(function () {
            $("#sidebarCollapse").on("click", function () {
                $("#sidebar").toggleClass("active");
                $("#content").toggleClass("active");
                $(".custom-navbar").toggleClass("active");
            });
// Hide the progress bar initially
//$('#progressBar').hide();
// Hide the progress bar initially
//$('#progressBar').hide();

// Event delegation for form submission
$(document).on("click", "#submitForm", function() {
     $('#progressBar').show();
    var formData = new FormData($("#myForm")[0]);
    
    // Disable the submit button to prevent multiple submissions
    $("#submitForm").attr("disabled", true);

    $.ajax({
        url: "add_products_partials/process_form.php", // URL to submit the form to
        type: "POST", // HTTP method
        data: formData, // Data to be sent
        contentType: false, // Set to false for FormData
        processData: false, // Set to false for FormData
        xhr: function() {
            // Create an XMLHttpRequest with progress tracking
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(e) {
                if (e.lengthComputable) {
                    var percentComplete = (e.loaded / e.total) * 100;
                    $("#progressBar").css("width", percentComplete + "%");
                    $("#progressBar").attr("aria-valuenow", percentComplete);
                    $("#progressBar").text(percentComplete.toFixed(2) + "%");
                }
            });
            return xhr;
        },
        success: function(response) {
            $("#response").html(response);
            $("#progressBar").css("width", "100%");
            $("#progressBar").attr("aria-valuenow", 100);
            $("#progressBar").text("100%");
 $("#responseAlert").removeClass("alert-danger").addClass("alert-success").text(response).show();
            // Clear the form for new record
            $("#myForm")[0].reset();

            // Re-enable the submit button
            $("#submitForm").attr("disabled", false);
             // Hide success message after a delay
    // Hide success alert after a delay
    setTimeout(function() {
      $("#responseAlert").fadeOut(500, function() {
        $(this).hide();
    });
    }, 3000); // Adjust the delay in milliseconds as needed
        },
        error: function() {
              $("#responseAlert").removeClass("alert-success").addClass("alert-danger").text("Error submitting form.").show();
            $("#progressBar").addClass("bg-danger");
        },
        complete: function() {
            // Hide the progress bar after completion
            $('#progressBar').hide();
            $("#progressBar").removeClass("bg-danger");
            $("#progressBar").text("");
        }
    });
});

    // Event delegation for category selection
    $(document).on("change", "#category", function() {
        var categoryId = $(this).val();
        loadCategoryForm(categoryId);
    });
    
    // Function to load category form dynamically
    function loadCategoryForm(categoryId) {
        if (categoryId !== "0") {
            $.ajax({
                url: "add_products_partials/get_category_form.php", // URL to get category form
                type: "GET", // HTTP method
                data: { category: categoryId }, // Data to send
                success: function(response) {
                    $("#categoryFormContainer").html(response);
                },
                error: function() {
                    $("#categoryFormContainer").html("Error loading category form.");
                }
            });
        } else {
            $("#categoryFormContainer").empty();
        }
    }
});
     
</script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.min.js" integrity="sha384-Rx+T1VzGupg4BHQYs2gCW9It+akI2MM/mndMCy36UVfodzcJcF0GGLxZIzObiEfa" crossorigin="anonymous"></script>
  </body>
</html>