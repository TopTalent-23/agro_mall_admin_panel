<?php
include('../../db_config.php');

// Get the order ID from the query parameters
$orderID = $_GET['orderID'];

// Retrieve customer details and associated product details from the database
$getOrderDetails = "SELECT orders.*, products.pr_name 
                    FROM orders
                    JOIN products ON orders.product_id = products.sr_no
                    WHERE orders.order_id = '$orderID'";

$resultOrderDetails = mysqli_query($conn, $getOrderDetails);

if (!$resultOrderDetails) {
    die('Error fetching order details: ' . mysqli_error($conn));
}

// Fetch the first row to get common customer details
$firstRow = mysqli_fetch_assoc($resultOrderDetails);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $orderID;?></title>
    
</head>
<body>

    <div id="invoiceContent" class="invoice">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .header {
            display: flex;
            align-items: center;
        }

        .logo {
            margin-right: 20px; /* Adjust the margin as needed */
        }

        .shop-address {
            font-size: 14px;
        }

        .invoice-details {
            display: flex;
            justify-content: space-between;
        }

        .customer-details {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table, th, td {
            border: 1px solid #ddd;
        }

        th, td {
            padding: 12px;
            text-align: left;
        }

        .total-row {
            font-weight: bold;
        }
    </style>
        <div class="header">
            <div class="logo">
                <img src="../../logo.png" alt="Shop Logo" width="100">
            </div>
            <?php

$shopName = '';
$address = '';
$phone = '';
$gstin = '';

$sqlAbout = "SELECT shop_name, address, phone1, gstin FROM about_us WHERE id = 1"; // Assuming the about_us table has a single row with id = 1
$resultAbout = mysqli_query($conn, $sqlAbout);

if (mysqli_num_rows($resultAbout) > 0) {
    $rowAbout = mysqli_fetch_assoc($resultAbout); // Fetch the row from the result set

    // Now you can access the values from the fetched row
    $shopName = $rowAbout['shop_name'];
    $address = $rowAbout['address'];
    $phone = $rowAbout['phone1'];
    $gstin = $rowAbout['gstin'];
    
}
?> 
            <div class="shop-name">
                <h1><?php echo $shopName?></h1>
                <p><?php echo $address?></p>
                <p>Phone: <?php echo $phone?></p>
                <p>GSTIN No. <?php echo $gstin?></p>
            </div>
        </div>

        <div class="invoice-details">
            <div class="customer-details">
                <h3>Customer Details</h3>
                <p>Name: <?php echo $firstRow['name']; ?></p>
                <p>Phone: <?php echo $firstRow['phone_no']; ?></p>
                <p>Email: <?php echo $firstRow['email']; ?></p>
                <p>Address: <?php echo $firstRow['address']; ?></p>
                <p>Pin: <?php echo $firstRow['pin']; ?></p>
            </div>

            <div class="order-details">
                <h3>Order Details</h3>
                <p>Order ID: <?php echo $orderID; ?></p>
                <p>Order Date: <?php echo date('Y-m-d H:i:s'); ?></p>
            
                <h3>Payment Details</h3>
                <p>Payment Status: <?php echo $firstRow['payment_status']; ?></p>
                <p>Payment Mode: <?php echo $firstRow['payment_mode']; ?></p>
            </div>
        </div>

        <h3>Product Details</h3>
        <table>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Amount</th>
            </tr>
            <?php
            $totalAmount = 0;
            mysqli_data_seek($resultOrderDetails, 0);
            while ($row = mysqli_fetch_assoc($resultOrderDetails)) {
                $totalAmount += $row['amount'];
                echo '<tr>';
                echo '<td>' . $row['pr_name'] . '</td>';
                echo '<td>' . $row['quantity'] . '</td>';
                echo '<td>' . $row['amount'] . '</td>';
                echo '</tr>';
            }
            ?>
            <tr class="total-row">
                <td colspan="2" align="right">Total Amount:</td>
                <td><?php echo $totalAmount; ?></td>
            </tr>
        </table>
        <p><span style="font-style: italic; font-weight: normal; color: red;  margin-bottom: 3px;">Note: This is computer Generated Invoice. Do not need of Signature...</span></p>
    </div>

    <!-- Add the "Print Invoice" button after the invoice content -->
    <button id="printButton">Print Invoice</button>

    <script>
        function printInvoice() {
        var printContents = document.getElementById('invoiceContent').outerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }

    document.getElementById('printButton').addEventListener('click', function() {
        printInvoice();
    });
    </script>

</body>
</html>

<?php
mysqli_close($conn);
?>
