<?php
// update_image.php

include('../../db_config.php'); // Include your database connection file

$response = array();

if (isset($_POST['id']) && isset($_FILES['file'])) {
    $id = $_POST['id'];

    $file_name = $_FILES['file']['name'];
    $file_tmp = $_FILES['file']['tmp_name'];
    $file_error = $_FILES['file']['error'];

    // Check for upload errors
    if ($file_error !== UPLOAD_ERR_OK) {
        $response['success'] = false;
        $response['message'] = 'File upload failed with error code: ' . $file_error;
    } else {
        // Read the image content
        $image_content = file_get_contents($file_tmp);
        if ($image_content === false) {
            $response['success'] = false;
            $response['message'] = 'Failed to read file content';
        } else {
            // Escape the image content to prevent SQL injection
            $image_content = mysqli_real_escape_string($conn, $image_content);

            // Update the image in the database
            $update_sql = "UPDATE product_images SET image_content = '$image_content' WHERE id = $id";
            if (mysqli_query($conn, $update_sql)) {
                $response['success'] = true;
                $response['message'] = 'Image Updated!';
            } else {
                $response['success'] = false;
                $response['message'] = 'Image update failed: ' . mysqli_error($conn);
            }
        }
    }
} else {
    $response['success'] = false;
    $response['message'] = 'Invalid request';
}

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
