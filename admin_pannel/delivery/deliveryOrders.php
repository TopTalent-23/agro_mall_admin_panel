<?php
include '../../db_config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $selectedPincode = $_POST['selectedPincode'];

    // Fetch orders based on the selected pincode
    $query = "SELECT o.order_id, p.pr_name,
    o.name, o.quantity, o.address,o.email, o.order_status, o.shopVisit, o.pin, o.phone_no, o.payid, o.payment_status, o.payment_mode, o.date_time AS order_date,
    GROUP_CONCAT(DISTINCT p.pr_name ORDER BY p.pr_name ASC SEPARATOR ', ') AS product_names
    FROM orders o
    JOIN products p ON o.product_id = p.sr_no WHERE pin = '$selectedPincode' AND order_status IN ('placed', 'in_transit', 'out_for_delivery') GROUP BY o.order_id";
    $result = mysqli_query($conn, $query);
    $i = 0;

    if ($result && mysqli_num_rows($result) > 0) {
        echo '<div class="table-responsive">';
        echo '<table class="table" id="myTable">';
        echo '<thead>';
        echo '<tr>';
        echo '<th>Sr.no</th>';
        echo '<th>OrderID</th>';
        echo '<th>CustomerName</th>';
        echo '<th>Order Status</th>';
        echo '</tr>';
        echo '</thead>';
        echo '<tbody>';
        
        while ($row = mysqli_fetch_assoc($result)) {
            $i++;
            $orderId=$row['order_id'];
            $email=$row['email'];
            echo '<tr>';
            echo '<td style="width: 50px; vertical-align: top;"   onclick="toggleCollapse(' . $orderId . ')" data-bs-toggle="collapse" href="#collapseExample' . $orderId . '" role="button" aria-expanded="false" aria-controls="collapseExample' . $orderId . '">' . $i . '</td>';
            echo '<td style="vertical-align: top;"   onclick="toggleCollapse(' . $orderId . ')" data-bs-toggle="collapse" href="#collapseExample' . $orderId . '" role="button" aria-expanded="false" aria-controls="collapseExample' . $orderId . '">' . $row['order_id'] . '</td>';
            echo '<td style="vertical-align: top;"   onclick="toggleCollapse(' . $orderId . ')" data-bs-toggle="collapse" href="#collapseExample' . $orderId . '" role="button" aria-expanded="false" aria-controls="collapseExample' . $orderId . '">' . $row['name'] . '</td>';
            echo '<td style="vertical-align: top; display: block;"   onclick="toggleCollapse(' . $orderId . ')" data-bs-toggle="collapse" href="#collapseExample' . $orderId . '" role="button" aria-expanded="false" aria-controls="collapseExample' . $orderId . '">' . $row['order_status'] . '</td>';
            echo '<td  class="p-0" style="display: block;">';
            echo '<div style="margin-left: -120%; margin-top: 8%; width:150%">'; // Adjust the margin to match the width of the first td
            echo '<div class="collapse" id="collapseExample' . $orderId . '">';
            echo '<div class="card card-body">';
            // Fetch the orderId from the current row
            $orderId = $row['order_id'];

            // Query to get all products associated with the order
            $productsQuery = "SELECT o.*, p.* FROM orders o
                LEFT JOIN products p ON o.product_id = p.sr_no
                WHERE o.order_id = '$orderId'";
            $productsResult = $conn->query($productsQuery);
            $totalAmount = 0;

            if ($productsResult->num_rows > 0) {
                echo '<div class="row">';
               
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
                echo '<ul class="list-group list-group-flush">';
                echo '<li class="list-group-item"><strong>Total:</strong> Rs. ' . $totalAmount . '/-</li>';
                echo '<input type="hidden" id="totalAmount" value="' . $totalAmount . '">';
            }

 // Order details

 
 echo '<li class="list-group-item"><strong>Pin:</strong> ' . $row['pin'] . '</li>';
 echo '<li class="list-group-item"><strong>Address:</strong> ' . $row['address'] . '</li>';
 echo '<li class="list-group-item"><strong>Phone Number:</strong> ' . $row['phone_no'] . '</li>';
 echo '<li class="list-group-item"><strong>Payment Id:</strong> ' . $row['payid'] . '</li>';
 echo '<li class="list-group-item"><strong>Payment Status:</strong> ' . $row['payment_status'] . '</li>';
 echo '<li class="list-group-item"><strong>Payment Mode:</strong> ' . $row['payment_mode'] . '</li>';

 // Update Payment Status button
 if ($row['payment_status'] == 'pending') {
    echo '<li class="list-group-item text-center">';
    echo '<button id="sendOtpButton"  class="btn btn-success btn-sm m-2" data-action="sendOtp" data-order-id="' .  $email . '" onclick="sendOtp(\'' .  $email . '\')">Send Otp</button>';

    echo '<button class="btn btn-success btn-sm" data-action="update-payment-status" data-order-id="' . $orderId . '" onclick="openPaymentModal(' . $orderId . ')">Complete Payment</button>';
    
    echo '</li>';
 }else{
    echo '<li class="list-group-item text-center">';
echo '<button id="sendOtpButton"  class="btn btn-success btn-sm m-2" data-action="sendOtp" data-order-id="' .  $email . '" onclick="sendOtp(\'' .  $email . '\')">Send Otp</button>';

    echo '<button class="btn btn-success btn-sm" data-action="update-order-status" data-order-id="' . $orderId . '" onclick="openStatusModal(' . $orderId . ')">Delivered</button>';
    echo '</li>';
 }

 // View Bill button
 echo '<li class="list-group-item text-center"><a href="../partials/invoice.php?orderID=' . $orderId . '" class="btn btn-success">View Bill</a></li>';

 echo '</ul>';
 echo '</div>';
 echo '</div>';

            echo '</div>';
            echo '</td>';
            echo '</tr>';
        }

        // Close the table and tbody outside the loop
        echo '</tbody>';
        echo '</table>';
        echo '</div>';
    } else {
        echo '<p>No orders found for the selected pincode and status.</p>';
    }
}
?>