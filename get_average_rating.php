<?php
// Add this code at the top of your PHP file to enable session handling.
session_start();
require'db_config.php';
// Add this code at the bottom of your PHP file, after including the footer.
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["product_id"])) {
  $product_id = $_GET["product_id"];

  // Fetch the average rating from the database
   // Replace with your database credentials
  $sql = "SELECT AVG(rating) AS avg_rating FROM reviews WHERE product_id = $product_id";
  $result = mysqli_query($conn, $sql);
  $row = mysqli_fetch_assoc($result);
  $average_rating = round($row['avg_rating'], 1);

  // Return JSON response
  echo json_encode(array("averageRating" => $average_rating));
  exit;
}
?>
