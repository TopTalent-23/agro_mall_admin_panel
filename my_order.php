<?php
include 'header.php';

include('db_config.php');
$usr_id = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id']; // Retrieve the order ID from the form

    // Prepare the SQL statement to delete the order
    $sql = "DELETE FROM `orders` WHERE `order_id` = '$order_id'";

    // Execute the query
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '<script>alert("Order canceled...")</script>';
    } else {
        echo '<script>alert("Failed to delete order.")</script>';
    }
}

?>

<style>
    .profile {
        max-width: 100%;
        margin: 0 auto;
        font-family: Arial, sans-serif;
        text-align: center;
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .profile h1 {
        margin: 20px;
    }

    .order-container {
        margin-bottom: 30px;
        padding: 20px;
        border: 1px solid #ccc;
        text-align: left;
        width: 100%;
        max-width: 80%;
        display: flex;
        flex-direction: column;
        align-items: center;
    }
    .order-container img {
      margin: 20px;
    }

    .order-container a {
        text-decoration: none;
        color: #000;
        
    }

    .order-container p {
        margin: 5px 0;
    }

    .btn-group {
        display: flex;
        gap: 10px;
        width: 100%;
        margin-top: 10px;
        text-decoration-color: white;
        justify-content: center;
    }
    .btn {
      text-decoration-color: white;
    }

    @media (max-width: 767px) {
        .profile h1 {
            font-size: 24px;
        }

        .order-container {
            padding: 20px;
        }
    }
</style>

<div class="profile">
    <h1>My Orders</h1>
    <?php
    // Include the database configuration file

    // Get the user's orders from the database
    // Assuming you have a user ID stored in the session
    $query = "SELECT * FROM orders WHERE usr_id = '$usr_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $orderID = $row['order_id'];
            $pr_id = $row['product_id'];
            $quantity = $row['quantity'];
            $amount = $row['amount'];
            $date = $row['date_time'];
            $status = $row['payment_status'];
            $payment_mode = $row['payment_mode'];


            $sql = "SELECT *, GROUP_CONCAT(product_images.image_content) AS images
                FROM products
                JOIN product_images ON product_images.product_id =
                products.sr_no
                WHERE `products`.`sr_no` = $pr_id
                GROUP BY products.sr_no 
                ";
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) > 0) {
                while ($pr = mysqli_fetch_assoc($res)) {
                    $product = $pr['pr_name'];
                  $img=$pr['image_content'];
                    $category = $pr['cat_id'];
                }
            }
            ?>
            
  
            <div class="container order-container">
             
            <a href="product_detail.php?category=<?php echo $category; ?>&product=<?php echo $pr_id; ?>">
            <table>
              <tr>
                <th>
                    <img src="data:products/jpg;charset=utf8;base64,<?php
                         echo base64_encode($img); ?>"  width="100"
                         class="rounded float-start"  alt="...">
      
    </th>
    <td>
      <p><strong>Order ID:</strong> <?php echo $orderID; ?></p>
                <p><strong>Product:</strong><?php echo $product; ?></p>
                <p><strong>Quantity:</strong> <?php echo $quantity; ?></p>
                <p><strong>Amount:</strong> <?php echo $amount; ?></p>
                <p><strong>Date:</strong> <?php echo $date; ?></p>
                <p><strong>Payment:</strong> <?php echo $status; ?></p>
                <p><strong>Mode:</strong> <?php echo $payment_mode; ?></p>

                </td>
                </tr>
                </table>
                </a>
                                <div class="btn-group">
                    <button data-bs-toggle="modal" data-bs-target="#delete" class="btn btn-danger"><b>Cancel Order</b></button>
                    <a href="bill.php?order_id=<?php echo $orderID; ?>" class="btn btn-success text-white"><b>View Bill</b></a>
                </div>
    </div>
    
                
            
            </div>

            <div class="modal fade" id="delete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Cancel Order</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="my_order.php" method="POST">
                                Are you sure you want to cancel the order?<br>
                                <input type="text" class="form-control" id="order_id" name="order_id" aria-describedby="emailHelp" value="<?php echo $orderID; ?>" hidden placeholder="Your Name">
                                <div class="btn-group">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-danger">Yes</button></div>
                            </form>
                        </div>
                        <div class="modal-footer">
                        </div>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        echo "<p>No orders found.</p>";
    }
    ?>
</div>

<?php require 'footer.php'; ?>
