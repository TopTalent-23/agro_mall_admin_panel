<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
  
  
    // Validate and sanitize input (you may need to enhance this)
    $categoryId = isset($_POST["catId"]) ? intval($_POST["catId"]) : 0;
    $categoryName = isset($_POST["categoryName"]) ? trim($_POST["categoryName"]) : "";
    $categoryDescription = isset($_POST["categoryDescription"]) ? trim($_POST["categoryDescription"]) : "";

    // Database connection (replace with your actual database configuration)
    include("../../db_config.php");

    // Update the category in the database
    $sql = "UPDATE categories SET cat_name = ?, cat_desc = ? WHERE cat_id = ?";
    $stmt = mysqli_prepare($conn, $sql);

    if (!$stmt) {
        echo "Database query error: " . mysqli_error($conn);
        exit();
    }

    mysqli_stmt_bind_param($stmt, "ssi", $categoryName, $categoryDescription, $categoryId);

    if (mysqli_stmt_execute($stmt)) {
    echo "success";
} else {
    echo "Error updating category: " . mysqli_error($conn);
    echo "SQL Error: " . mysqli_stmt_error($stmt);
    echo "SQL Query: " . $sql;
    echo "Category ID: " . $categoryId;
    echo "Category Name: " . $categoryName;
    echo "Category Description: " . $categoryDescription;
}


    mysqli_stmt_close($stmt);
    mysqli_close($conn);
} else {
    echo "Invalid request.";
}
?>
