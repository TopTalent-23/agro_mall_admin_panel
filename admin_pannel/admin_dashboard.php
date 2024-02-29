<?php
session_start();

if (!isset($_SESSION['admin_logedin']) && !isset($_SESSION['manager_logedin'])) {
  // Display an alert using JavaScript
  echo "<script>alert('You do not have access to this page. Please go back.')</script>";

  // Redirect the user to the previous page
  echo "<script>window.history.back();</script>";
  header("Location: partials/admin_login.php");
  // Exit the script to prevent further execution
  exit();
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

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.css">
   <link rel="stylesheet" href="css/admin.css">
   <script src="https://kit.fontawesome.com/c932d99d51.js" crossorigin="anonymous"></script>
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
      <div class="container mt-4">
  <div class=" justify-content-between align-items-center mb-4 mt-4">
        <h2 class="text-left">Orders</h2>
    </div>
    <!-- Date filters -->
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
      <input type="text" class="form-control  flatpickr" style="width: 500px  ;" id="date-range" placeholder="Select Date Range (YYYY-MM-DD to YYYY-MM-DD)">
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
      <table class="table table-striped">
       
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
    <div id="status-spinner" class= "row" style="display: none;">
      <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
      </div>
    </div>
   

    <!-- Use Bootstrap 5 collapse component -->
    
    
    
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


    
$(document).ready(function() {
    // Use event delegation to handle the click event for the "Update Payment Status" button
    $(document).on('click', '[data-action="update-payment-status"]', function() {
        // Extract the order ID from the button's data attributes
        var orderId = $(this).data('order-id');
        
        // Log the order ID to the console
        console.log('Clicked Order ID:', orderId);
        // Call your function or perform actions based on the orderId
        confirmPaymentUpdate(orderId);
    });

    // Your existing JavaScript code...

    // Function to handle the click event for the "Update Payment Status" button
    function confirmPaymentUpdate(orderId) {
      console.log('Updating Payment Status for Order ID:', orderId);
        Swal.fire({
            title: 'Are you sure?',
            text: 'Do you want to update the payment status to complete?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show input prompt for payment mode
                Swal.fire({
                    title: 'Enter Payment Mode',
                    input: 'select',
                    inputOptions: {
                        'upi': 'UPI',
                        'cash': 'Cash'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel'
                }).then((inputResult) => {
                    if (inputResult.isConfirmed) {
                        // Process the payment mode and update the payment status
                        let paymentMode = inputResult.value;
                        updatePaymentStatus(orderId, paymentMode);
                    }
                });
            }
        });
    }

    function updatePaymentStatus(orderId, paymentMode) {
        // Use AJAX or fetch to send the update request to the server
        // You may want to implement a separate PHP script for handling the update
        // Example using fetch:
        $.ajax({
            type: 'POST',
            url: 'partials/update_payment_status.php', // Update with the correct path
            data: {
                orderId: orderId,
                paymentMode: paymentMode,
            },
            dataType: 'json',
        })
            .done(function (data) {
                if (data.success) {
                 
            
                    $('.payment-status-container-'+orderId).text('complete');
                    $('.payment-mode-container-'+orderId).text(paymentMode);
                    Swal.fire('Payment Completed');
                    // You may want to reload the page or update the UI accordingly
                    
                } else {
                    Swal.fire('Error updating payment status!', '', 'error');
                }
            })
            .fail(function (error) {
                console.error('Error:', error);
                Swal.fire('Error updating payment status!', '', 'error');
            });
    }
     // Function to update the UI with the new payment status
   // Function to update the UI with the new payment status

// Function to asynchronously send status update email

});
  </script>
  
  <script>
      
      // Flatpickr initialization
  flatpickr(".flatpickr", {
    dateFormat: "Y-m-d",
    mode: "range",
    static: true,
    showMonths: 2,
    defaultDate: [new Date().toISOString().split('T')[0]] // Set default to today's date
  });

  $(document).ready(function() {

     $(".status-filter").click(function(event) {
    event.preventDefault(); // Prevent default link behavior
    $("#status-filter").val($(this).data("status"));
    applyDateFilter();
  });

    function fetchOrders(filter, page, startDate, endDate, searchQuery, statusFilter) {
      $("#spinner").show();
      $.ajax({
        url: "test/get_orders.php",
        method: "POST",
        data: {
          filter: filter,
          page: page,
          start_date: startDate,
          end_date: endDate,
          search: searchQuery,
          status_filter: statusFilter // Pass status filter to get_orders.php
        },
        dataType: "html",
        success: function(response) {
          console.log(response);
          $("#spinner").hide();
          $("#orders-table-body").html(response);
          
        },
        error: function(xhr, status, error) {
          console.error(error);
        }
      });
    }

    function applyDateFilter() {
      var filter = $("#date-filter").val();
      var startDate = null;
      var endDate = null;
      var statusFilter = $("#status-filter").val();

      if (filter === "custom") {
        const dateRangeInput = document.getElementById("date-range").value;
        const [start, end] = dateRangeInput.split(" to ");

        // If start and end dates are the same, treat it as a single date
        if (start === end) {
          startDate = start.trim();
          endDate = null; // Set end date to null for single date filter
        } else {
          startDate = start.trim();
          endDate = end.trim();
        }
      }

      fetchOrders(filter, 1, startDate, endDate, $("#search-order").val(), statusFilter);
    }

    // Initial loading with default filter (today's orders)
    applyDateFilter();

    // Apply event handlers for date filter buttons
    $(".date-filter-btn").click(function() {
      $("#date-filter").val($(this).data("filter"));
      applyDateFilter();
    });

    // Apply event handler for custom date filter
    $("#apply-custom-filter").click(function() {
      $("#date-filter").val("custom");
      applyDateFilter();
    });

    // Apply event handler for search button
    $("#search-order-btn").click(function() {
      applyDateFilter();
    });

    // Implement pagination handling
    $(document).on("click", ".pagination-link", function() {
      var page = $(this).data("page");
      var filter = $("#date-filter").val();
      var startDate = null;
      var endDate = null;

      if (filter === "custom") {
        const dateRangeInput = document.getElementById("date-range").value;
        const [start, end] = dateRangeInput.split(" to ");

        if (start === end) {
          startDate = start.trim();
          endDate = null;
        } else {
          startDate = start.trim();
          endDate = end.trim();
        }
      }

      fetchOrders(filter, page, startDate, endDate, $("#search-order").val(), $("#status-filter").val());
    });
    
    // Add the note above the status buttons

    // Delegate event handler for status update buttons
$(document).on('click', '.status-label', function () {
    var orderID = $(this).data('order-id');
    var newStatus = $(this).data('new-status');
    var clickedLabel = $(this); // Save a reference to the clicked label
    var statusContainer = $('#status-container-' + orderID);
    var currentStatus = statusContainer.text(); // Get the current order status

    // Define an array of status options for each order status
    var allowedStatuses = {
        not_confirmed: ['confirmed', 'cancelled'],
        confirmed: ['placed', 'cancelled'],
        placed: ['cancelled', 'in_transit'],
        in_transit: ['out_for_delivery', 'delivered'],
        out_for_delivery: ['delivered'],
        delivered: []
    };
 // Define an array of statuses where "Cancelled" status should not be allowed
    var restrictedStatuses = ['in_transit', 'out_for_delivery', 'delivered'];
    // If the new status is "cancelled", show a confirmation prompt
    if (newStatus === 'cancelled'  && !restrictedStatuses.includes(currentStatus))  {
        Swal.fire({
            title: 'Confirm Cancellation',
            text: 'Are you sure you want to cancel this order?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes',
            cancelButtonText: 'No',
            confirmButtonColor: '#d33',
        }).then((result) => {
            if (result.isConfirmed) {
                performStatusUpdate(orderID, newStatus, statusContainer, clickedLabel, currentStatus);
            }
        });
        return; // Don't proceed with the AJAX call yet
    }else{
       Swal.fire({
            title: 'Invalid Status Update',
            text: 'Cannot update to ' + newStatus + ' from ' + currentStatus,
            icon: 'error'
        });
    }

    // Check if the new status is allowed based on current status
    if (allowedStatuses[currentStatus] && allowedStatuses[currentStatus].includes(newStatus)) {
        performStatusUpdate(orderID, newStatus, statusContainer, clickedLabel, currentStatus);
    } else {
        Swal.fire({
            title: 'Invalid Status Update',
            text: 'Cannot update to ' + newStatus + ' from ' + currentStatus,
            icon: 'error'
        });
    }
});


   // Function to perform status update
function performStatusUpdate(orderID, newStatus, statusContainer, clickedLabel, currentStatus) {
  $.ajax({
    type: "POST",
    url: "update_delivery_status.php",
    data: { order_id: orderID, new_status: newStatus },
    success: function (response) {
      if (response === "Success") {
        // Update the button state and display a success message using SweetAlert2
        statusContainer.text(newStatus);

        // Asynchronously send the status update email
        sendStatusUpdateEmail(orderID, newStatus);

        $('.status-label[data-order-id="' + orderID + '"]').removeClass('active');
        clickedLabel.addClass('active'); // Use the saved reference here
        Swal.fire({
          title: 'Status Updated',
          text: 'Order status has been updated successfully.',
          icon: 'success'
        });
      } else {
        Swal.fire({
          title: 'Error',
          text: 'An error occurred while updating status: ' + response,
          icon: 'error'
        });
      }
    },
    error: function (xhr, status, error) {
      console.log(error);
      Swal.fire({
        title: 'Error',
        text: 'An error occurred: ' + error,
        icon: 'error'
      });
    }
  });
}
// Function to asynchronously send status update email
function sendStatusUpdateEmail(orderId, newStatus) {
  const formData = new FormData();
  formData.append('orderId', orderId);
  formData.append('newStatus', newStatus);

  $.ajax({
    type: 'POST',
    url: 'sendStatusUpdateEmail.php',
    data: formData,
    contentType: false,  // Don't set content type (automatically set by FormData)
    processData: false,  // Don't process data (already in FormData format)
    success: function (data) {
      if (data === 'success') {
        console.log("Email sent successfully");
        // You can add any further handling if needed
      } else {
          console.log(data);
        console.error("Error sending email");
      }
    },
    error: function (error) {
      console.error("Error sending email", error);
    }
  });
}

  });
  
  </script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
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