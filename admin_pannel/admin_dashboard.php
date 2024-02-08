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
    <div class="mt-4 text-center">
    <h1>Ahire Agro Mall</h1>
    <h4>Expense-Sales Analysis</h4>
    <label for="year">Select Year:</label>
    <select id="year" class="form-control">
        <!-- Add options dynamically using JavaScript for available years -->
    </select>

    <div class="m-auto" >
        <canvas id="expenseChart" style="max-height: 500px;"></canvas>
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
    // Call a function to populate the year dropdown with available years
populateYearDropdown();

// Fetch and display initial chart data
fetchChartData($('#year').val()); // Use the selected year from the dropdown as the default

// Add your other JavaScript functionalities here

// Function to populate the year dropdown
function populateYearDropdown() {
    var currentYear = new Date().getFullYear();
    for (var year = currentYear; year >= 2020; year--) {
        $('#year').append('<option value="' + year + '">' + year + '</option>');
    }

    // Add onchange event to the year dropdown
    $('#year').on('change', function () {
        console.log('Year changed:', $(this).val());
        var selectedYear = $(this).val();
        fetchChartData(selectedYear);
        fetchExpenses(selectedYear);
    });
}
function fetchChartData(selectedYear) {
    $.ajax({
        url: 'partials/fetch_expense_and_sales_data.php',
        type: 'GET',
        data: { selectedYear: selectedYear },
        dataType: 'json',
        success: function (response) {
            console.log('Fetched Expense and Sales Data:', response);
            updateChart(response);
        },
        error: function (error) {
            console.error('Error fetching expense and sales data:', error.responseText);
            Swal.fire('Error', 'Failed to fetch expense and sales data', 'error');
        }
    });

    // Fetch and display expenses for the selected year
    fetchExpenses(selectedYear);
}
// Function to update the chart with fetched data
function updateChart(data) {
    var months = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    // Extract expense and sales data from the fetched data
    var expenseData = data.expenses;
    var salesData = data.sales;

    // Map fetched data to match the expected structure
    var formattedExpenseData = months.map(function (month) {
        // Find the sum of expenses for each month
        var totalAmount = expenseData.reduce(function (accumulator, expense) {
            var expenseMonth = new Date(expense.date).toLocaleString('en-US', { month: 'long' });
            return expenseMonth === month ? accumulator + parseFloat(expense.amount) : accumulator;
        }, 0);

        return totalAmount; // Return numeric totalAmount for each month
    });

    var formattedSalesData = months.map(function (month) {
    // Find the sum of sales for each month
    var totalAmount = salesData.reduce(function (accumulator, sale) {
        var saleMonth = new Date(sale.date_time).getMonth(); // Extract month as a number (0-11)
        return saleMonth === months.indexOf(month) ? accumulator + parseFloat(sale.amount) : accumulator;
    }, 0);
   console.log(totalAmount);
    return totalAmount; // Return numeric totalAmount for each month
});

    // Get the canvas element
    var ctx = document.getElementById('expenseChart').getContext('2d');

    // Check if a chart instance already exists
    if (window.myLineChart) {
        // Destroy the existing chart instance
        window.myLineChart.destroy();
    }

    // Create a new chart instance
    var data = {
        labels: months,
        datasets: [{
            label: 'Monthly Expenses',
            data: formattedExpenseData,
            backgroundColor: 'rgba(255, 99, 132, 0.2)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }, {
            label: 'Monthly Sales',
            data: formattedSalesData,
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 1
        }]
    };

    var options = {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    window.myLineChart = new Chart(ctx, {
        type: 'bar',
        data: data,
        options: options
    });
}
  </script>
</body>
</html>