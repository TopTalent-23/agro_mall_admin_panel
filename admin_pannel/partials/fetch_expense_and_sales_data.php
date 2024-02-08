<?php
include('../../db_config.php');

$selectedYear = $_GET['selectedYear'];

// Fetch expense data
$expenseQuery = "SELECT date, amount FROM expenses1 WHERE YEAR(date) = $selectedYear";
$expenseResult = $conn->query($expenseQuery);
$expenseData = $expenseResult->fetch_all(MYSQLI_ASSOC);

// Fetch sales data
$salesQuery = " SELECT date_time, amount FROM orders WHERE payment_status = 'complete' AND order_status = 'Delivered' AND YEAR(date_time) = $selectedYear";

$salesResult = $conn->query($salesQuery);
$salesData = $salesResult->fetch_all(MYSQLI_ASSOC);

// Combine expense and sales data
$data = [
    'expenses' => $expenseData,
    'sales' => $salesData
];

echo json_encode($data);

$conn->close();
?>
