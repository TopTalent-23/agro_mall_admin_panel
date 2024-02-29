<?php
session_start();
include("../../db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = mysqli_real_escape_string($conn, $_POST['userId']);

    $deleteQuery = "DELETE FROM admin_users WHERE id='$userId'";

    if (mysqli_query($conn, $deleteQuery)) {
        echo json_encode(array("status" => "success"));
    } else {
        echo json_encode(array("status" => "error", "message" => "Failed to delete user."));
    }
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid request method."));
}
?>
