<?php
session_start();
if (!$_SESSION['admin_logedin']) {
  header("Location: partials/admin_login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin Dashboard</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.css">
   <link rel="stylesheet" href="css/admin.css">
 
</head>
<body>



    <?php
    // Include the database configuration file
    include("navbar.php");
    include("../db_config.php");
    // Fetch overall analytics data
    // Fetch overall analytics data
    $overall_analytics_query = "
    SELECT
    COUNT(DISTINCT order_id) AS total_orders,
    SUM(CASE WHEN order_status = 'cancelled' THEN 1 ELSE 0 END) AS total_cancelled_orders,
    SUM(CASE WHEN order_status = 'delivered' THEN 1 ELSE 0 END) AS total_delivered_orders,
    SUM(CASE WHEN order_status != 'cancelled' AND order_status != 'delivered' THEN 1 ELSE 0 END) AS total_payment_pending_orders,
    SUM(CASE WHEN order_status != 'cancelled' AND payment_status = 'pending' THEN amount ELSE 0 END) AS total_payment_pending_revenue,
    SUM(CASE WHEN order_status = 'delivered' AND payment_status = 'complete' THEN 1 ELSE 0 END) AS total_completed_orders,
    SUM(CASE WHEN order_status != 'cancelled' AND order_status != 'delivered' AND payment_status = 'complete' THEN 1 ELSE 0 END) AS total_payment_complete_not_delivered_orders,
    SUM(CASE WHEN order_status != 'cancelled' AND YEAR(date_time) = YEAR(CURDATE()) THEN 1 ELSE 0 END) AS total_orders_this_year,
    SUM(CASE WHEN order_status != 'cancelled' AND payment_status = 'complete' AND YEAR(date_time) = YEAR(CURDATE()) THEN amount ELSE 0 END) AS total_revenue_this_year,
    SUM(CASE WHEN order_status != 'cancelled' AND MONTH(date_time) = MONTH(CURDATE()) THEN 1 ELSE 0 END) AS total_orders_this_month,
    SUM(CASE WHEN order_status != 'cancelled' AND payment_status = 'complete' AND MONTH(date_time) = MONTH(CURDATE()) THEN amount ELSE 0 END) AS total_revenue_this_month,
    SUM(CASE WHEN order_status != 'cancelled' AND DATE(date_time) = CURDATE() THEN 1 ELSE 0 END) AS total_orders_today,
    SUM(CASE WHEN order_status = 'cancelled' AND DATE(date_time) = CURDATE() THEN 1 ELSE 0 END) AS total_cancelled_orders_today,
    SUM(CASE WHEN order_status = 'cancelled' AND DATE(date_time) >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) THEN 1 ELSE 0 END) AS total_cancelled_orders_last_week,
    SUM(CASE WHEN order_status = 'cancelled' AND MONTH(date_time) = MONTH(CURDATE()) THEN 1 ELSE 0 END) AS total_cancelled_orders_this_month,
    SUM(CASE WHEN order_status = 'cancelled' AND YEAR(date_time) = YEAR(CURDATE()) THEN 1 ELSE 0 END) AS total_cancelled_orders_this_year,
    SUM(CASE WHEN order_status != 'cancelled' AND payment_status = 'complete' AND DATE(date_time) >= DATE_SUB(CURDATE(), INTERVAL 1 WEEK) THEN amount ELSE 0 END) AS total_last_week_revenue,
    SUM(CASE WHEN order_status != 'cancelled' AND payment_status = 'complete' AND DATE(date_time) = CURDATE() THEN amount ELSE 0 END) AS total_today_revenue
FROM orders";

    $overall_analytics_result = mysqli_query($conn, $overall_analytics_query);
    $overall_analytics_data = mysqli_fetch_assoc($overall_analytics_result);




    ?>


    <!-- Main Content -->
    <div class="container-fluid mt-4">
      <h2>Analytics</h2>
      <div class="row">
        <div class="col-md-6 chart-container">
          <h3 class="text-center mb-4">Monthly Sales</h3>
          <canvas id="monthlySalesChart" width="50" height="30"></canvas>
        </div>
        <div class="col-md-6 chart-container">
          <h3 class="text-center mb-4">Product Sales Distribution</h3>
          <canvas id="productSalesChart" width="30" height="10"></canvas>
        </div>
      </div>
      <div class="card mb-4">
        <div class="card-header bg-primary text-white">
          Overall Analytics
        </div>

        <div class="container mt-4">
          <div class="row">
            <div class="col-md-6">
              <div class="accordion" id="accordionOrders">
                <div class="card mb-2">
                  <div class="card-header" id="ordersCollapseHeading">
                    <h6 class="mb-0">
                      <button class="btn btn-link" data-toggle="collapse" data-target="#ordersCollapse" aria-expanded="true" aria-controls="ordersCollapse">
                        Orders
                      </button>
                    </h6>
                  </div>
                  <div id="ordersCollapse" class="collapse show" aria-labelledby="ordersCollapseHeading" data-parent="#accordionOrders">
                    <div class="card-body">
                      <table class="table">
                        <tbody>
                          <tr>
                            <th>Total Orders:</th>
                            <td><?php echo $overall_analytics_data['total_orders']; ?></td>
                          </tr>
                          <tr>
                            <th>Total Cancelled Orders:</th>
                            <td><?php echo $overall_analytics_data['total_cancelled_orders']; ?></td>
                          </tr>
                          <tr>
                            <th>Total Delivered Orders:</th>
                            <td><?php echo $overall_analytics_data['total_delivered_orders']; ?></td>
                          </tr>
                          <tr>
                            <th>Total Completed Orders:</th>
                            <td><?php echo $overall_analytics_data['total_completed_orders']; ?></td>
                          </tr>
                          <tr>
                            <th>Total Orders This Year:</th>
                            <td><?php echo $overall_analytics_data['total_orders_this_year']; ?></td>
                          </tr>
                          <tr>
                            <th>Total Orders This Month:</th>
                            <td><?php echo $overall_analytics_data['total_orders_this_month']; ?></td>
                          </tr>
                          <tr>
                            <th>Total Orders Today:</th>
                            <td><?php echo $overall_analytics_data['total_orders_today']; ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="card mb-2">
                  <div class="card-header" id="moreCollapseHeading">
                    <h6 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#moreCollapse" aria-expanded="false" aria-controls="moreCollapse">
                        More Metrics
                      </button>
                    </h6>
                  </div>
                  <div id="moreCollapse" class="collapse" aria-labelledby="moreCollapseHeading" data-parent="#accordionOrders">
                    <div class="card-body">
                      <table class="table">
                        <tbody>
                          <tr><th>Total Payment Pending Orders:</th>
                            <td><?php echo $overall_analytics_data['total_payment_pending_orders']; ?></td>
                          </tr><tr><th>Total Payment Pending
                              Revenue:</th><td><?php echo
                              $overall_analytics_data['total_payment_pending_revenue'];
                              ?></td></tr><tr><th>Total Payment Complete but Not
                              Delivered Orders:</th><td><?php echo $overall_analytics_data['total_payment_complete_not_delivered_orders']; ?></td></tr>
                        </tbody>
                      </table>


                      <!-- Add more data points here -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="accordion" id="accordionRevenue">
                <div class="card mb-2">
                  <div class="card-header" id="revenueCollapseHeading">
                    <h6 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#revenueCollapse" aria-expanded="false" aria-controls="revenueCollapse">
                        Revenue
                      </button>
                    </h6>
                  </div>
                  <div id="revenueCollapse" class="collapse" aria-labelledby="revenueCollapseHeading" data-parent="#accordionRevenue">
                    <div class="card-body">
                      <table class="table">
                        <tbody>
                          <tr><th>Total Revenue This Year:</th>
                            <td><?php echo $overall_analytics_data['total_revenue_this_year']; ?></td>
                          </tr><tr><th>Total Revenue This Month:</th><td><?php
                              echo
                              $overall_analytics_data['total_revenue_this_month'];
                              ?></td></tr><tr><th>Total Last Week
                              Revenue:</th><td><?php echo
                              $overall_analytics_data['total_last_week_revenue'];
                              ?></td></tr><tr><th>Total Revenue
                              Today:</th><td><?php echo $overall_analytics_data['total_today_revenue']; ?></td></tr>
                        </tbody>
                      </table>


                      <!-- Add more data points here -->
                    </div>
                  </div>
                </div>
                <div class="card mb-2">
                  <div class="card-header" id="cancelledCollapseHeading">
                    <h6 class="mb-0">
                      <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#cancelledCollapse" aria-expanded="false" aria-controls="cancelledCollapse">
                        Cancelled Orders
                      </button>
                    </h6>
                  </div>
                  <div id="cancelledCollapse" class="collapse" aria-labelledby="cancelledCollapseHeading" data-parent="#accordionRevenue">
                    <div class="card-body">
                      <table class="table">
                        <tbody>
                          <tr><th>Total Cancelled Orders today:</th>
                            <td><?php echo
                              $overall_analytics_data['total_cancelled_orders_today']; ?></td>
                          </tr><tr><th>Total Cancelled Orders This Month:</th><td><?php echo $overall_analytics_data['total_cancelled_orders_this_month']; ?></td></tr><tr><th>Total Cancelled Orders This Year:</th><td><?php echo $overall_analytics_data['total_cancelled_orders_this_year']; ?></td></tr><tr><th>Total Cancelled Orders Last Week:</th><td><?php echo $overall_analytics_data['total_cancelled_orders_last_week']; ?></td></tr>
                        </tbody>
                      </table>

                    </div>
                  </div>
                </div>
                <!-- Add more categorized collapses here -->
              </div>
            </div>
          </div>
        </div>
      </div>


      <!-- Today's orders card -->
      <!-- Date filters --><hr>
      <div class="m-2">
        <h2>Orders</h2>
      </div>
      <hr>
      <div class="row">
        <div class="col-md-8">
          <div class="btn-group">
            <button type="button" class="btn btn-outline-primary date-filter-btn" data-filter="today">Today</button>
            <button type="button" class="btn btn-outline-primary date-filter-btn" data-filter="yesterday">Yesterday</button>
            <button type="button" class="btn btn-outline-primary date-filter-btn" data-filter="last_week">Last Week</button>
            <button type="button" class="btn btn-outline-primary date-filter-btn" data-filter="last_month">Last Month</button>
          </div>
        </div>

        <div class="col-md-4">
          <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
              <span id="statusFilterText">Status Filter</span>
            </button>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item status-filter" data-status="all" href="#">All</a></li>
              <li><a class="dropdown-item status-filter" data-status="not_confirmed" href="#">Not Confirmed</a></li>
              <li><a class="dropdown-item status-filter" data-status="confirmed" href="#">Confirmed</a></li>
              <li><a class="dropdown-item status-filter" data-status="placed" href="#">Placed</a></li>
              <li><a class="dropdown-item status-filter" data-status="in_transit" href="#">In Transit</a></li>
              <li><a class="dropdown-item status-filter" data-status="out_for_delivery" href="#">Out for Delivery</a></li>
              <li><a class="dropdown-item status-filter" data-status="delivered" href="#">Delivered</a></li>
              <li><a class="dropdown-item status-filter" data-status="cancelled" href="#">Cancelled</a></li>
            </ul>
            <input id="status-filter" value="all" disabled size="5">
          </div>
        </div>
      </div>

      <div class="input-group mb-3 mt-3">
        Date Range:
        <input type="text" class="form-control flatpickr" id="date-range" placeholder="Select Date Range (YYYY-MM-DD to YYYY-MM-DD)">
        <button class="btn btn-outline-primary" id="apply-custom-filter">Apply</button>
      </div>

      <div class="input-group mb-3">
        Search Order:
        <input type="text" class="form-control" id="search-order" placeholder="Enter order ID or product name">
        <button class="btn btn-outline-primary" id="search-order-btn">Search</button>
      </div>

      <!-- Hidden input to keep track of the selected filter -->
      <input type="hidden" id="date-filter" value="today">
      <input type="hidden" id="status-filter" value="all">
      <!-- Orders table -->
      <div id="orders-table">
        <table class="table table-striped table-responsive">

          <tbody id="orders-table-body">
            <!-- Table content will be dynamically updated here -->
          </tbody>
        </table>
      </div>

      <!-- Loading spinner -->
      <div id="spinner" style="display: none;">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>
      <!-- Loading spinner -->
      <div id="status-spinner" class="row" style="display: none;">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Loading...</span>
        </div>
      </div>


      <!-- Use Bootstrap 5 collapse component -->

      <!-- Add more cards or widgets as needed -->

    </div>
  </div>


  <!-- Footer -->
  <footer>
    Admin Panel &copy; <?php echo date('Y'); ?> Ahire Agro Mall
  </footer>



  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

  <!-- Include Bootstrap JS -->

  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
  <script>
    $(document).ready(function () {
      $("#sidebarCollapse").on("click", function () {
        $("#sidebar").toggleClass("active");
        $("#content").toggleClass("active");
        $(".custom-navbar").toggleClass("active");
      });
    });
  </script>
  <script src="js/orders.js"></script>
  <script>
    // PHP fetched data for revenue chart
    <?php
    // Include the database configuration file


    // Fetch monthly sales data (Replace with your actual query)
    $monthlySalesQuery = "SELECT DATE_FORMAT(date_time, '%b') AS month, SUM(amount) AS sales FROM orders GROUP BY MONTH(date_time)";
    $monthlySalesResult = mysqli_query($conn, $monthlySalesQuery);
    $monthlySalesData = array();
    while ($row = mysqli_fetch_assoc($monthlySalesResult)) {
      $monthlySalesData[] = array(
        'month' => $row['month'],
        'sales' => (int) $row['sales'],
      );
    }

   // Fetch product sales distribution data (Replace with your actual query)
$productSalesQuery = "SELECT product_id, SUM(quantity) AS sales FROM orders GROUP BY product_id";
$productSalesResult = mysqli_query($conn, $productSalesQuery);
$productSalesData = array();
while ($row = mysqli_fetch_assoc($productSalesResult)) {
    // Replace 'product_name_column' with the actual column name that holds the product name
    $productNameQuery = "SELECT pr_name FROM products WHERE sr_no = {$row['product_id']}";
    $productNameResult = mysqli_query($conn, $productNameQuery);

    // Check if a row is fetched before trying to access the 'pr_name'
    if ($productNameResult) {
        $productNameRow = mysqli_fetch_assoc($productNameResult);

        // Check if 'pr_name' is not null before using it
        if ($productNameRow !== null && isset($productNameRow['pr_name'])) {
            $productName = $productNameRow['pr_name'];
        } else {
            // Handle the case where 'pr_name' is null or not set
            $productName = 'Unknown Product';
        }
    } else {
        // Handle the case where no row is fetched
        $productName = 'Unknown Product';
    }

    $productSalesData[] = array(
        'product' => $productName,
        'sales' => (int) $row['sales'],
    );
}

    
    ?>

    // Monthly Sales Chart
    var monthlySalesData = <?php echo json_encode($monthlySalesData); ?>;
    var monthlySalesLabels = monthlySalesData.map(item => item.month);
    var monthlySalesValues = monthlySalesData.map(item => item.sales);
    var monthlySalesChart = new Chart(document.getElementById('monthlySalesChart'), {
      type: 'bar',
      data: {
        labels: monthlySalesLabels,
        datasets: [{
          label: 'Monthly Sales',
          data: monthlySalesValues,
          backgroundColor: 'rgba(75, 192, 192, 0.7)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 50
            }
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      }
    });

    // Product Sales Distribution Chart
    var productSalesData = <?php echo json_encode($productSalesData); ?>;
    var productSalesLabels = productSalesData.map(item => item.product);
    var productSalesValues = productSalesData.map(item => item.sales);
    var productSalesChart = new Chart(document.getElementById('productSalesChart'), {
      type: 'doughnut',
      data: {
        labels: productSalesLabels,
        datasets: [{
          data: productSalesValues,
          backgroundColor: ['rgba(255, 99, 132, 0.7)', 'rgba(54, 162, 235, 0.7)', 'rgba(255, 206, 86, 0.7)'],
          borderColor: ['#fff', '#fff', '#fff'],
          borderWidth: 1
        }]
      },
      options: {
        plugins: {
          legend: {
            display: true,
            position: 'bottom'
          }
        }
      }
    });
  </script>
</body>
</html>