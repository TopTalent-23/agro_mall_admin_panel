<?php require 'header.php'; 
if (isset($_SESSION['id'])) {
  $oderId= $_GET['order_id'];
  
    $usr = $_SESSION['id'];
    $sql1 = "SELECT * FROM `orders` WHERE `order_id` = '$oderId'";
    $result1 = mysqli_query($conn, $sql1);
    $num1 = mysqli_num_rows($result1);

    if ($num1 > 0) {
        while ($row1 = mysqli_fetch_assoc($result1)) {
            $name = $row1['name'];
            $phone = $row1['phone_no'];
            $email = $row1['email'];
            $pincode = $row1['pin'];
            $address = $row1['address'];
            $payment_status = $row1['payment_status'];
            $paymen_mode = $row1['payment_mode'];
            $payid = $row1['payid'];
            $order_id = $row1['order_id'];
            $quantity = $row1['quantity'];
            $date = $row1['date_time'];
            $amount = $row1['amount'];
            $pr_id = $row1['product_id'];
            
             $sql = "SELECT * FROM `products` WHERE `products`.`sr_no` = $pr_id";
                        $res = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($res) > 0) {
                    while ($pr = mysqli_fetch_assoc($res)) {
                      $product = $pr['pr_name'];
                     $price = $pr['discounted_price'];
                    }}
        }
    }
}
?>
<style>
  .profile {
    max-width: 800px;
    margin: 0 auto;
    font-family: Arial, sans-serif;
    text-align: center;
  }

  .profile h1 {
    margin-top: 20px;
    margin-bottom: 20px;
    font-family: Arial, sans-serif;
  }

  .profile table {
    margin: 0 auto;
    text-align: left;
    font-family: Arial, sans-serif;
  }

  .profile table th {
    padding: 10px;
    font-weight: bold;
  }

  .profile table td {
    padding: 10px;
  }
</style>


<div class="profile">
  <h1>My Profile</h1><hr>
  <table>
    <tr>
      <th>Name:</th>
      <td><?php echo $name; ?></td>
    </tr>
    <tr>
      <th>Phone Number:</th>
      <td><?php echo $phone; ?></td>
    </tr>
    <tr>
      <th>Email:</th>
      <td><?php echo $email; ?></td>
    </tr>
  </table>
<hr>
  <h1>Order Details</h1><hr>
  <table>
    <tr>
      <th>Order ID:</th>
      <td><?php echo $order_id; ?></td>
    </tr>
    <tr>
      <th>Product Name:</th>
      <td><?php echo $product; ?></td>
    </tr>
    <tr>
      <th>Quantity:</th>
      <td><?php echo $quantity; ?></td>
    </tr>
    <tr>
      <th>Payment Status:</th>
      <td><?php echo $payment_status; ?></td>
    </tr>
    <tr>
      <th>Total Amount:</th>
      <td><?php echo $quantity .' X '. $price .' = Rs.'. $amount.'/-'; ?></td>
    </tr>
    <tr>
      <th>Payment Mode:</th>
      <td><?php echo $paymen_mode; ?></td>
    </tr>
    <tr>
      <th>Payment Id:</th>
      <td><?php echo $payid; ?></td>
    </tr>
    <tr>
      <th>Date:</th>
      <td><?php echo $date; ?></td>
    </tr>
  </table>
  <hr>

  <h1>Delivery Address</h1><hr>
  <table>
    <tr>
      <th>Address:</th>
      <td><?php echo $address; ?></td>
    </tr>
    <tr>
      <th>Pin Code:</th>
      <td><?php echo $pincode; ?></td>
    </tr>
  </table>
<hr>
  <h1>Company Details</h1><hr>
  <table>
    <tr>
      <th>Company Name:</th>
      <td>Your Company Name</td>
    </tr>
    <tr>
      <th>Company Address:</th>
      <td>Your Company Address</td>
    </tr>
    <tr>
      <th>Company GSTIN:</th>
      <td>Your Company GSTIN</td>
    </tr>
  </table>
<hr>
  <div class="bill-note">
    <p><i>This is a computer-generated bill. No signature required.</i></p>
  </div>

  <div class="row mt-2 justify-content-center">
    <p><a class="btn btn-success d-flex mt-2 justify-content-center" href="generate_bill.php?orderID=<?php echo $order_id; ?>&name=<?php echo $name; ?>&phone=<?php echo $phone; ?>&email=<?php echo $email; ?>&quantity=<?php echo $quantity; ?>&address=<?php echo $address; ?>&pincode=<?php echo $pincode; ?>&pr_id=<?php echo $pr_id; ?>&product_name=<?php echo $product; ?>&price=<?php echo  $price; ?>&date=<?php echo $date; ?>&payment_status=<?php echo $payment_status; ?>&payment_mode=<?php echo $paymen_mode; ?>&payid=<?php echo $payid; ?>"><b>Download PDF</b></a></p>
  </div>
</div>

<?php require 'footer.php'; ?>
