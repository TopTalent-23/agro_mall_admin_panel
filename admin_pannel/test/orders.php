<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dynamic Orders Page</title>
  <!-- Include Bootstrap CSS -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.css">
</head>
<body>
  <div class="container mt-4">
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

  <!-- Include jQuery, Bootstrap JS, and Flatpickr -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.9/dist/flatpickr.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.js"></script>
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
        url: "get_orders.php",
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
          Swal.fire({
            title: 'Error',
            text: 'An error occurred: ' + error,
            icon: 'error'
          });
        }
      });
    }


  });
 

</script>

</body>
</html>
  





