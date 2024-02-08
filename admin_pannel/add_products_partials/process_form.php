<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['pr_name'] != null &&
$_FILES['images'] != null && !empty($_FILES['images']['name'][0])) {
    include("../../db_config.php");
    
    // Process and validate the form data here
       $cat_id = $_POST['cat_id'];
    $name = $_POST['pr_name'];
    $seed_type = $_POST['seed_type'];
    $net_wt = $_POST['net_wt'];
    $width = $_POST['width'];
    $breadth = $_POST['breadth'];
    $pr_state = $_POST['pr_state'];
    $manufacturer = $_POST['pr_manufacturer'];
    $desc = $_POST['pr_desc'];
    $main_price = $_POST['main_price'];
    $dis_price = $_POST['discounted_price'];
    $wholesale_price = $_POST['wholesale_price'];
    // ...

    // Check if any images were uploaded
    if (isset($_FILES['images']) && !empty($_FILES['images']['name'][0])) {
        $imageContents = array();

        // Loop through each uploaded image
        foreach ($_FILES['images']['tmp_name'] as $tmpName) {
            // Read the image content
            $imageContent = file_get_contents($tmpName);
            // Add the image content to the array
            $imageContents[] = $imageContent;
        }
    }

    // Simulate processing delay
    sleep(2);

    // Insert product information into the database
    $sql = "INSERT INTO `products` (`cat_id`, `pr_name`, `seed_type`, `net_wt`,
    `width`, `breadth`, `pr_state`, `pr_manufacturer`, `pr_desc`, `main_price`,
    `discounted_price`, `wholesale_price`) 
        VALUES ('$cat_id', '$name', '$seed_type', '$net_wt', '$width',
        '$breadth', '$pr_state', '$manufacturer', '$desc', '$main_price',
        '$dis_price', '$wholesale_price')";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        $product_id = mysqli_insert_id($conn); // Get the auto-generated product ID

        // Loop through the uploaded images and insert them into the product_images table
        foreach ($imageContents as $index => $imgContent) {
            $imgOrder = $index + 1; // Set the image order (1-based)
            $imgInsertQuery = "INSERT INTO `product_images` (`product_id`, `image_order`, `image_content`) 
                               VALUES ('$product_id', '$imgOrder', ?)";

            // Use prepared statement for image insertion
            $stmt = mysqli_prepare($conn, $imgInsertQuery);
            mysqli_stmt_bind_param($stmt, "s", $imgContent);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        // Success message or further actions
        $response = 'Product added successfully with ID: ' . $product_id;

    } else {
        // Display error message
        $response = 'Error adding product: ' . mysqli_error($conn);
    }

    // Return a response
    echo $response;
} else {
    $response = 'Please fill inputs fields';
}
?>
