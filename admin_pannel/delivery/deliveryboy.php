<?php
session_start();
include '../../db_config.php';
if (!isset($_SESSION['deliveryBoy_logedin']) && !isset($_SESSION['admin_logedin'])) {
    session_destroy();
    header("Location: ../");
    exit();
}

$query = "SELECT DISTINCT pin FROM orders";
$result = mysqli_query($conn, $query);

$pincodes = array();

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $pincodes[] = $row['pin'];
    }
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
#myInput {
  background-image: url('/css/searchicon.png'); /* Add a search icon to input */
  background-position: 10px 12px; /* Position the search icon */
  background-repeat: no-repeat; /* Do not repeat the icon image */
  width: 100%; /* Full-width */
  font-size: 16px; /* Increase font-size */
  padding: 12px 20px 12px 40px; /* Add some padding */
  border: 1px solid #ddd; /* Add a grey border */
  margin-bottom: 12px; /* Add some space below the input */
}

#myTable {
  border-collapse: collapse; /* Collapse borders */
  width: 100%; /* Full-width */
  border: 1px solid #ddd; /* Add a grey border */
  font-size: 18px; /* Increase font-size */
}

#myTable th, #myTable td {
  text-align: left; /* Left-align text */
  padding: 12px; /* Add padding */
}

#myTable tr {
  /* Add a bottom border to all table rows */
  border-bottom: 1px solid #ddd;
}
#myTable tr.header, #myTable tr:hover {
  background-color: #f1f1f1;
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
        <form>
            <label>Select Pincode</label>
            <select class="form-control form-control-sm select2">
                <option>Select</option>
                <?php
                foreach ($pincodes as $pincode) {
                    echo "<option value='$pincode'>$pincode</option>";
                }
                ?>
            </select>
        </form>

        <!-- Content of the delivery boy panel goes here -->
        <div class="content">
            <input class="form-control" type="text" id="myInput" oninput="myFunction()" placeholder="Search">

            <div id="orderTable">
                <!-- Orders will be displayed here -->
            </div>
        </div>
    </div>
    </div>
    
<div class="card m-2">
    <div class="content">
    <h2>Delivered Orders</h2>

    <!-- Date Filter -->
    <select id="dateFilter" class="form-select">
        <option value="all" <?php echo ($filter == 'all') ? 'selected' : ''; ?>>All</option>
        <option value="today" <?php echo ($filter == 'today') ? 'selected' : ''; ?>>Today</option>
        <option value="yesterday" <?php echo ($filter == 'yesterday') ? 'selected' : ''; ?>>Yesterday</option>
    </select>

    <!-- Display Orders in Table -->
    <div class="table-responsive">
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
                window.location.href = 'deliveryboy.php?filter=' + selectedFilter;
            });
        });
        </script>
    <script>
    $(document).ready(function () {
    $('.select2').select2();

    $('.select2').on('change', function () {
        // Handle pincode change logic here
        var selectedPincode = $(this).val();

        // Fetch orders based on the selected pincode using AJAX
        $.ajax({
            type: 'post',
            url: 'deliveryOrders.php',
            data: {
                selectedPincode: selectedPincode
            },
            success: function (response) {
                $('#orderTable').html(response);

               
            }
        });
    });

   
  
    // Search function
    function searchTable() {
        var input, filter, table, tr, tdOrderID, tdCustomerName, i, txtValueOrderID, txtValueCustomerName;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("myTable");
        tr = table.getElementsByTagName("tr");

        // Loop through all table rows, and hide those who don't match the search query
        for (var i = 0; i < tr.length; i++) {
            var tdOrderID = tr[i].getElementsByTagName("td")[1];
            var tdCustomerName = tr[i].getElementsByTagName("td")[2];

            if (tdOrderID && tdCustomerName) {
                var txtValueOrderID = tdOrderID.textContent || tdOrderID.innerText;
                var txtValueCustomerName = tdCustomerName.textContent || tdCustomerName.innerText;

                if (txtValueOrderID.toUpperCase().indexOf(filter) > -1 || txtValueCustomerName.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }

    // Attach search function to input change event
    var inputElement = document.getElementById("myInput");
    if (inputElement) {
        inputElement.addEventListener('input', searchTable);
    }
});

function logout() {
    alert('Logged out');
    // Redirect to the login page or perform necessary logout actions
}

    </script>

<script>
// Define the function in the global scope
function openPaymentModal(orderId) {
    var totalAmount = document.getElementById("totalAmount").value;

    Swal.fire({
        title: 'Enter OTP',
        input: 'number',
        inputAttributes: {
            maxlength: 6,
            autocapitalize: 'off',
            autocorrect: 'off',
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        showLoaderOnConfirm: true,
        preConfirm: (otp) => {
            console.log('OTP:', otp);

            // Validate the OTP using an AJAX request
            return $.ajax({
                type: 'POST',
                url: 'validateSecretKey.php',
                data: {
                    otp: otp
                },
                dataType: 'text'
            }).catch((error) => {
                console.error('Error in OTP validation:', error);
                Swal.showValidationMessage('OTP validation failed. Please try again.');
            });
        },
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
        console.log(result);

        if (result.isConfirmed && result.value === 'success') {
            // The user clicked confirm, and the secret key is valid

            Swal.fire({
                title: 'Select Payment Mode',
                input: 'select',
                inputOptions: {
                    'upi': 'UPI',
                    'cash': 'Cash',
                },
                showCancelButton: true,
                confirmButtonText: 'Submit',
                cancelButtonText: 'Cancel',
                preConfirm: (paymentMode) => {
                    console.log('Selected payment mode:', paymentMode);

                    return new Promise((resolve) => {
                        $.ajax({
                            type: 'POST',
                            url: 'updatePaymentStatus.php',
                            data: {
                                orderId: orderId,
                                paymentMode: paymentMode,
                                totalAmount: totalAmount
                            },
                            dataType: 'json',
                            success: (updateResult) => {
                                console.log('Result of AJAX request:', updateResult);
                                resolve(updateResult);
                            },
                            error: (xhr, status, error) => {
                                console.error('Error in AJAX request:', error);
                                resolve({ status: 'error', message: 'An error occurred during the AJAX request.' });
                            }
                        });
                    });
                },
                allowOutsideClick: () => !Swal.isLoading(),
            }).then((updateResult) => {
                console.log('Result of second Swal prompt:', updateResult);

                if (updateResult.isConfirmed) {
                    Swal.fire('Payment Completed!', 'The payment status and mode have been updated.', 'success')
                        .then(() => {
                            window.location.href = '../partials/invoice.php?orderID=' + orderId;
                        });
                }
            });
        } else if (result.isConfirmed && result.value === 'error') {
            console.log('Error:', result.value.message);
            Swal.fire('Error', result.value.message, 'error');
        } else if (result.isDismissed) {
            console.log('Modal dismissed (user clicked cancel or closed the modal)');
        }
    }).catch((error) => {
        console.error('Unhandled promise rejection:', error);
    });
}


// Use event delegation to handle the click event
$(document).on('click', '[data-action="update-payment-status"]', function() {
    var orderId = $(this).data('order-id');
    openPaymentModal(orderId);
});


function openStatusModal(orderId) {
     Swal.fire({
        title: 'Enter OTP',
        input: 'number',
        inputAttributes: {
            maxlength: 6,
            autocapitalize: 'off',
            autocorrect: 'off',
        },
        showCancelButton: true,
        confirmButtonText: 'Submit',
        cancelButtonText: 'Cancel',
        showLoaderOnConfirm: true,
        preConfirm: (otp) => {
            console.log('OTP:', otp);

            // Validate the OTP using an AJAX request
            return $.ajax({
                type: 'POST',
                url: 'validateSecretKey.php',
                data: {
                    otp: otp
                },
                dataType: 'text'
            }).catch((error) => {
                console.error('Error in OTP validation:', error);
                Swal.showValidationMessage('OTP validation failed. Please try again.');
            });
        },
        allowOutsideClick: () => !Swal.isLoading(),
    }).then((result) => {
        console.log (result);
        if (result.isConfirmed && result.value === 'success') {
            // The user clicked confirm, and the secret key is valid

            // Directly update the order status
            updateOrderStatus(orderId);
        } else if (result.isConfirmed && result.value === 'error') {
            // The user clicked confirm, but the secret key is invalid
            console.log('Error:', result.value.message);
            Swal.fire('Error', result.value.message, 'error');
        } else if (result.isDismissed) {
            // The user clicked cancel or closed the modal
            console.log('Modal dismissed (user clicked cancel or closed the modal)');
        }
    });
}




function sendOtp(email) {
    // Validate the email
    if (!validateEmail(email)) {
        Swal.fire({
            icon: "error",
            title: "Invalid Email!",
            text: "Please provide a valid email address.",
            confirmButtonColor: "#d33",
            confirmButtonText: "OK",
        });
        return;
    }
// Disable the button and show the timer
    var button = $("#sendOtpButton");
    button.prop("disabled", true);

    var secondsLeft = 30;

    var timerInterval = setInterval(function() {
        secondsLeft--;
        button.text("Resend OTP in " + secondsLeft + "s");

        if (secondsLeft <= 0) {
            // Enable the button and reset the text
            button.prop("disabled", false);
            button.text("Send OTP");
            clearInterval(timerInterval);
        }
    }, 1000);
    // Send AJAX request to send OTP
    console.log(email);
    $.ajax({
        type: "POST",
        url: "send_otp_handler.php", // Replace with the actual file handling OTP sending
        data: {
            email: email
        },
        success: function (response) {
            if (response === "success") {
                Swal.fire({
                    icon: "success",
                    title: "OTP Sent Successfully!",
                    text: "An OTP has been sent to your email address.",
                    confirmButtonColor: "#28a745",
                    confirmButtonText: "OK",
                });
            } else {
                // Display the error message using SweetAlert
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Error: " + response,
                    confirmButtonColor: "#d33",
                    confirmButtonText: "OK",
                });
                
                // If there's an error, reset the timer and enable the button immediately
                clearInterval(timerInterval);
                button.prop("disabled", false);
                button.text("Send OTP");
            }
        },
        error: function () {
            console.error("Error in AJAX request");
            clearInterval(timerInterval);
            button.prop("disabled", false);
            button.text("Send OTP");
        },
    });
}

// Function to validate email format
function validateEmail(email) {
    var regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}





// Update order status to delivered
function updateOrderStatus(orderId) {
    // Perform AJAX request to update order status
    var totalAmount = document.getElementById("totalAmount").value;
    $.ajax({
        type: 'POST',
        url: 'updateOrderStatus.php', // Replace with the actual server-side script
        data: {
            orderId: orderId,
            totalAmount: totalAmount
        },
        dataType: 'json',
        success: (updateResult) => {
            if (updateResult.status === 'success') {
                Swal.fire('Order Delivered!', 'The order status has been updated to delivered.', 'success')
                    .then(() => {
                        // Redirect to the invoice page
                        window.location.href = '../partials/invoice.php?orderID=' + orderId;
                    });
            } else {
                Swal.fire('Error', updateResult.message, 'error');
            }
        },
        error: (xhr, status, error) => {
            console.error('Error in AJAX request:', error);
            Swal.fire('Error', 'An error occurred during the AJAX request.', 'error');
        }
    });
}

// Use event delegation to handle the click event
$(document).on('click', '[data-action="update-order-status"]', function() {
    var orderId = $(this).data('order-id');
    openStatusModal(orderId);
});

</script>

<footer>
    Admin Panel &copy; <?php echo date('Y'); ?> Ahire Agro Mall
  </footer>

</body>

</html>
