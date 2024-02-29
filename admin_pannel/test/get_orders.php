<?php
// get_orders.php

// Replace with your actual database connection code
$dbHost = "localhost";
$dbUsername = "id21908296_root";
$dbPassword = "Mo21nu94@jadhav";
$dbName = "id21908296_ahire_agro_mall";

// Create database connection
$conn = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName);
date_default_timezone_set('Asia/Kolkata');
$sql = "SET time_zone = '+05:30'";
mysqli_query($conn, $sql);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the filter from the AJAX request
$filter = $_POST['filter'];
$statusFilter = $_POST['status_filter'];

// Determine the date range based on the filter
$startDate = null;
$endDate = null;
if ($filter === 'today') {
    $startDate = date('Y-m-d 00:00:00');
    $endDate = date('Y-m-d 23:59:59');
} elseif ($filter === 'yesterday') {
    $startDate = date('Y-m-d 00:00:00', strtotime('yesterday'));
    $endDate = date('Y-m-d 23:59:59', strtotime('yesterday'));
} elseif ($filter === 'last_week') {
    $startDate = date('Y-m-d 00:00:00', strtotime('-1 week'));
    $endDate = date('Y-m-d 23:59:59');
} elseif ($filter === 'last_month') {
    $startDate = date('Y-m-d 00:00:00', strtotime('-1 month'));
    $endDate = date('Y-m-d 23:59:59');
} elseif ($filter === 'custom') {
    $startDate = $_POST['start_date']; // Assuming you pass the start_date via AJAX
    $endDate = $_POST['end_date']; // Assuming you pass the end_date via AJAX

    // Modify the end date to be the next day after the selected end date
    $endDate = date('Y-m-d 23:59:59', strtotime($endDate . ' +1 day'));
}

// Search query from the front-end
$searchQuery = isset($_POST['search']) ? $_POST['search'] : '';

// Pagination settings
$itemsPerPage = 10;
$page = $_POST['page'];
$offset = ($page - 1) * $itemsPerPage;

// Fetch orders with pagination and search filter
$sql = "SELECT o.order_id, p.pr_name, MIN(o.date_time) AS min_date_time, MAX(o.date_time) AS max_date_time,
        o.name, o.quantity, o.address, o.order_status, o.shopVisit, o.pin, o.phone_no, o.payid, o.payment_status, o.payment_mode, o.date_time AS order_date,
        GROUP_CONCAT(DISTINCT p.pr_name ORDER BY p.pr_name ASC SEPARATOR ', ') AS product_names
        FROM orders o
        JOIN products p ON o.product_id = p.sr_no
        WHERE o.date_time >= ? AND o.date_time <= ?";

// Add search filter if provided
if (!empty($searchQuery)) {
    $sql .= " AND (o.order_id LIKE ? OR p.pr_name LIKE ? OR o.name LIKE ? 
                  OR o.address LIKE ? OR o.phone_no LIKE ? OR o.pin LIKE ? 
                  OR o.payment_status LIKE ? OR o.payment_mode LIKE ? 
                  OR DATE(o.date_time) = ? OR o.order_status LIKE ?)";
    $searchQuery = "%$searchQuery%"; // Add wildcard characters for partial matches
}

// Apply status filter if not "All Statuses"
if ($statusFilter !== 'all') {
    $sql .= " AND o.order_status = ?";
}

$sql .= " GROUP BY o.order_id
        ORDER BY max_date_time DESC
        LIMIT ?, ?";
// Prepare and execute the SQL query with bind parameters
$stmt = $conn->prepare($sql);

// Check if the prepared statement is valid
if ($stmt === false) {
    die("Error in prepared statement: " . $conn->error);
}
$bindParams = array();
$paramTypes = '';

// Bind parameters for date range
$bindParams[] = &$startDate;
$bindParams[] = &$endDate;
$paramTypes .= 'ss';

// Add search filter if provided
if (!empty($searchQuery)) {
    for ($i = 1; $i <= 10; $i++) {
        $bindParams[] = &$searchQuery;
        $paramTypes .= 's';
    }
}

// Apply status filter if not "All Statuses"
if ($statusFilter !== 'all') {
    $bindParams[] = &$statusFilter;
    $paramTypes .= 's';
}

// Add parameter types for pagination
$bindParams[] = &$offset;
$bindParams[] = &$itemsPerPage;
$paramTypes .= 'ii';

// Prepare and execute the SQL query with bind parameters
$stmt->bind_param($paramTypes, ...$bindParams);

$stmt->execute();
$result = $stmt->get_result();
$i=0;
// Display the orders in a searchable table with pagination
if ($result->num_rows > 0) {
    echo '<div id="status-alerts"></div><table class="table table-striped">';
    echo '<thead><tr><th>Sr.no</th><th>Order ID</th><th>Order Status</th><th>Cust Name</th><th>Payment</th><th>Address</th><th>Date</th><th></th></tr></thead>';
    echo '<tbody id="orders-table-body">';

    $uniqueOrders = array();

    while ($row = $result->fetch_assoc()) {
        $orderId = $row['order_id'];

        // Check if the order ID is already displayed
        if (!isset($uniqueOrders[$orderId])) {
            $uniqueOrders[$orderId] = true;

            echo '<tr>';
            echo '<td style="width: 50px;">' . ++$i . '</td>';
            echo '<td>' . $orderId . '</td>';
            echo '<td><div id="status-container-' . $orderId . '">' . $row['order_status'] . '</div></td>';

            echo '<td>' . $row['name'] . '</td>';
            echo '<td class="payment-status-container-'.$orderId.'">' . $row['payment_status'] . '</td>';
            echo '<td>' . $row['address'] . '</td>';
            echo '<td>' . $row['order_date'] . '</td>';
            echo '<td><a class="btn btn-success" data-bs-toggle="collapse" href="#collapseExample' . $i . '" role="button" aria-expanded="false" aria-controls="collapseExample1">View</a></td>';
            echo '</tr>';
            echo '</tbody>';
            echo '</table>';
            echo '<tr>';
            echo '<td colspan="8" class="p-0">';
            echo '<div class="collapse" id="collapseExample' . $i . '">';
            echo '<div class="card card-body">';

            // Query to get all products associated with the order
            $productsQuery = "SELECT o.*, p.* FROM orders o
         LEFT JOIN products p ON o.product_id = p.sr_no
         WHERE o.order_id = '$orderId'";
            $productsResult = $conn->query($productsQuery);
            $totalAmount = 0;

            if ($productsResult->num_rows > 0) {
                echo '<div class="row">';
                echo '<div class="col-md-12"><strong>Products</strong></div>';
                echo '</div>';
                echo '<table class="table table-bordered">';
                echo '<thead><tr><th>Product Name</th><th>Quantity</th><th>Amount</th></tr></thead>';
                echo '<tbody>';

                while ($productRow = $productsResult->fetch_assoc()) {
                    $product = $productRow['pr_name'];

                    // Accumulate the total amount
                    echo '<tr>';
                    echo '<td>' . $product . '</td>';
                    echo '<td>' . $productRow['quantity'] . '</td>';
                    echo '<td>Rs.' . $productRow['amount'] . '/-</td>';
                    echo '</tr>';
                    $totalAmount += $productRow['amount'];
                }

                echo '</tbody>';
                echo '</table>';
                // Display the total amount
                echo '<div class="row">';
                echo '<div class="col-md-5"><strong>Total Amount</strong></div>';
                echo '<div class="col-md-1"><strong>:</strong></div>';
                echo '<div class="col-md-6">Rs.' . $totalAmount . '/-</div>';
                echo '</div>';
            }

            echo '<div class="row">';
            echo '<div class="col-md-5"><strong>Pin</strong></div>';
            echo '<div class="col-md-1"><strong>:</strong></div>';
            echo '<div class="col-md-6">' . $row['pin'] . '</div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<div class="col-md-5"><strong>Phone Number</strong></div>';
            echo '<div class="col-md-1"><strong>:</strong></div>';
            echo '<div class="col-md-6">' . $row['phone_no'] . '</div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<div class="col-md-5"><strong>Payment Id</strong></div>';
            echo '<div class="col-md-1"><strong>:</strong></div>';
            echo '<div class="col-md-6">' . $row['payid'] . '</div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<div class="col-md-5"><strong>Payment Status</strong></div>';
            echo '<div class="col-md-1"><strong>:</strong></div>';
            echo '<div class="col-md-6 payment-status-container-'.$orderId.'">' . $row['payment_status'] . '</div>';
            echo '</div>';
            echo '<div class="row">';
            echo '<div class="col-md-5"><strong>Payment Mode</strong></div>';
            echo '<div class="col-md-1"><strong>:</strong></div>';
            echo '<div class="col-md-6 payment-mode-container-'.$orderId.'">' . $row['payment_mode'] . '</div>';
            echo '</div>';

            if (isset($row['shopVisit'])) {
                echo '<div class="row">';
                echo '<div class="col-md-5"><strong>Shop Visit</strong></div>';
                echo '<div class="col-md-1"><strong>:</strong></div>';
                echo '<div class="col-md-6">' . ($row['shopVisit'] ? 'True' : 'False') . '</div>';
                echo '</div>';
            }
            if ($row['payment_status'] == 'pending') {
                echo '<div class="row mt-2">';
echo '<div class="col-md-5"><strong>Update Payment Status</strong></div>';
echo '<div class="col-md-1"><strong>:</strong></div>';
echo '<div class="col-md-6">';
echo '<button class="btn btn-success" data-action="update-payment-status" data-order-id="' . $orderId . '">Complete</button>';

echo '</div>';
echo '</div>';
            }
            echo '<div class="row mt-2">';
echo '<div class="col-md-5"><strong>View bill</strong></div>';
echo '<div class="col-md-1"><strong>:</strong></div>';
echo '<div class="col-md-6">';
echo '<a href="partials/invoice.php?orderID='.$orderId.'" class="btn btn-success" >View Bill</a>';

echo '</div>';
echo '</div>';
            
            echo '<p ><strong> Status :  </strong><span style="font-style: italic; font-weight: normal; color: red;  margin-bottom: 3px;">Note: The status is not reversible for orders in transit, out for delivery, and delivered. So <strong>  Do it Carefully !</strong></span></p>';
            echo '<div class="btn-group" role="group" aria-label="Delivery Status">';

            $statusOptions = array("cancelled", "confirmed", "placed", "in_transit", "out_for_delivery", "delivered");
            foreach ($statusOptions as $option) {
                $isActive = isset($row['order_status']) && $row['order_status'] === $option ? 'active' : ''; ?>
                <label class="btn btn-outline-primary status-label <?php echo $isActive; ?>"
                       data-order-id="<?php echo $orderId; ?>"
                       data-new-status="<?php echo $option; ?>"
                       for="status_<?php echo $orderId . '_' . $option; ?>">
                    <?php echo ucwords(str_replace("_", " ", $option)); ?>
                </label>
            <?php
            }
            
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</td>';
            echo '</tr>';
          
           
        }
    }
    echo '</tbody>';
    echo '</table>';
} else {
    echo '<table class="table table-striped">';
    echo '<thead><tr><th>Order ID</th><th>Order Status</th><th>Product Name</th><th>Qty</th><th>Cust Name</th><th>Address</th><th>Pin</th><th>Phone</th><th>Pay Status</th><th>ModeOfPayment</th><th>Amount</th><th>Date</th></tr></thead>';
    echo '<tbody>';
    echo '<tr>';
    echo '<td colspan="12">No orders found.</td>';
    echo '</tr>';
    echo '</tbody>';
    echo '</table>';
}

// Pagination links
$sqlCount = "SELECT COUNT(DISTINCT o.order_id) AS total FROM orders o
            JOIN products p ON o.product_id = p.sr_no
            WHERE o.date_time >= ? AND o.date_time <= ?";

$bindParamsCount = array('ss', $startDate, $endDate);

// Add search filter if provided
if (!empty($searchQuery)) {
    $sqlCount .= " AND (o.order_id LIKE ? OR p.pr_name LIKE ? OR o.name LIKE ?)";
    $searchQuery = "%$searchQuery%"; // Add wildcard characters for partial matches
    $bindParamsCount[0] .= 'sss'; // Add parameter types for search query
    $bindParamsCount[] = $searchQuery;
    $bindParamsCount[] = $searchQuery;
    $bindParamsCount[] = $searchQuery;
}

// Apply status filter if not "All Statuses"
if ($statusFilter !== 'all') {
    $sqlCount .= " AND o.order_status = ?";
    $bindParamsCount[0] .= 's'; // Add parameter type for status filter
    $bindParamsCount[] = $statusFilter;
}

$stmtCount = $conn->prepare($sqlCount);

// Check if the prepared statement is valid
if ($stmtCount === false) {
    die("Error in prepared statement: " . $conn->error);
}

// Dynamically bind the parameters for count query using call_user_func_array()
if (!empty($bindParamsCount)) {
    $paramTypesCount = $bindParamsCount[0]; // Get the parameter types string
    $bindParamsCount = array_slice($bindParamsCount, 1); // Remove the parameter types string from the array
    $stmtCount->bind_param($paramTypesCount, ...$bindParamsCount); // Bind the parameters using spread operator
}

$stmtCount->execute();
$resultCount = $stmtCount->get_result();
$row = $resultCount->fetch_assoc();
$totalItems = $row['total'];
echo '<tr ><td  colspan="4"><strong>Total Orders : </strong>'.$totalItems.'</td>';
$totalPages = ceil($totalItems / $itemsPerPage);

// ...
echo '';
    echo '<td  >
    <nav aria-label="Page navigation">';
    echo '<ul class="pagination">';
    for ($i = 1; $i <= $totalPages; $i++) {
        echo '<li class="page-item';
        if ($i == $page) {
            echo ' active';
        }
        echo '"><a class="page-link pagination-link" data-page="' . $i . '">' . $i . '</a></li>';
    }
    echo '</ul>';
    echo '</nav></td></tr>';

$stmt->close();

$conn->close();
?>
