<?php
include("../../db_config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userId = $_POST['userId'];
    $newStatus = $_POST['newStatus'];

    // Update user status in the database
    $updateQuery = "UPDATE admin_users SET status = '$newStatus' WHERE id = $userId";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo 'success';
    } else {
        echo 'error';
    }
}
?>
