<?php
session_start();
if (!$_SESSION['admin_logedin']) {
  header("Location: partials/admin_login.php");
  exit; // Stop further execution
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  include("../../db_config.php");

  // Get category name and description from the form
  $categoryName = $_POST['categoryName'];
  $categoryDescription = $_POST['categoryDescription'];

  // Validate and sanitize inputs if needed

  // Insert new category into the database
  $insertQuery = "INSERT INTO categories (cat_name, cat_desc) VALUES ('$categoryName', '$categoryDescription')";
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
