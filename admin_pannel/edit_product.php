<?php
session_start();
if (!$_SESSION['admin_logedin']) {
    header("Location: partials/admin_login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Products</title>
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

$pr_id= $_GET['product'];
$cat_id= $_GET['category'];
$show = "SELECT * FROM `products` where sr_no= $pr_id";
          $result = mysqli_query($conn, $show);
          $num = mysqli_num_rows($result);
          
?>
<section class="veg_section layout_paddingn mt-4">

        <!-- Loop through products and populate the table rows -->
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
          $pr_name= $row['pr_name'];
          $pr_id= $row['sr_no'];
          $seed_type=$row['seed_type'];
          $net_wt=$row['net_wt'];
          $pr_desc=$row['pr_desc'];
          $width=$row['width'];
          $breadth=$row['breadth'];
          $pr_state=$row['pr_state'];
          $manufacurer=$row['pr_manufacturer'];
          $main_price=$row['main_price'];
          $discounted_price=$row['discounted_price'];
          $wholesale_price=$row['wholesale_price'];
           
        }
        ?>
   



</section>

<div class=" d-flex justify-content-center align-items-center">
    <h3><strong>Edit Product</strong></h3></div>
<form id="myForm" method="post" enctype="multipart/form-data">
    <div class="">
        <div id="categoryFormContainer">
            <?php
            echo '       
            <input type="text" class="form-control" hidden required aria-describedby="emailHelp" name="pr_id" value="'.$pr_id.'"><div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput" required aria-describedby="emailHelp" name="pr_name" value="'.$pr_name.'">
<label for="floatingInput">Banner Name</label>
</div>
<div class="form-floating mb-3 ">
<input hidden   type="text" class="form-control" id="floatingInput"
aria-describedby="emailHelp" name="cat_id" value= "'.$cat_id.'">';
switch ($cat_id) {
  case '1':
    // Generate input fields for category 1
    echo '
<div class="mb-3">
<div class="form-floating">
 <select class="form-select" id="floatingSelect" name="seed_type" aria-label="Floating label select example">';?>
    <?php
    $options = array("select", "Dried", "Cold", "Liquid", "Summary", "Winter", "Rainy");
    foreach ($options as $option) {
        $selected = ($seed_type === $option) ? 'selected' : '';
        echo '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
    }
    ?>
    <?php
    echo '</select>
  <label for="floatingSelect">Type of seed</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" value="'.$net_wt.'">
<label for="floatingInput">Net wt.</label>
</div>
        ';
    break;
  case '2':
    // Generate input fields for category 2
    echo '
            <div class="form-floating mb-3 ">
<div class="input-group">
  <span class="input-group-text">Size in metre</span>
  <input type="text" aria-label="height" name="widht" class="form-control" value="'.$width.'">
  <h4> X </h4>
   <input type="text" aria-label="width" name="breadth" class="form-control" value="'.$breadth.'">
</div>
</div>
        ';
    break;

  case '3':
    echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">'?>
   <?php
    $options = array("select", "Dried", "Cold", "Liquid");
    foreach ($options as $option) {
        $selected = ($pr_state === $option) ? 'selected' : '';
        echo '<option value="' . $option . '" ' . $selected . '>' . $option . '</option>';
    }
    ?>

    <?php
    echo ' </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt." value="'.$net_wt.'">
<label for="floatingInput">Net wt.</label>
</div>

                                            ';
    break;
  case '4':
    echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
 <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">  
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>


                                            ';
    break;
  case '5':
    echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>

                                            ';
    break;
  case '6':
    echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>

                                            ';
    break;
  case '7':
    echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>


                                            ';
    break;
  case '8':
    echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>

                                            ';
    break;
  case '9':
    echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>

                                            ';
    break;
  case '10':
    echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>

                                            ';
    break;
  // ... and so on for other categories

}
echo
' <div class="form-floating mb-3 ">

  <textarea class="form-control"  name="pr_desc" id="floatingTextarea2" style="height: 100px">'.$pr_desc.'</textarea>
  <label for="floatingTextarea2">Discription</label>

</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="pr_manufacturer"  aria-describedby="emailHelp" placeholder="Manufacturer">
<label for="floatingInput">Manufacturer</label>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"
name="wholesale_price"  aria-describedby="emailHelp" placeholder="Wholesale price" value="'.$wholesale_price.'">
<label for="floatingInput">Wholesale price</label>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="main_price"  aria-describedby="emailHelp" placeholder="Main price" value="'.$main_price.'">
<label for="floatingInput">Main price</label>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="discounted_price"  aria-describedby="emailHelp" placeholder="Discounted price" value="'.$discounted_price.'">
<label for="floatingInput">Discounted price</label>
</div>';?>

<?php 
echo '
       <div class="mb-3 mt-4">
            <input type="file" class="form-control" name="images[]" multiple id="images" accept="image/*">
        </div>
        <button type="button" id="submitForm" class="btn btn-primary"><b>Update Product</b></button>';
            ?>
        </div>
    </div>
    </form>
    <div class="progress mb-3">
        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <script>
$(document).ready(function(){
    $("#submitForm").click(function(){
        var formData = new FormData($("#myForm")[0]);

        $.ajax({
            url: "partials/update_product.php", // Replace with your PHP file handling form submission
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            xhr: function() {
                var xhr = new window.XMLHttpRequest();
                // Upload progress
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
                // Handle the response, e.g., display Swal alert
                if (response) {
                  Swal.fire("Success", "Category updated successfully", "success").then(function() {
                    window.location.href='./products.php';
            });
                  
                    // Optionally, reset the form or perform other actions
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to update product. Please try again.',
                        icon: 'error'
                    });
                }
                // Reset the progress bar
               
            },
            error: function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to update product. Please try again.',
                    icon: 'error'
                });
                // Reset the progress bar
                
            }
        });
    });
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
    width: 150px;
    object-fit: cover;
    margin-bottom: 10px;
    padding-bottom: 10px;
  }
  
  .input-div {
  position: relative;
  width: 50px;
  height: 50px;
  border-radius: 50%;
  border: 2px solid rgb(1, 235, 252);
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
  box-shadow: 0px 0px 100px rgb(1, 235, 252) , inset 0px 0px 10px rgb(1, 235, 252),0px 0px 5px rgb(255, 255, 255);
  animation: flicker 2s linear infinite;
}


.icon {
  color: rgb(1, 235, 252);
  font-size: 2rem;
  cursor: pointer;
  animation: iconflicker 2s linear infinite;
}

.input {
  position: absolute;
  opacity: 0;
  width: 100%;
  height: 100%;
  cursor: pointer !important;
  transition: all 0.2s; /* Add a smooth transition effect */
}




</style>
<?php
echo '<h2 class="text-center mt-4 mb-3 text-success"Edit Images</h2>';
echo '<div class="row justify-content-center">
        <div style="width:100%">
          <div class="scrollbar-horizontal">
            <div class="scrollbar-horizontal__wrapper">
              <div class="scrollbar-horizontal__content">';

 $sql8 = "SELECT * FROM product_images
                WHERE `product_id` = $pr_id";

$result8 = mysqli_query($conn, $sql8);

if (!$result8) {
  echo "Error executing query: " . mysqli_error($conn);
} else {
  $num8 = mysqli_num_rows($result8);
  if ($num8 > 0) {
  while ($row8 = mysqli_fetch_assoc($result8)) {
    echo '<div id="imageContainer' . $row8['id'] . '" class="related-product-card">
            <div class="card m-auto shadow border">
                <div class="card-body">';
                
    echo '  <div id="spinner' . $row8['id'] . '" class="spinner-border text-primary" role="status" style="display: none;">
                <span class="visually-hidden">Loading...</span>
            </div>
    <img src="data:products/jpg;charset=utf8;base64,' .
        base64_encode($row8['image_content']) . '" height="200" width="250"
                         class="card-img-top">';

    echo '
          <p class="card-title mt-2 text-center">
            <div class="input-div">
              <input class="input" name="file" type="file" id="imageInput' . $row8['id'] . '" onchange="enableUploadButton(' . $row8['id'] . ')">
              <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor" class="icon"><polyline points="16 16 12 12 8 16"></polyline><line y2="21" x2="12" y1="12" x1="12"></line><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path><polyline points="16 16 12 12 8 16"></polyline></svg>
            </div>
            <button id="uploadButton' . $row8['id'] . '" class="btn btn-primary" disabled onclick="uploadImage(' . $row8['id'] . ')">Update </button>
            <button id="deleteButton' . $row8['id'] . '" class="btn btn-danger" onclick="deleteImage(' . $row8['id'] . ')">Delete</button>
           
          </p>
        </div>
      </div>
    </div>';
    ?>
    
  <script>
      function enableUploadButton(id) {
        var imageInput = document.getElementById("imageInput" + id);
        var uploadButton = document.getElementById("uploadButton" + id);

        if (imageInput.files.length > 0) {
          uploadButton.disabled = false;
        } else {
          uploadButton.disabled = true;
        }
      }
      
  function uploadImage(id) {
    var imageInput = document.getElementById("imageInput" + id);
    var uploadButton = document.getElementById("uploadButton" + id);

    var formData = new FormData();
    formData.append("file", imageInput.files[0]);
    formData.append("id", id);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "partials/updateImage.php", true);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === 4 && xhr.status === 200) {
        var response = JSON.parse(xhr.responseText);

        if (response.success) {
          Swal.fire({
            icon: 'success',
            title: 'Image Updated!',
            showConfirmButton: true, // Show the confirm button
            confirmButtonText: 'OK', // Set the text for the confirm button
          }).then((result) => {
            if (result.isConfirmed) {
              // If user clicks "OK", refresh the page
              location.reload();
            }
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Image update failed!',
          });
        }
      }
    };

    xhr.send(formData);
    uploadButton.disabled = true;
  }
   
  function deleteImage(imageId) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: 'You won\'t be able to revert this!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Prevent the default form submission behavior
          

            // Call the server-side script to delete the image
            $.ajax({
                url: 'partials/delete_image.php', // Replace with your delete image script
                type: 'POST',
                data: { image_id: imageId },
                success: function(response) {
                    if (response) {
                        // Image deleted successfully
                        Swal.fire('Deleted!', 'The image has been deleted.', 'success');
                        // Optionally, remove the deleted image container from the UI
                        $('#imageContainer' + imageId).remove();
                    } else {
                        Swal.fire('Error', 'Failed to delete the image. Please try again.', 'error');
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Failed to delete the image. Please try again.', 'error');
                }
            });
        }
    });
}
    </script>
    <?php 
   

}



    
  } else {
    echo "No related products found.";
  }
}

echo '</div>
      </div>
    </div>
  </div>
</div>';?>
<footer>
    Admin Panel &copy; <?php echo date('Y'); ?> Ahire Agro Mall
</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
<script>
   $(document).ready(function () {
    $("#sidebarCollapse").on("click", function () {
        $("#sidebar").toggleClass("active");
        $("#content").toggleClass("active");
        $(".custom-navbar").toggleClass("active");
    });

});

</script>
</body>
</html>
