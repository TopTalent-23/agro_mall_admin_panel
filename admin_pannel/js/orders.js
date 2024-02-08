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
        url: "test/update_delivery_status.php",
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