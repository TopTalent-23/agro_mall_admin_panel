<?php
session_start();
if (!$_SESSION['admin_logedin']) {
  header("Location: partials/admin_login.php");
  exit; // Stop further execution
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include("../../db_config.php");

  // Get category name and description from the form
  $offerName = $_POST['offerName'];
  $offerDescription = $_POST['offerDescription'];
  $offerDiscount = $_POST['offerDiscount'];
  $offerStartdate = $_POST['offerStartdate'];
  $offerEnddate = $_POST['offerEnddate'];

  $file_name = $_FILES['offerImage']['name'];
  $file_tmp = $_FILES['offerImage']['tmp_name'];

  $image_content = file_get_contents($file_tmp);
  $image_content = mysqli_real_escape_string($conn, $image_content);

  // Validate and sanitize inputs if needed

  // Insert new category into the database
  $insertQuery = "INSERT INTO offers1 (title, description, discount, startdate, enddate, image) VALUES ('$offerName', '$offerDescription', '$offerDiscount', '$offerStartdate', '$offerEnddate', '$image_content' )";
  $result = mysqli_query($conn, $insertQuery);

  if ($result) {
    echo "success";
  } else {
    echo "error";
  }

  // Close the database connection
  mysqli_close($conn);
} else {
  echo "Invalid request.";
}
?>
