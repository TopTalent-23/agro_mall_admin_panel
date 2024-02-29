<?php
session_start();
include '../db_config.php';
if (!isset($_SESSION['admin_logedin']) && !isset($_SESSION['manager_logedin']) && !isset($_SESSION['executiveOfficer_logedin']))  {
    // Display an alert using JavaScript
    echo "<script>alert('You do not have access to this page. Please go back.')</script>";
  
    // Redirect the user to the previous page
    echo "<script>window.history.back();</script>";
  
    // Exit the script to prevent further execution
    exit();
  }
date_default_timezone_set('Asia/Kolkata');

// Function to format date
function formatDate($dateString) {
    return date('Y-m-d', strtotime($dateString));
}

// Get the selected delivery boy
$username = isset($_GET['deliveryBoy']) ? $_GET['deliveryBoy'] : '';

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

// Query to fetch delivered orders within the selected date range for the selected delivery boy
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Delivery Updates</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://kit.fontawesome.com/c932d99d51.js" crossorigin="anonymous"></script>
    <style>
/* CSS for row hover effect */
.table-row-hover:hover {
    background-color: blanchedalmond !important; /* Change background color on hover */
}
</style>
</head>
<body>
<?php include("navbar.php"); ?>

<div class="content mt-5">
    <h2>Delivered Orders</h2>

    <div class="m-3">
        <label for="deliveryBoy">Select Delivery Boy:</label>
        <select id="deliveryBoy" class="form-select">
            <option value="">Select</option>
            <?php
            // Fetch delivery boys from the admin users table with role 'deliveryBoy'
            $deliveryBoysQuery = "SELECT * FROM admin_users WHERE role = 'deliveryBoy'";
            $deliveryBoysResult = mysqli_query($conn, $deliveryBoysQuery);

            // Check if there are any delivery boys
            if (mysqli_num_rows($deliveryBoysResult) > 0) {
                // Loop through each delivery boy and create an option for the dropdown
                while ($row = mysqli_fetch_assoc($deliveryBoysResult)) {
                    echo '<option value="' . $row['username'] . '" ' . ($row['username'] == $username ? 'selected' : '') . '>' . $row['username'] . '</option>';
                }
            }
            ?>
        </select>
    </div>

    <div class="m-3">
        <label for="dateFilter">Apply Filter:</label>
        <select id="dateFilter" class="form-select">
            <option value="all" <?php echo ($filter == 'all') ? 'selected' : ''; ?>>All</option>
            <option value="today" <?php echo ($filter == 'today') ? 'selected' : ''; ?>>Today</option>
            <option value="yesterday" <?php echo ($filter == 'yesterday') ? 'selected' : ''; ?>>Yesterday</option>
        </select>
    </div>

    <!-- Display Orders in Table -->
    <table class="table m-3">
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
            echo "<tr class='table-row-hover'>";
            echo "<td>" . $row['orderId'] . "</td>";
            echo "<td>" . $row['paymentMode'] . "</td>";
            echo "<td>" . $row['collectedAmt'] . "</td>";
            echo "<td>" . $row['datetime'] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>


    <!-- Total Number of Orders and Amount -->
    <div><strong>Total Orders: <?php echo $totalOrders; ?></strong></div>
    <div><strong>Total Amount: Rs. <?php echo $totalAmount; ?>/-</strong></div>
</div>

<footer>
    Admin Panel &copy; <?php echo date('Y'); ?> Ahire Agro Mall
</footer>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
<script>
$(document).ready(function () {
    // Change event for the date filter
    $('#dateFilter').change(function () {
        var selectedFilter = $(this).val();
        // Redirect to the same page with the selected filter as a query parameter
        window.location.href = 'delivery_update_orders.php?deliveryBoy=<?php echo $username; ?>&filter=' + selectedFilter;
    });

    // Change event for the delivery boy select
    $('#deliveryBoy').change(function () {
        var selectedDeliveryBoy = $(this).val();
        // Redirect to the same page with the selected delivery boy as a query parameter
        window.location.href = 'delivery_update_orders.php?deliveryBoy=' + selectedDeliveryBoy + '&filter=<?php echo $filter; ?>';
    });
});
</script>
<script>
   $(document).ready(function () {
    $("#sidebarCollapse").on("click", function () {
        $("#sidebar").toggleClass("active");
        $("#content").toggleClass("active");
        $(".custom-navbar").toggleClass("active");
    });

});

</script>
</body>
</html>
