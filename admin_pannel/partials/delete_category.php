<?php
include("../../db_config.php");

if (isset($_POST['categoryId'])) {
    $categoryId = $_POST['categoryId'];

    // Delete category from the database
    $deleteQuery = "DELETE FROM `categories` WHERE `cat_id` = '$categoryId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
