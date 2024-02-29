<?php
session_start();
date_default_timezone_set('Asia/Kolkata');
// Get the product ID from the AJAX request
$productId = $_POST['product_id'];

// Initialize the cart if it doesn't exist
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Add the product to the cart (you can customize this based on your needs)
if (!isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId] = 1;
} else {
    $_SESSION['cart'][$productId]++;
}

// Respond to the AJAX request (you can customize this based on your needs)
echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Product Added",
                    text: "The product has been added to the cart.",
                    timer: 2000, // Set the timer to close the alert after 2 seconds
                    showConfirmButton: false
                });
            </script>';
?>
