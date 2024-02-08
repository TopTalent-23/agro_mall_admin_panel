<?php
session_start();
if (!$_SESSION['admin_logedin']) {
    header("Loofferion: partials/admin_login.php");
}
?>
<?php
// Include your database connection file
include("../db_config.php");
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
include("navbar.php");
?>





<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3><strong>Offers</strong></h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addofferModal">Add New Offer</button>
    </div>

    <table class="table mt-3">
        <thead>
        <tr>
            <th>ID</th>
            <th>Title</th>
            <th>Discription</th>
            <th>Discount</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Creation Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Fetch the offeregories from the database
        $show = "SELECT * FROM `offers1` ORDER BY `offers1`.`id` ASC";
        $result = mysqli_query($conn, $show);
        $num = mysqli_num_rows($result);

        if ($num > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $offer_id = $row['id'];
                $title = $row['title'];
                $discription = $row['description'];
                $discount = $row['discount'];
                $startdate = $row['startdate'];
                $enddate = $row['enddate'];
                $creationdate = $row['creationdate'];
                $offerImage = $row['image'];

        ?>
        <tr>
            <td><?php echo $offer_id; ?></td>
            <td><?php echo $title; ?></td>
            <td><?php echo $discription; ?></td>
            <td><?php echo $discount; ?></td>
            <td><?php echo $startdate; ?></td>
            <td><?php echo $enddate; ?></td>
            <td><?php echo $creationdate; ?></td>
            <td>
                <button class="btn btn-sm btn-info" data-bs-toggle="modal"
                        data-bs-target="#editOfferModal<?php echo $offer_id; ?>">Edit
                </button>
                <button class="btn btn-sm btn-danger delete-offer"
                        data-id="<?php echo $offer_id; ?>">Delete
                </button>
            </td>
        </tr>

      <div class="modal fade" id="editOfferModal<?php echo $offer_id; ?>" tabindex="-1" aria-labelledby="editOfferModalLabel<?php echo $offer_id; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editOfferModalLabel<?php echo $offer_id; ?>">Update offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editOfferForm<?php echo $offer_id; ?>">
                    <div class="mb-3">
                        <label for="offerName" class="form-label">Title</label>
                        <input type="text" name="offerId" class="form-control" hidden value="<?php echo $offer_id; ?>">
                        <input type="text" class="form-control" id="offerName" name="offerName" value="<?php echo $title; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="offerDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="offerDescription" name="offerDescription" rows="3"><?php echo $discription; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="offerDiscount" class="form-label">Discount</label>
                        <input type="text" class="form-control" id="offerDiscount" name="offerDiscount" value="<?php echo $discount; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="offerStartdate" class="form-label">Start date</label>
                        <input type="date" class="form-control" id="offerStartdate" name="offerStartdate" value="<?php echo $startdate; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="offerEnddate" class="form-label">End date</label>
                        <input type="date" class="form-control" id="offerEnddate" name="offerEnddate" value="<?php echo $enddate; ?>" required>
                    </div>
                    
                </form>
                
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary editofferBtn" data-modalid="<?php echo $offer_id; ?>">Update</button>
                
            </div>

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

 


    echo '<div id="imageContainer" class="related-product-card">
            <div class="card m-auto shadow border">
                <div class="card-body">';
                
    echo ' 
    <img src="data:products/jpg;charset=utf8;base64,' .
        base64_encode($offerImage) . '" height="200" width="250"
                         class="card-img-top">';

    echo '
          <p class="card-title mt-2 text-center">
            <div class="input-div">
              <input class="input" name="file" type="file" id="imageInput' . $offer_id . '" onchange="enableUploadButton(' . $offer_id . ')">
              <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" stroke-linejoin="round" stroke-linecap="round" viewBox="0 0 24 24" stroke-width="2" fill="none" stroke="currentColor" class="icon"><polyline points="16 16 12 12 8 16"></polyline><line y2="21" x2="12" y1="12" x1="12"></line><path d="M20.39 18.39A5 5 0 0 0 18 9h-1.26A8 8 0 1 0 3 16.3"></path><polyline points="16 16 12 12 8 16"></polyline></svg>
            </div>
            <button id="uploadButton' . $offer_id . '" class="btn btn-primary" disabled onclick="uploadImage(' . $offer_id . ')">Update </button>
            
           
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
    xhr.open("POST", "partials/updateOfferImage.php", true);

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
    <?php 
   

echo '</div>
      </div>
    </div>
  </div>
</div>';?>

            </div>
        </div>
    </div>
</div>


        <?php
            }
        }
        ?>
        </tbody>
    </table>
</div>

<!-- Modals for editing and deleting offeregories -->
<!-- Replace these modals with your actual modals -->

<!-- Add New offer Modal -->
<div class="modal fade" id="addofferModal" tabindex="-1" aria-labelledby="addofferModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addofferModalLabel">Add New offer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addofferForm" enctype="multipart/form-data">
                <div class="mb-3">
                        <label for="offerName" class="form-label">Title</label>
                        
                        <input type="text" class="form-control" id="offerName" name="offerName"  required>
                    </div>
                    <div class="mb-3">
                        <label for="offerDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="offerDescription" name="offerDescription" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="offerDiscount" class="form-label">Discount</label>
                        <input type="text" class="form-control" id="offerDiscount" name="offerDiscount"  required>
                    </div>
                    <div class="mb-3">
                        <label for="offerStartdate" class="form-label">Start date</label>
                        <input type="date" class="form-control" id="offerStartdate" name="offerStartdate"  required>
                    </div>
                    <div class="mb-3">
                        <label for="offerEnddate" class="form-label">End date</label>
                        <input type="date" class="form-control" id="offerEnddate" name="offerEnddate"  required>
                    </div>
                    <div class="mb-3">
                        <label for="offerImage" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="offerImage" name="offerImage" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addOfferBtn">Add offer</button>
            </div>
        </div>
    </div>
</div>





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
   

    $(".delete-offer").click(function () {
        const offerId = $(this).data("id");

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type: "POST",
                    url: "partials/delete_offer.php",
                    data: { offerId: offerId },
                    success: function (response) {
                        if (response) {
                            Swal.fire("Deleted!", "The offer has been deleted.", "success").then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire("Error", "An error occurred while deleting the offer.", "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire("Error", "An error occurred while deleting the offer: " + error, "error");
                    }
                });
            }
        });
    });
    
    
 $(".editofferBtn").click(function () {
    var modalId = $(this).data("modalid");
    var modal = $("#editOfferModal" + modalId);
    var form = modal.find("#editOfferForm" + modalId);

    $.ajax({
    type: "POST",
    url: "partials/update_offer.php",
    data: new FormData(form[0]),
    processData: false,
    contentType: false,
    success: function (response) {
        if (response) {
          
            modal.modal("hide");

            // Update the category name and description within the specific modal
            modal.find("#offerName").text(form.find("[name=offerName]").val());
            modal.find("#offerDescription").text(form.find("[name=offerDescription]").val());
            modal.find("#offerDiscount").text(form.find("[name=offerDiscount]").val());
            modal.find("#offerStartdate").text(form.find("[name=offerStartdate]").val());
            modal.find("#offerEnddate").text(form.find("[name=offerEnddate]").val());
            

          Swal.fire("Success", "Offer updated successfully", "success").then(function() {
                location.reload(); // Reload the page
            });
        } else {
            Swal.fire("Error", "An error occurred while updating the category.", "error");
        }
    }
});

});




    // Add New Category
    $("#addOfferBtn").click(function () {
       var modal = $("#addofferModal");
    var form = modal.find("#addofferForm");
       
  
        $.ajax({
            type: "POST",
            url: "partials/add_offer.php",
            data: new FormData(form[0]),
            processData: false,
            contentType: false,
            success: function (response) {
                if (response) {
                     Swal.fire("Success", "Offer Added successfully", "success").then(function() {
                location.reload(); // Reload the page
            });
                } else {
                    Swal.fire("Error", "An error occurred while adding the Offer..", "error");
                }
            },
            error: function (xhr, status, error) {
                Swal.fire("Error", "An error occurred while adding the offer: " + error, "error");
            }
        });
    });

       
    });

</script>
</body>
</html>


<?php
// Close the database connection
mysqli_close($conn);
?>
