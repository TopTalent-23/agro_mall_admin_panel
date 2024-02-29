<?php
// delete_image.php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['image_id'])) {
    include("../../db_config.php");

    $imageId = $_POST['image_id'];

    // Perform the deletion operation in the database
    $deleteQuery = "DELETE FROM shop_gallery_images WHERE id = $imageId";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false]);
    }

    mysqli_close($conn);
} else {
    echo json_encode(['success' => false]);
}
?>
