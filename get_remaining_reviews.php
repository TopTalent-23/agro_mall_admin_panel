<?php
// In your get_remaining_reviews.php file

session_start();
require'db_config.php';
// Check if the connection was successful
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Get the product ID from the query parameters
if (isset($_GET['product_id'])) {
  $product_id = intval($_GET['product_id']);

  // Get the start index for fetching the remaining reviews
  if (isset($_GET['start'])) {
    $start = intval($_GET['start']);
  } else {
    $start = 0;
  }

  // Fetch the remaining reviews from the database
  $sql = "SELECT * FROM reviews WHERE product_id = $product_id LIMIT $start, 10"; // Fetch 10 reviews starting from the $start index
  $result = $conn->query($sql);

  $remaining_reviews = array();
  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      // Assuming you have columns 'user_name', 'review_text', and 'rating' in your reviews table
      $review = array(
        "user_name" => $row["user_name"],
        "review_text" => $row["review_text"],
        "rating" => $row["rating"]
      );
      array_push($remaining_reviews, $review);
    }
    $response = array(
      "reviews" => $remaining_reviews,
      "hasMoreReviews" => true // You can set this to false when there are no more reviews to load
    );
  } else {
    $response = array(
      "reviews" => $remaining_reviews,
      "hasMoreReviews" => false // No more reviews to load
    );
  }

  // Return the JSON response
  header("Content-Type: application/json");
  echo json_encode($response);
} else {
  // If the product ID is not provided in the query parameters, return an empty response
  $response = array(
    "reviews" => array(),
    "hasMoreReviews" => false
  );

  header("Content-Type: application/json");
  echo json_encode($response);
}

$conn->close();
?>
