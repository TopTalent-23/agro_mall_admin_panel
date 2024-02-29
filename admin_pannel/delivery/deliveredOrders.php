<?php
session_start();
include '../../db_config.php';
if (!isset($_SESSION['deliveryBoy_logedin']) && !isset($_SESSION['admin_logedin'])) {
    session_destroy();
    header("Location: ../partials/admin_login.php");
    exit();
}
date_default_timezone_set('Asia/Kolkata');
// Function to format date
function formatDate($dateString) {
    return date('Y-m-d', strtotime($dateString));
}

// Get the username from the session
$username = $_SESSION['admin_username'];

// Get the selected date filter (today, yesterday, all)
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';

// Set the date range based on the selected filter
if ($filter == 'today') {
    $startDate = formatDate('today');
    $endDate = formatDate('today');
} elseif ($filter == 'yesterday') {
    $startDate = formatDate('yesterday');
    $endDate = formatDate('yesterday');
} else {
    $startDate = '1970-01-01'; // A date in the past
    $endDate = date('Y-m-d'); // Current date
}

// Format the start and end dates in the correct format
$startDateFormatted = $startDate . ' 00:00:00';
$endDateFormatted = $endDate . ' 23:59:59';

// Query to fetch delivered orders within the selected date range
$query = "SELECT * FROM delivery WHERE username = '$username' AND datetime BETWEEN '$startDateFormatted' AND '$endDateFormatted'";
$result = mysqli_query($conn, $query);

// Fetch total number of orders and total amount
$totalOrdersQuery = "SELECT COUNT(*) AS totalOrders, SUM(collectedAmt) AS totalAmount FROM delivery WHERE username = '$username' AND datetime BETWEEN '$startDateFormatted' AND '$endDateFormatted'";
$totalOrdersResult = mysqli_query($conn, $totalOrdersQuery);
$totalOrdersData = mysqli_fetch_assoc($totalOrdersResult);
$totalOrders = $totalOrdersData['totalOrders'];
$totalAmount = $totalOrdersData['totalAmount'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delivery Boy Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="path/to/your/style.css"> <!-- Add the path to your custom style if needed -->
</head>
<style>
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}
footer {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 20px 0;
    
    bottom: 0;
    width: 100%;
    
}


.content {
    padding: 16px;
}

select {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
}


/* button {
    background-color: #4CAF50;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

button:hover {
    background-color: #45a049;
} */

@media only screen and (max-width: 600px) {
    .content {
        padding: 10px;
    }

    select,
    button {
        width: 100%;
    }
}

</style>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
  <a class="navbar-brand" href="#">
      <img src="../../logo.png"  width="40" height="34"><strong><?php echo "Welcome, ". $_SESSION['admin_username'];?></strong>
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="deliveryBoy.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="deliveredOrders.php">Delivered Orders</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="logout.php">Logout</a>
        </li>
       
      </ul>
    </div>
  </div>
</nav>





<div class="card m-2">
<div class="content">
    <h2>Delivered Orders</h2>

    <!-- Date Filter -->
    <select id="dateFilter" class="form-select">
        <option value="all" <?php echo ($filter == 'all') ? 'selected' : ''; ?>>All</option>
        <option value="today" <?php echo ($filter == 'today') ? 'selected' : ''; ?>>Today</option>
        <option value="yesterday" <?php echo ($filter == 'yesterday') ? 'selected' : ''; ?>>Yesterday</option>
    </select>
    <div class="table-responsive">
    <!-- Display Orders in Table -->
    <table class="table">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Payment Mode</th>
                <th>Collected Amount</th>
                <th>Date and Time</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>";
                echo "<td>" . $row['orderId'] . "</td>";
                echo "<td>" . $row['paymentMode'] . "</td>";
                echo "<td>" . $row['collectedAmt'] . "</td>";
                echo "<td>" . $row['datetime'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
        <div><strong>Total Orders: <?php echo $totalOrders; ?></strong></div>
    <div class=""><strong>Total Amount: Rs. <?php echo $totalAmount; ?>/-</strong></div>
    </table>

    <!-- Total Number of Orders and Amount -->
   
</div>
</div>
</div>







<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script>
   $(document).ready(function () {
            // Change event for the date filter
            $('#dateFilter').change(function () {
                var selectedFilter = $(this).val();
                // Redirect to the same page with the selected filter as a query parameter
                window.location.href = 'deliveredOrders.php?filter=' + selectedFilter;
            });
        });
        </script>
<footer>
    Admin Panel &copy; <?php echo date('Y'); ?> Ahire Agro Mall
  </footer>

</body>

</html>
