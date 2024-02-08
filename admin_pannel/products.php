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


$show = "SELECT * FROM `products`";
          $result = mysqli_query($conn, $show);
          $num = mysqli_num_rows($result);
          
?>

<?php


// Set the number of products per page
$productsPerPage = 10;

// Get the current page number from the URL
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting product index for the current page
$start = ($page - 1) * $productsPerPage;

// Fetch products for the current page
if (isset($_GET['search'])) {
    // If search parameter is provided, modify the query to include a search condition
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $show = "SELECT p.*, c.cat_name FROM `products` p
            LEFT JOIN `categories` c ON p.cat_id = c.cat_id
            WHERE 
            CONCAT(p.`pr_manufacturer`, ' ',p.`pr_state`, ' ',p.`seed_type`, ' ',p.`sr_no`, ' ',p.`pr_name`, ' ', p.`discounted_price`, ' ',p.`wholesale_price`,  ' ', c.`cat_name`) LIKE '%$search%'
            LIMIT $start, $productsPerPage";
} else {
    $show = "SELECT p.*, c.cat_name FROM `products` p
            LEFT JOIN `categories` c ON p.cat_id = c.cat_id
            LIMIT $start, $productsPerPage";
}

$result = mysqli_query($conn, $show);

// Fetch the total number of products
$totalProducts = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `products`"));

// Calculate the total number of pages
$totalPages = ceil($totalProducts / $productsPerPage);
?>

<section class="veg_section layout_paddingn mt-4">
<div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="text-left">Products</h2>
        <div class="input-group w-50">
            <form action="products.php" method="GET" class="d-flex align-items-center">
                <input type="text" class="form-control rounded-pill mr-2" name="search" placeholder="Search Product">
                <div class="input-group-append">
                    <button class="btn btn-primary rounded-pill" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

<table class="table mt-3">
    <thead>
        <tr>
            <th>Product ID</th>
            <th>Product Name</th>
            <th>Price</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <!-- Loop through products and populate the table rows -->
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td>' . $row['sr_no'] . '</td>';
            echo '<td>' . $row['pr_name'] . '</td>';
            echo '<td>Rs. ' . $row['discounted_price'] . '</td>';
            echo '<td>' . substr($row['pr_desc'], 0, 10) . '...</td>';
            echo '<td>
            <a href="edit_product.php?category='.$row['cat_id'].'&&product='.$row['sr_no'].'" class="btn btn-sm btn-info edit-product"><b>Edit</b></a>
            <a href="../product_detail.php?category='.$row['cat_id'].'&&product='.$row['sr_no'].'" class="btn btn-success  justify-content-center"><b>View Product</b></a>
            <button class="btn btn-sm btn-danger delete-product" data-id="' . $row['sr_no'] . '"><b>Delete</b></button>

                </td>';
            echo '</tr>';
        }
        ?>
    </tbody>
</table>



</section>
<section class="veg_section layout_paddingn mt-4">
    <!-- Your existing table code -->

    <!-- Pagination links -->
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $totalPages; $i++) : ?>
            <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</section>
<?php

// Set the number of products per page
$productsPerPage = 10;

// Get the current page number from the URL
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

// Calculate the starting product index for the current page
$start = ($page - 1) * $productsPerPage;

// Fetch products for the current page
$show = "SELECT * FROM `products` LIMIT $start, $productsPerPage";
$result = mysqli_query($conn, $show);

// Fetch the total number of products
$totalProducts = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM `products`"));

// Calculate the total number of pages
$totalPages = ceil($totalProducts / $productsPerPage);
?>

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
   


        $(".delete-product").on("click", function () {
            var productId = $(this).data("id");

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
                    // User confirmed, send AJAX request to delete product
                    $.ajax({
                        url: 'partials/delete_product.php', // Replace with your PHP file handling deletion
                        type: 'POST',
                        data: { productId: productId },
                        success: function (response) {
                            // Handle the response, e.g., show success message
                            if (response) {
                                Swal.fire('Deleted!', 'Product has been deleted.', 'success').then(function () {
                                    location.reload(); // Reload the page after deletion
                                });
                            } else {
                                Swal.fire('Error!', 'Failed to delete product.', 'error');
                            }
                        },
                        error: function () {
                            Swal.fire('Error!', 'Failed to delete product. Please try again.', 'error');
                        }
                    });
                }
            });
        });
    });

</script>
</body>
</html>
