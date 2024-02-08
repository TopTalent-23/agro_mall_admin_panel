<?php
// get_orders.php

// Replace with your actual database connection code
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "aahire_agro_mall";

$conn = new mysqli($servername, $username, $password, $dbname);

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
$itemsPerPage = 5;
$page = $_POST['page'];
$offset = ($page - 1) * $itemsPerPage;

// Fetch orders with pagination and search filter
$sql = "SELECT o.*, p.pr_name FROM orders o
        JOIN products p ON o.product_id = p.sr_no
        WHERE o.date_time >= ? AND o.date_time <= ?";
$bindParams = array('ss', $startDate, $endDate);

// Add search filter if provided
if (!empty($searchQuery)) {
    $sql .= " AND (o.order_id LIKE ? OR p.pr_name LIKE ? OR o.name LIKE ? 
                  OR o.address LIKE ? OR o.phone_no LIKE ? OR o.pin LIKE ? 
                  OR o.payment_status LIKE ? OR o.payment_mode LIKE ? 
                  OR DATE(o.date_time) = ? OR o.order_status LIKE ?)";
    $searchQuery = "%$searchQuery%"; // Add wildcard characters for partial matches
    $bindParams[0] .= 'ssssssssss'; // Add parameter types for search query
    $bindParams[] = $searchQuery;
    $bindParams[] = $searchQuery;
    $bindParams[] = $searchQuery;
    $bindParams[] = $searchQuery;
    $bindParams[] = $searchQuery;
    $bindParams[] = $searchQuery;
    $bindParams[] = $searchQuery;
    $bindParams[] = $searchQuery;
    $bindParams[] = $searchQuery;
    $bindParams[] = $searchQuery;
}
// Apply status filter if not "All Statuses"
if ($statusFilter !== 'all') {
    $sql .= " AND o.order_status = ?";
    $bindParams[0] .= 's'; // Add parameter type for status filter
    $bindParams[] = $statusFilter;
}
$sql .= " ORDER BY o.date_time DESC LIMIT ?, ?";
$bindParams[0] .= 'ii'; // Add parameter types for pagination
$bindParams[] = $offset;
$bindParams[] = $itemsPerPage;

// Prepare and execute the SQL query with bind parameters
$stmt = $conn->prepare($sql);

// Check if the prepared statement is valid
if ($stmt === false) {
    die("Error in prepared statement: " . $conn->error);
}

// Dynamically bind the parameters using call_user_func_array()
if (!empty($bindParams)) {
    $paramTypes = $bindParams[0]; // Get the parameter types string
    $bindParams = array_slice($bindParams, 1); // Remove the parameter types string from the array
    $stmt->bind_param($paramTypes, ...$bindParams); // Bind the parameters using spread operator
}

$stmt->execute();
$result = $stmt->get_result();
$i=0;
// Display the orders in a searchable table with pagination
if ($result->num_rows > 0) {
    echo '<div id="status-alerts"></div><table class="table table-striped">';
    echo '<thead><tr><th>Sr.no</th><th>Order ID</th><th>Order Status</th><th>Product Name</th><th>Qty</th><th>Cust Name</th><th>Address</th><th>Date</th><th></th></tr></thead>';
    echo '<tbody id="orders-table-body">';
    
    while ($row = $result->fetch_assoc()) {
      $i++;
      $pr_id = $row['product_id'];
        $sql1 = "SELECT * FROM `products` WHERE `products`.`sr_no` = $pr_id";
            $res1 = mysqli_query($conn, $sql1);
            if (mysqli_num_rows($res1) > 0) {
             
                while ($pr = mysqli_fetch_assoc($res1)) {
                    $product = $pr['pr_name'];
                  
                }
            }
        echo '<tr>';
       
        echo '<td style="width: 50px;">' . $i . '</td>';
        echo '<td>' . $row['order_id'] . '</td>';
        echo '<td><div id="status-container-'.$row['order_id'].'">' . $row['order_status'] . '</div></td>';

        echo '<td>' . $product . '</td>';
        echo '<td>' . $row['quantity'] . '</td>';
        echo '<td>' . $row['name'] . '</td>';
        echo '<td>' . $row['address'] . '</td>';
        echo '<td>' . $row['date_time'] . '</td>';
        echo '<td><a class="btn btn-success" data-bs-toggle="collapse" href="#collapseExample'.$i.'" role="button" aria-expanded="false" aria-controls="collapseExample1">
        View
      </a></td>';
    
        
        echo '</tr>';
          echo '</tbody>';
    echo '</table>';
echo '<tr>';
echo '<td colspan="8" class="p-0">
    <div class="collapse" id="collapseExample' . $i . '">
    
          <div class="card card-body">
            <div class="row">
                <div class="col-md-5"><strong>Pin</strong></div>
                <div class="col-md-1"><strong>:</strong></div>
                <div class="col-md-6">' . $row['pin'] . '</div>
            </div>
            <div class="row">
                <div class="col-md-5"><strong>Phone Number</strong></div>
                <div class="col-md-1"><strong>:</strong></div>
                <div class="col-md-6">' . $row['phone_no'] . '</div>
            </div>
               
   
            <div class="row">
                <div class="col-md-5"><strong>Payment Status</strong></div>
                <div class="col-md-1"><strong>:</strong></div>
                <div class="col-md-6">' . $row['payment_status'] . '</div>
            </div>
            <div class="row">
                <div class="col-md-5"><strong>Payment Mode</strong></div>
                <div class="col-md-1"><strong>:</strong></div>
                <div class="col-md-6">' . $row['payment_mode'] . '</div>
            </div>
            <div class="row">
                <div class="col-md-5"><strong>Amount</strong></div>
                <div class="col-md-1"><strong>:</strong></div>
                <div class="col-md-6">Rs.' . $row['amount'] . '/-</div>
            </div>
              ';
            if($row['shopVisit']!=null){
                echo '<div class="row">
                <div class="col-md-5"><strong>Shop Visit</strong></div>
                <div class="col-md-1"><strong>:</strong></div>
                <div class="col-md-6">True</div>
            </div>';
            }
          ?>

<?php
 echo '<p ><strong> Status :  </strong><span style="font-style: italic; font-weight: normal; color: red;  margin-bottom: 3px;">Note: The status is not reversible for orders in transit, out for delivery, and delivered. So <strong>  Do it Carefully !</strong></span></p>';
        echo '<div class="btn-group" role="group" aria-label="Delivery Status">';
       
$statusOptions = array("cancelled", "confirmed", "placed", "in_transit", "out_for_delivery", "delivered");
foreach ($statusOptions as $option) {
    $isActive = $row['order_status'] === $option ? 'active' : '';?>
   <label class="btn btn-outline-primary status-label <?php echo $isActive; ?>"
       data-order-id="<?php echo $row['order_id']; ?>"
       data-new-status="<?php echo $option; ?>"
       for="status_<?php echo $row['order_id'] . '_' . $option; ?>">
    <?php echo ucwords(str_replace("_", " ", $option)); ?>
</label>
<?php
}
echo '</div>

        </div>
        
    </div>
    
</td>';

echo '</tr>';
    }
    
     /* echo '<td>' . $row['pin'] . '</td>';
        echo '<td>' . $row['phone_no'] . '</td>';
        echo '<td>' . $row['payment_status'] . '</td>';
        echo '<td>' . $row['payment_mode'] . '</td>';
        echo '<td>' . $row['amount'] . '</td>';*/
  
// ...

// Pagination links
$sqlCount = "SELECT COUNT(*) AS total FROM orders o
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

$stmt->close();

$conn->close();
?>
