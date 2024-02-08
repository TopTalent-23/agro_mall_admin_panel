<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  
  
  // Validate and sanitize input
$offerId = isset($_POST["offerId"]) ? intval($_POST["offerId"]) : 0;
$offerName = isset($_POST["offerName"]) ? trim($_POST["offerName"]) : "";
$offerDiscount = isset($_POST["offerDiscount"]) ? trim($_POST["offerDiscount"]) : "";
$offerStartdate = isset($_POST["offerStartdate"]) ? trim($_POST["offerStartdate"]) : "";
$offerEnddate = isset($_POST["offerEnddate"]) ? trim($_POST["offerEnddate"]) : "";
$offerDescription = isset($_POST["offerDescription"]) ? trim($_POST["offerDescription"]) : "";

// Database connection (replace with your actual database configuration)
include("../../db_config.php");

// Update the offer in the database
$sql = "UPDATE offers1 
        SET title = ?, 
            description = ?, 
            discount = ?, 
            startdate = ?, 
            enddate = ?
        WHERE id = ?";

$stmt = $conn->prepare($sql);

// Check if the statement was prepared successfully
if ($stmt) {
    // Bind parameters
    $stmt->bind_param("sssssi", $offerName, $offerDescription, $offerDiscount, $offerStartdate, $offerEnddate, $offerId);

    // Execute the statement
    if ($stmt->execute()) {
        echo "Offer updated successfully.";
    } else {
        echo "Error updating offer: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
}

// Close the database connection
$conn->close();

} else {
    echo "Invalid request.";
}
?>
