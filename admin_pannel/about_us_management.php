<?php
session_start();
if (!isset($_SESSION['admin_logedin']) && !isset($_SESSION['manager_logedin'])) {
  // Display an alert using JavaScript
  echo "<script>alert('You do not have access to this page. Please go back.')</script>";

  // Redirect the user to the previous page
  echo "<script>window.history.back();</script>";

  // Exit the script to prevent further execution
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>About Us Management</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://kit.fontawesome.com/c932d99d51.js" crossorigin="anonymous"></script>

    <style>
       body {
            background-color: #f8f9fa;
        }
        .container {
            background-color: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        label {
            font-weight: bold;
        }
        .table th {
            width: 30%;
        }
        .form-group {
            margin-bottom: 20px;
        }
        textarea.form-control {
            resize: vertical;
        }
    </style>
</head>
<body>

<?php
include("../db_config.php");
include("navbar.php");

$sql = "SELECT * FROM `about_us` where id= 1";
          $result = mysqli_query($conn, $sql);
          $num = mysqli_num_rows($result);
          while ($row = mysqli_fetch_assoc($result)) {
            $id= $row['id'];
            $shop_name= $row['shop_name'];
            $owner_name=$row['owner_name'];
            $phone1=$row['phone1'];
            $phone2=$row['phone2'];
            $email=$row['email'];
            $owner_qualification=$row['owner_qualification'];
            $about_owner=$row['about_owner'];
            $about_heading=$row['about_heading'];
            $about_description=$row['about_description'];
            $website=$row['website'];
            $linkedin=$row['linkedin'];
            $facebook=$row['facebook'];
            $twitter=$row['twitter'];
            $instagram=$row['instagram'];
            $gstin=$row['gstin'];
            $address=$row['address'];
            $owner_image=$row['owner_image'];
             
          }
?>
    <div class="container mt-5">
    <h1 class="mb-4">About Us Management</h1>
    
        <table class="table">
        <tr>
                <th><label for="owner_image">Owner Image:</label></th>
                <td colspan="3"><?php


 


    echo '<div id="imageContainer" class="related-product-card">
            <div class="card m-auto shadow border">
                <div class="card-body">';
                
    echo ' 
    <img src="data:products/jpg;charset=utf8;base64,' .
        base64_encode($owner_image) . '" height="200" width="250"
                         class="card-img-top">';

    echo '
          <p class="card-title mt-2 text-center">
            <div class="input-div">
              <input class="input" name="file" type="file" id="imageInputUser' . $id . '" onchange="enableUploadUserButton(' . $id . ')">
              <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor" class="icon"><polyline points="16 16 12 12 8 16"></polyline><line y2="21" x2="12" y1="12" x1="12"></line><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path><polyline points="16 16 12 12 8 16"></polyline></svg>
            </div>
            <button id="uploadUserButton' . $id . '" class="btn btn-primary" disabled onclick="uploadUserImage(' . $id . ')">Update </button>
            
           
          </p>';
    ?></td>
    <script>
      function enableUploadUserButton(id) {
        var imageInputUser = document.getElementById("imageInputUser" + id);
        var uploadUserButton = document.getElementById("uploadUserButton" + id);

        if (imageInputUser.files.length > 0) {
          uploadUserButton.disabled = false;
        } else {
          uploadUserButton.disabled = true;
        }
      }
      
  function uploadUserImage(id) {
    var imageInputUser = document.getElementById("imageInputUser" + id);
    var uploadUserButton = document.getElementById("uploadUserButton" + id);

    var formData = new FormData();
    formData.append("file", imageInputUser.files[0]);
    formData.append("id", id);

    var xhr = new XMLHttpRequest();
    xhr.open("POST", "partials/updateOwnerImage.php", true);

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
   
 
    </script>
            </tr>
            <form id="myForm" method="post" enctype="multipart/form-data">
            <tr>
                <th><label for="shop_name">Shop Name:</label></th>
                <td><input type="text" class="form-control" id="shop_name" name="shop_name" placeholder="Enter shop name" required value="<?php echo $shop_name;?>">
                <input type="text" class="form-control" id="id" name="id" hidden required value="<?php echo $id;?>"></td>
                <th><label for="owner_name">Owner Name:</label></th>
                <td><input type="text" class="form-control" id="owner_name" name="owner_name" placeholder="Enter owner name" required value="<?php echo $owner_name;?>"></td>
            </tr>
            <tr>
                <th><label for="phone1">Phone 1:</label></th>
                <td><input type="tel" class="form-control" id="phone1" name="phone1" placeholder="Enter phone number 1" required value="<?php echo $phone1;?>"></td>
                <th><label for="phone2">Phone 2:</label></th>
                <td><input type="tel" class="form-control" id="phone2" name="phone2" placeholder="Enter phone number 2" value="<?php echo $phone2;?>"></td>
            </tr>
            <tr>
                <th><label for="email">Email:</label></th>
                <td><input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required value="<?php echo $email;?>"></td>
                <th><label for="owner_qualification">Owner Qualification:</label></th>
                <td><input type="text" class="form-control" id="owner_qualification" name="owner_qualification" placeholder="Enter owner qualification" required value="<?php echo $owner_qualification;?>"></td>
            </tr>
            <tr>
                <th><label for="about_owner">About the Owner:</label></th>
                <td colspan="3"><textarea class="form-control" id="about_owner" name="about_owner" rows="4" placeholder="Enter about the owner" required ><?php echo $about_owner;?></textarea></td>
            </tr>
            
            <tr>
                <th><label for="about_heading">About Us Heading:</label></th>
                <td colspan="3"><input type="text" class="form-control" id="about_heading" name="about_heading" placeholder="Enter about us heading" required value="<?php echo $about_heading;?>"></td>
            </tr>
            <tr>
                <th><label for="about_description">About Us Description:</label></th>
                <td colspan="3"><textarea class="form-control" id="about_description" name="about_description" rows="4" placeholder="Enter about us description" required><?php echo $about_description;?></textarea></td>
            </tr>
           
            <tr>
                <th><label for="website">Website:</label></th>
                <td colspan="3"><input type="url" class="form-control" id="website" name="website" placeholder="Enter website URL" value="<?php echo $website;?>"></td>
            </tr>
            <tr>
                <th><label for="linkedin">LinkedIn:</label></th>
                <td colspan="3"><input type="url" class="form-control" id="linkedin" name="linkedin" placeholder="Enter LinkedIn URL" value="<?php echo $linkedin;?>"></td>
            </tr>
            <tr>
                <th><label for="facebook">Facebook:</label></th>
                <td colspan="3"><input type="url" class="form-control" id="facebook" name="facebook" placeholder="Enter Facebook URL" value="<?php echo $facebook;?>"></td>
            </tr>
            <tr>
                <th><label for="twitter">Twitter:</label></th>
                <td colspan="3"><input type="url" class="form-control" id="twitter" name="twitter" placeholder="Enter Twitter URL" value="<?php echo $twitter;?>"></td>
            </tr>
            <tr>
                <th><label for="instagram">Instagram:</label></th>
                <td colspan="3"><input type="url" class="form-control" id="instagram" name="instagram" placeholder="Enter Insta URL" value="<?php echo $instagram;?>"></td>
            </tr>
            <tr>
                <th><label for="gstin">Shop GSTIN No:</label></th>
                <td colspan="3"><input type="text" class="form-control" id="gstin" name="gstin" placeholder="Enter GSTIN number" value="<?php echo $gstin;?>"></td>
            </tr>
            <tr>
                <th><label for="address">Address of Shop:</label></th>
                <td colspan="3"><textarea class="form-control" id="address" name="address" rows="4" placeholder="Enter address of shop" required><?php echo $address;?></textarea></td>
            </tr>
            <tr>
                <th><label for="shop_gallery_images">Shop Gallery Images:</label></th>
                <td colspan="3"><input type="file" class="form-control" id="shop_gallery_images" name="shop_gallery_images[]" multiple  accept="image/*"></td>
            </tr>
        </table>
        <button type="button" id="submitForm" class="btn btn-primary">Submit</button>
    </form>
</div>
<div class="progress mb-3">
        <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <script>
$(document).ready(function(){
    $("#submitForm").click(function(){
        var formData = new FormData($("#myForm")[0]);

        $.ajax({
            url: "partials/update_aboutUs.php", // Replace with your PHP file handling form submission
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
                  Swal.fire("Success", "Details updated successfully", "success").then(function() {
                    location.reload();
            });
                  
                    // Optionally, reset the form or perform other actions
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to update Details. Please try again.',
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

 $sql8 = "SELECT * FROM shop_gallery_images
                WHERE `about_us_id` = $id";

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
        base64_encode($row8['image_data']) . '" height="200" width="250"
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
    xhr.open("POST", "partials/updateGalleryImage.php", true);

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
            text: response.message,
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
                url: 'partials/deleteGalleryImage.php', // Replace with your delete image script
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