<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['pr_id'] != null && $_POST['pr_name'] != null) {
    include("../../db_config.php");

    // Process and validate the form data here
    $pr_id = $_POST['pr_id'];
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

    // Update product information in the database
    $updateQuery = "UPDATE `products` SET `cat_id`='$cat_id', `pr_name`='$name', `seed_type`='$seed_type', 
                    `net_wt`='$net_wt', `width`='$width', `breadth`='$breadth', `pr_state`='$pr_state', 
                    `pr_manufacturer`='$manufacturer', `pr_desc`='$desc', `main_price`='$main_price', 
                    `discounted_price`='$dis_price', `wholesale_price`='$wholesale_price'
                    WHERE `sr_no`='$pr_id'";

    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        // Loop through the uploaded images and update them in the product_images table
        foreach ($imageContents as $index => $imgContent) {
            $imgOrder = $index + 1; // Set the image order (1-based)
            $imgInsertQuery = "INSERT INTO `product_images` (`product_id`, `image_order`, `image_content`) 
                               VALUES ('$pr_id', '$imgOrder', ?)";

            // Use prepared statement for image update
            $stmt = mysqli_prepare($conn, $imgInsertQuery);
            mysqli_stmt_bind_param($stmt, "s", $imgContent);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        // Success message or further actions
        $response = 'Product updated successfully with ID: ' . $pr_id;
    } else {
        // Display error message
        $response = 'Error updating product: ' . mysqli_error($conn);
    }

    // Return a response
    echo $response;
} else {
    $response = 'Please fill input fields';
    echo $response;
}
?>
