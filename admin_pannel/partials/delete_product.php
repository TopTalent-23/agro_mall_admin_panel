<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['productId'])) {
    include("../../db_config.php");

    $productId = $_POST['productId'];

    // Delete from product_images table
    $deleteImagesQuery = "DELETE FROM `product_images` WHERE `product_id`='$productId'";
    mysqli_query($conn, $deleteImagesQuery);

    // Delete from products table
    $deleteProductQuery = "DELETE FROM `products` WHERE `sr_no`='$productId'";
    $result = mysqli_query($conn, $deleteProductQuery);

    if ($result) {
        echo true; // Success
    } else {
        echo false; // Failure
    }
} else {
    echo false; // Invalid request
}
?>
