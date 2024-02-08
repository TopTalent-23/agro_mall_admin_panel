<?php
// Add your database connection code here
include("../../db_config.php");

// Fetch all expenses from the 'expenses' table
$fetchQuery = "SELECT * FROM `expenses1` ORDER BY date ASC";
$result = mysqli_query($conn, $fetchQuery);

if ($result) {
    // Display expenses in a table
    echo '<table class="table table-bordered">';
    echo '<thead><tr><th>ID</th><th>Amount</th><th>Description</th><th>Date</th></tr></thead>';
    echo '<tbody>';

    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr>';
        echo '<td>' . $row['id'] . '</td>';
        echo '<td>' . $row['amount'] . '</td>';
        echo '<td>' . $row['description'] . '</td>';
        echo '<td>' . $row['date'] . '</td>';
        echo '</tr>';
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo "Error fetching expenses: " . mysqli_error($conn);
}
?>
