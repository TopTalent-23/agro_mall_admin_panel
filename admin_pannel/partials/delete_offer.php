<?php
include("../../db_config.php");

if (isset($_POST['offerId'])) {
    $offerId = $_POST['offerId'];

    // Delete category from the database
    $deleteQuery = "DELETE FROM `offers` WHERE `id` = '$offerId'";
    $deleteResult = mysqli_query($conn, $deleteQuery);

    if ($deleteResult) {
        echo "success";
    } else {
        echo "error";
    }
}
?>
