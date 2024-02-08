<?php
include('../../db_config.php');

// ... (your existing code)

header('Content-Type: application/json'); // Add this line to set JSON content type

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $categoryId = $_POST['categoryId'];
    // Debugging information
    error_log("Received categoryId: " . $categoryId);

    $getProducts = "SELECT * FROM `products` WHERE `cat_id` = $categoryId";
    $resultProducts = mysqli_query($conn, $getProducts);

    if (!$resultProducts) {
        die('Error: ' . mysqli_error($conn));
    }

    $productsData = array();

    while ($rowProduct = mysqli_fetch_assoc($resultProducts)) {
        $productsData[] = $rowProduct;
    }

    // Debugging information
    error_log("Products data: " . print_r($productsData, true));

    echo json_encode($productsData);

    mysqli_close($conn);
}
?>

