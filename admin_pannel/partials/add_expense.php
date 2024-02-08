<?php
// Add your database connection code here
include("../../db_config.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the form
    $amount = $_POST["amount"];
    $description = $_POST["description"];
    $date = $_POST["date"];

    // Insert the data into the 'expenses' table
    $insertQuery = "INSERT INTO expenses1 (amount, description, date) VALUES ('$amount', '$description', '$date')";
    $result = mysqli_query($conn, $insertQuery);

    if ($result) {
        echo "Expense added successfully!";
    } else {
        echo "Error adding expense: " . mysqli_error($conn);
    }
} else {
    echo "Invalid request method!";
}
?>
