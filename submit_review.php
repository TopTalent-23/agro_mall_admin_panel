<?php
// Add this code at the top of your PHP file to enable session handling.
session_start();
require 'db_config.php';

// Add this code at the bottom of your PHP file, after including the footer.
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["review_text"]) && isset($_POST["user_rating"]) && isset($_POST["product_id"])) {
  $review_text = $_POST["review_text"];
  $user_rating = $_POST["user_rating"]; // Use "user_rating" instead of "rating"
  $product_id = $_POST["product_id"];
  $user_id = $_SESSION["id"]; // Assuming you have the user's ID stored in the session.

  // Fetch the user name from the 'customers' table based on the user ID
  $sql1 = "SELECT * FROM `customers` WHERE `sr_no` = '$user_id'";
  $result1 = mysqli_query($conn, $sql1);
  if ($result1 && mysqli_num_rows($result1) > 0) {
    $row1 = mysqli_fetch_assoc($result1);
    $user_name = $row1['cust_name'];
    
    // Insert the review into the database
    $sql = "INSERT INTO reviews (product_id, user_id, rating, review_text, user_name, review_date) VALUES ($product_id, $user_id, $user_rating, '$review_text', '$user_name', NOW())";
    if (mysqli_query($conn, $sql)) {
      // Return JSON response for success
      echo json_encode(array("success" => true));
      exit;
    } else {
      // Return JSON response for failure
      echo json_encode(array("success" => false));
      exit;
    }
  }
}
?>
