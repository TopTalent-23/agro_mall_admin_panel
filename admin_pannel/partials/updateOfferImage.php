<?php
// update_image.php

include('../../db_config.php'); // Include your database connection file

if (isset($_POST['id']) && isset($_FILES['file'])) {
  $id = $_POST['id'];

  $file_name = $_FILES['file']['name'];
  $file_tmp = $_FILES['file']['tmp_name'];

  $image_content = file_get_contents($file_tmp);
  $image_content = mysqli_real_escape_string($conn, $image_content);

  $update_sql = "UPDATE offers1 SET image = '$image_content' WHERE id = $id";

  if (mysqli_query($conn, $update_sql)) {
    echo json_encode(['success' => true]);
  } else {
    echo json_encode(['success' => false]);
  }
} else {
  echo json_encode(['success' => false]);
}
?>
