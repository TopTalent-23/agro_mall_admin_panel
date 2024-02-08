<?php
// Add this code at the top of your PHP file to enable session handling.
session_start();
require'db_config.php';
// Add this code at the bottom of your PHP file, after including the footer.
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["product_id"])) {
  $product_id = $_GET["product_id"];

  // Fetch all reviews for the product from the database
 // Replace with your database credentials
  $sql = "SELECT * FROM reviews WHERE product_id = $product_id ORDER BY review_date DESC";
  $result = mysqli_query($conn, $sql);
  $reviews = array();
  while ($row = mysqli_fetch_assoc($result)) {
    $reviews[] = $row;
  }

  // Return JSON response
  echo json_encode(array("reviews" => $reviews));
  exit;
}
?>
