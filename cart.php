<?php
include 'header.php';
include 'db_config.php';

$usr_id = $_SESSION['id'];
?>
<!-- Other head elements -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php

// Handle canceling an order or updating the quantity
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $product_id = $_POST['product_id'];

    // Check if the action is for removing the product
    if (isset($_POST['remove_product'])) {
        // Remove the selected product from the cart
        if (isset($_SESSION['cart'][$product_id])) {
            unset($_SESSION['cart'][$product_id]);
        }
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Product Removed",
                    text: "The product has been removed from the cart.",
                    timer: 2000, // Set the timer to close the alert after 2 seconds
                    showConfirmButton: false
                });
            </script>';
    } else {
        // Increment or decrement the quantity based on the button clicked
        $quantity_change = isset($_POST['increment']) ? 1 : (isset($_POST['decrement']) ? -1 : 0);

        if ($quantity_change !== 0) {
            // Update the quantity in the cart
            if (isset($_SESSION['cart'][$product_id])) {
                $_SESSION['cart'][$product_id] += $quantity_change;
                // Optionally, you can add additional checks or database updates here
            }
        }
    }
}

?>

<style>
.profile {
    max-width: 100%;
    margin: 0 auto;
    font-family: 'Arial', sans-serif;
    text-align: center;
}

.profile h1 {
    margin: 20px;
    color: #333;
}

.cart-container {
    max-width: 800px;
    margin: 0 auto;
}

.product-card {
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 20px;
    overflow: hidden;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    transition: transform 0.3s;
}

.product-card:hover {
    transform: scale(1.05);
}

.product-image {
    width: 100%;
    max-height: 180px;
    object-fit: cover;
}

.product-details {
    padding: 15px;
}

.product-details h5 {
    margin-bottom: 10px;
    color: #333;
    font-size: 16px;
}

.product-details p {
    margin: 5px 0;
    color: #555;
    font-size: 14px;
}

.quantity-input {
    width: 100%;
    text-align: center;
    margin: 10px 0;
}

.btn-group {
    display: flex;
    justify-content: center;
}

.btn {
    color: #fff;
    text-decoration: none;
    cursor: pointer;
    padding: 8px 16px;
    border: none;
    border-radius: 5px;
    font-size: 14px;
}

.btn-danger {
    background-color: #dc3545;
}

.btn-success {
    background-color: #28a745;
}

.overall-total {
    margin-top: 20px;
}
</style>

<div class="profile">
    <h1>Shopping Cart</h1>

    <?php
    // Display cart contents
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        $totalPrice = 0;

        echo '<div class="cart-container">';

        foreach ($_SESSION['cart'] as $product_id => $quantity) {
            // Fetch product details from the database based on $product_id
            $query = "SELECT * FROM products WHERE sr_no = '$product_id'";
            $result = mysqli_query($conn, $query);

            if ($result && mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $pr_name = $row['pr_name'];
                    $price = $row['discounted_price'];

                    $sql = "SELECT *, GROUP_CONCAT(product_images.image_content) AS images
                            FROM products
                            JOIN product_images ON product_images.product_id = products.sr_no
                            WHERE `products`.`sr_no` = $product_id
                            GROUP BY products.sr_no";
                    $res = mysqli_query($conn, $sql);

                    if ($res && mysqli_num_rows($res) > 0) {
                        while ($pr = mysqli_fetch_assoc($res)) {
                            $img = $pr['image_content'];
                        }
                    }

                    // Calculate total price for each product
                    $productTotal = $price * $quantity;
                    $totalPrice += $productTotal;

                    // Display product information along with quantity and total price
                    ?>
    <div class="card product-card" data-product-id="<?php echo $product_id; ?>"
        data-product-price="<?php echo $price; ?>">
        <div class="row no-gutters">
            <div class="col-md-4">
                <img src="data:products/jpg;charset=utf8;base64,<?php echo base64_encode($img); ?>"
                    class="card-img product-image" alt="Product Image">
            </div>
            <div class="col-md-8">
                <div class="card-body product-details">
                    <h5 class="card-title"><?php echo $pr_name; ?></h5>
                    <p class="card-text"><strong>Price: Rs.</strong> <?php echo $price; ?>/-</p>
                    <div class="quantity-input" data-product-id="<?php echo $product_id; ?>">
                        <label>Quantity :</label>
                        <form action="cart.php" method="POST">
                            <div class="input-group">
                                <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">

                                <button type="submit" name="decrement"
                                    class=" btn btn-danger btn-number fa fa-minus"></button>
                                <input type="text" class="form-control input-number product-quantity" name="quantity"
                                    value="<?php echo $quantity; ?>" readonly>

                                <button type="submit" name="increment"
                                    class=" btn btn-success btn-number fa fa-plus"></button>
                            </div>
                        </form>

                    </div>

                    <p><strong>Total: Rs.</strong> <span class="product-total"><?php echo $productTotal; ?>/-</span></p>

                    <div class="btn-group">
                        <form action="cart.php" method="POST">
                            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
                            <button type="submit" name="remove_product" class="btn btn-danger"><b>Remove</b></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php
                }
            }
        }
        echo '</div>';

        // Display total price and Checkout button
        ?>
    <div class="overall-total">
        <p><strong>Overall Total: Rs.</strong><?php echo $totalPrice;?>/-</p>
    </div>
    <div class="btn-group">
        <a class="btn btn-success d-flex mt-2 justify-content-center" data-bs-toggle="modal"
            data-bs-target="#checkoutModal"><b>Checkout</b></a>
    </div>
</div>
<?php
    } else {
        echo '<p>Your cart is empty.</p>';
    }
    ?>
</div>


<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Checkout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                         $grandTotal = 0;
                        foreach ($_SESSION['cart'] as $product_id => $quantity) {
                            $query = "SELECT pr_name, discounted_price FROM products WHERE sr_no = '$product_id'";
                            $result = mysqli_query($conn, $query);

                            if ($result && mysqli_num_rows($result) > 0) {
                                $row = mysqli_fetch_assoc($result);
                                $pr_name = $row['pr_name'];
                                $price = $row['discounted_price'];
                                $productTotal = $price * $quantity;
                                $grandTotal += $productTotal;
                        ?>
                        <tr>
                            <td><?php echo $pr_name; ?></td>
                            <td><?php echo $quantity; ?></td>
                            <td><?php echo $price . ' X ' . $quantity.' = Rs. '.$price * $quantity; ?>/-</td>
                        </tr>
                        <?php
                            }
                        }
                        ?>
                        <tr>
                            <td colspan="2" class="text-end"><strong>Total:</strong></td>
                            <td><strong>Rs. <?php echo $grandTotal; ?>/-</strong></td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#userDetailsModal">Proceed</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Previous code remains unchanged -->

<?php
 if(isset($_SESSION['id'])){
 $usr= $_SESSION['id'];
   $sql1 = "SELECT * FROM `customers` WHERE `sr_no` = '$usr'";
$result1 = mysqli_query($conn, $sql1);
$num1 = mysqli_num_rows($result1);
if ($num1 > 0) {

  while ($row1 = mysqli_fetch_assoc($result1)) { 
    
    $name= $row1['cust_name'];
    $phone= $row1['cust_phone'];
    $email= $row1['cust_email'];
    $pincode= $row1['cust_pincode'];
    $address= $row1['cust_address'];
  }
}
 }
?>
<div class="modal fade modal-dialog-scrollable" id="userDetailsModal" data-bs-backdrop="static" data-bs-keyboard="false"
    tabindex="-1" aria-labelledby="userDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="mx-auto justify-content-center">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userDetailsModalLabel">User Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="userName" class="form-label">Name:</label>
                        <input type="text" class="form-control" id="userName" value="<?php echo $name;?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="userPhone" class="form-label">Phone:</label>
                        <input type="number" class="form-control" id="userPhone" value="<?php echo $phone;?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="userEmail" class="form-label">Email:</label>
                        <input type="email" class="form-control" id="userEmail" value="<?php echo $email;?>">
                    </div>

                    <div class="mb-3">
                        <label for="deliveryAddress" class="form-label">Delivery Address:</label>
                        <textarea class="form-control" id="deliveryAddress" rows="3" placeholder="Address"
                            required><?php echo $address;?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="pin" class="form-label">Pincode:</label>
                        <input type="text" class="form-control" id="pin" value="<?php echo $pincode;?>" required>
                    </div>
                    <input type="text" class="form-control" hidden id="usr" placeholder="Pincode"
                        <?php  echo 'value="'.$usr.'"'; ?>>
                    <?php
                    foreach ($_SESSION['cart'] as $product_id => $quantity) {
                        // Fetch product details from the database based on $product_id
                        $query = "SELECT * FROM products WHERE sr_no = '$product_id'";
                        $result = mysqli_query($conn, $query);
            
                        if ($result && mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                $price = $row['discounted_price'];
                                echo '<input type="text" class="form-control"  id="pr_id_'.$product_id.'" placeholder="Pincode" hidden value="'.$product_id.'">';
                                echo '<input type="text" hidden class="form-control"  id="qty" placeholder="Pincode" value="'.$quantity.'">';
                                echo '<input type="text"  class="form-control" hidden id="price_'.$product_id.'" placeholder="Pincode" value="'.$price * $quantity.'">';
                                echo '<input type="text" hidden class="form-control"  id="grandTotal" placeholder="Pincode" value="'.$grandTotal.'">';
                            }
                        }
                    }
                    ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                    <input type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#payNow"
                        value="Pay Now" />
                    <input type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#cod"
                        value="Cash On Delivery" />
                </div>
            </div>
        </form>
    </div>
</div>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
function pay_now() {
    // Fetch user details from the modal
    var user_name = jQuery('#userName').val();
    var user_phone = jQuery('#userPhone').val();
    var user_email = jQuery('#userEmail').val();
    var user_addr = jQuery('#deliveryAddress').val();
    var user_pin = jQuery('#pin').val();
    var user_id = jQuery('#usr').val();

    // Fetch cart details from the server or calculate them based on your cart
    var cartDetails = <?php echo json_encode($_SESSION['cart']); ?>;
    var grandTotal = jQuery('#grandTotal').val();
    var productDetails = [];

    // Iterate through each product in the cart
    for (var product_id in cartDetails) {
        // Fetch product details for the current product within the loop
        var pr_id = product_id;
        var quantity = cartDetails[product_id];
        var price = parseFloat(jQuery('#price_' + pr_id).val());




        // Add product details to the array
        productDetails.push({
            pr_id: pr_id,
            quantity: quantity,
            price: price


        });

        // Calculate total amount

    }

    // Create options for Razorpay
    var options = {
        key: "rzp_test_XkyAfIibqTU8Oz",
        amount: grandTotal * 100, // Convert totalAmount to paisa (Rupees to Paise conversion)
        currency: 'INR',
        name: 'Acme Corp',
        description: 'Test Transaction',
        image: 'https://image.freepik.com/free-vector/logo-sample-text_355-558.jpg',
        handler: function(response) {
            // Make an AJAX request to your server to handle the payment and order processing
            jQuery.ajax({
                type: 'post',
                url: 'razorpay_server.php', // Create this file to handle Razorpay server-side logic
                data: {
                    payment_id: response.razorpay_payment_id,
                    user_name: user_name,
                    user_phone: user_phone,
                    user_email: user_email,
                    user_addr: user_addr,
                    user_pin: user_pin,
                    user_id: user_id,
                    productDetails: JSON.stringify(productDetails)
                },
                success: function(result) {
                    if (result) {
                        // Unset or clear the cart


                        // Show SweetAlert for success
                        Swal.fire({
                            icon: "success",
                            title: "Order Placed Successfully",
                            text: "Thank you for your purchase. Your order has been placed successfully.",
                            confirmButtonColor: "#28a745",
                            confirmButtonText: "OK"
                        }).then(function() {
                            jQuery.ajax({
                                type: 'post',
                                url: 'partials/clear_cart.php', // Create a new PHP file to handle clearing the cart
                                success: function() {
                                    // Redirect to the appropriate page after clicking OK
                                    window.location.href = 'my_order.php';
                                }
                            });
                        });
                    } else {
                        // Handle the case when order placement fails
                        // You may display an error message or take other actions
                        console.log('Order placement failed');
                    }
                }
            });
        }
    };

    // Create a new Razorpay instance and open the checkout form
    var rzp1 = new Razorpay(options);
    rzp1.open();
}

function processCashOnDelivery() {
    // Fetch user details from the modal
    var user_name = jQuery('#userName').val();
    var user_phone = jQuery('#userPhone').val();
    var user_email = jQuery('#userEmail').val();
    var user_addr = jQuery('#deliveryAddress').val();
    var user_pin = jQuery('#pin').val();
    var user_id = jQuery('#usr').val();

    // Fetch cart details from the server or calculate them based on your cart
    var cartDetails = <?php echo json_encode($_SESSION['cart']); ?>;
    var grandTotal = jQuery('#grandTotal').val();
    var productDetails = [];

    // Iterate through each product in the cart
    for (var product_id in cartDetails) {
        // Fetch product details for the current product within the loop
        var pr_id = product_id;
        var quantity = cartDetails[product_id];
        var price = parseFloat(jQuery('#price_' + pr_id).val());

        // Add product details to the array
        productDetails.push({
            pr_id: pr_id,
            quantity: quantity,
            price: price
        });
    }

    // Make an AJAX request to your server to handle the Cash on Delivery order processing
    jQuery.ajax({
        type: 'post',
        url: 'codCartProcess.php', // Create this file to handle COD server-side logic
        data: {
            user_name: user_name,
            user_phone: user_phone,
            user_email: user_email,
            user_addr: user_addr,
            user_pin: user_pin,
            user_id: user_id,
            productDetails: JSON.stringify(productDetails)
        },
        success: function(result) {
            if (result) {
                // Unset or clear the cart
                jQuery.ajax({
                    type: 'post',
                    url: 'partials/clear_cart.php', // Create a new PHP file to handle clearing the cart
                    success: function() {
                        // Show SweetAlert for success
                        Swal.fire({
                            icon: "success",
                            title: "Order Placed Successfully",
                            text: "Order has been placed successfully...\n Our Executive will contact you soon for Confirmation.\nResult: " + result,
                            confirmButtonColor: "#28a745",
                            confirmButtonText: "OK"
                        }).then(function() {
                            // Redirect to the appropriate page after clicking OK
                            window.location.href = 'my_order.php';
                        });
                    }
                });
            } else {
                // Handle the case when order placement fails
                // You may display an error message or take other actions
                console.log('Order placement failed');
            }
        }
    });
}

</script>



<?php
include 'partials/payNow_confirm_modal.php';
include 'partials/cod_confirm_modal.php';
?>

<?php require 'footer.php'; ?>