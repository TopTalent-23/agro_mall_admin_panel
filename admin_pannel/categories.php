<?php
session_start();
if (!isset($_SESSION['admin_logedin']) && !isset($_SESSION['manager_logedin']) && !isset($_SESSION['executiveOfficer_logedin']))  {
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
    <title>Categories</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://kit.fontawesome.com/c932d99d51.js" crossorigin="anonymous"></script>
</head>
<body>

<?php
include("../db_config.php");
include("navbar.php");
?>

<div class="container-fluid mt-4">
    <div class="d-flex justify-content-between align-items-center">
        <h3><strong>Categories</strong></h3>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCategoryModal">Add New Category</button>
    </div>

    <table class="table mt-3">
        <thead>
        <tr>
            <th>Category ID</th>
            <th>Category Name</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        // Fetch the categories from the database
        $show = "SELECT * FROM `categories` ORDER BY `categories`.`cat_id` ASC";
        $result = mysqli_query($conn, $show);
        $num = mysqli_num_rows($result);

        if ($num > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $category = $row['cat_name'];
                $cat_id = $row['cat_id'];
                $cat_desc = $row['cat_desc'];
        ?>
        <tr>
            <td><?php echo $cat_id; ?></td>
            <td><?php echo $category; ?></td>
            <td>
                <button class="btn  btn-info" data-bs-toggle="modal"
                        data-bs-target="#editCategoryModal<?php echo $cat_id; ?>"><i class="fa-solid fa-pen-to-square"></i>
                </button>
                <button class="btn  btn-danger delete-category"
                        data-id="<?php echo $cat_id; ?>"><i class="fa-solid fa-trash"></i>  
                </button>
            </td>
        </tr>

      <div class="modal fade" id="editCategoryModal<?php echo $cat_id; ?>" tabindex="-1" aria-labelledby="editCategoryModalLabel<?php echo $cat_id; ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCategoryModalLabel<?php echo $cat_id; ?>">Update Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editCategoryForm<?php echo $cat_id; ?>">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" name="catId" class="form-control" hidden value="<?php echo $cat_id; ?>">
                        <input type="text" class="form-control" id="categoryName" name="categoryName" value="<?php echo $category; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoryDescription" class="form-label">Category Description</label>
                        <textarea class="form-control" id="categoryDescription" name="categoryDescription" rows="3"><?php echo $cat_desc; ?></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary editCategoryBtn" data-modalid="<?php echo $cat_id; ?>">Update</button>
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

<!-- Modals for editing and deleting categories -->
<!-- Replace these modals with your actual modals -->

<!-- Add New Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addCategoryForm">
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Category Name</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName" required>
                    </div>
                    <div class="mb-3">
                        <label for="categoryDescription" class="form-label">Category Description</label>
                        <textarea class="form-control" id="categoryDescription" name="categoryDescription" rows="3"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="addCategoryBtn">Add Category</button>
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

    $(".delete-category").click(function () {
        const categoryId = $(this).data("id");

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
                    url: "partials/delete_category.php",
                    data: { categoryId: categoryId },
                    success: function (response) {
                        if (response) {
                            Swal.fire("Deleted!", "The category has been deleted.", "success").then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire("Error", "An error occurred while deleting the category.", "error");
                        }
                    },
                    error: function (xhr, status, error) {
                        Swal.fire("Error", "An error occurred while deleting the category: " + error, "error");
                    }
                });
            }
        });
    });
    
    
 $(".editCategoryBtn").click(function () {
    var modalId = $(this).data("modalid");
    var modal = $("#editCategoryModal" + modalId);
    var form = modal.find("#editCategoryForm" + modalId);

    $.ajax({
    type: "POST",
    url: "partials/update_category.php",
    data: new FormData(form[0]),
    processData: false,
    contentType: false,
    success: function (response) {
        if (response) {
          
            modal.modal("hide");

            // Update the category name and description within the specific modal
            modal.find("#categoryName").text(form.find("[name=categoryName]").val());
            modal.find("#categoryDescription").text(form.find("[name=categoryDescription]").val());

          Swal.fire("Success", "Category updated successfully", "success").then(function() {
                location.reload(); // Reload the page
            });
        } else {
            Swal.fire("Error", "An error occurred while updating the category.", "error");
        }
    }
});

});




    // Add New Category
    $("#addCategoryBtn").click(function () {
       var modal = $("#addCategoryModal");
    var form = modal.find("#addCategoryForm");
       
  
        $.ajax({
            type: "POST",
            url: "partials/add_category.php",
            data: new FormData(form[0]),
            processData: false,
            contentType: false,
            success: function (response) {
                if (response) {
                     Swal.fire("Success", "Category Added successfully", "success").then(function() {
                location.reload(); // Reload the page
            });
                } else {
                    Swal.fire("Error", "An error occurred while adding the category.", "error");
                }
            },
            error: function (xhr, status, error) {
                Swal.fire("Error", "An error occurred while adding the category: " + error, "error");
            }
        });
    });
});

</script>
</body>
</html>
