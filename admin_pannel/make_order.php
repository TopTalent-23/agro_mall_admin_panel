<?php
session_start();

// Check if either 'salesman_logedin' or 'admin_logedin' is not set or falsy
if (!isset($_SESSION['admin_logedin']) && !isset($_SESSION['manager_logedin']) && !isset($_SESSION['salesman_logedin']))  {
    // Display an alert using JavaScript
    echo "<script>alert('You do not have access to this page. Please go back.')</script>";
  
    // Redirect the user to the previous page
    echo "<script>window.history.back();</script>";
  
    // Exit the script to prevent further execution
    exit();
  }
?>
<?php
include("../db_config.php");

$showCategories = "SELECT * FROM `categories`";
$resultCategories = mysqli_query($conn, $showCategories);

if (!$resultCategories) {
    die('Error: ' . mysqli_error($conn));
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Make Order</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://kit.fontawesome.com/c932d99d51.js" crossorigin="anonymous"></script>
    <style>
        .select2-container .select2-selection--single,
        .select2-container--default .select2-selection--single {
            height: 38px !important;
            border: 1px solid #ced4da !important;
            border-radius: 0.25rem !important;
            padding: 0.375rem 0.75rem !important;
        }
    </style>
</head>
<body>

<?php

include("navbar.php");
          
?>
<div class="container">
<section class="veg_section layout_paddingn mt-4">
<div class=" justify-content-between align-items-center mb-3">
        <h2 class="text-left">Make an Order</h2>
    </div>
<div class="row g-3 mt-4">
  <div class="col">
  <label for="name">Name:</label>
    <input type="text" id="name" class="form-control" >
  </div>
  <div class="col">
  <label for="phone">Phone:</label>
    <input type="number" id="phone" class="form-control" >
  </div>
  <div class="col">
  <label for="email">Email:</label>
    <input type="email" id="email" class="form-control" >
  </div>
</div>
<div class="row g-3 mt-4">
  <div class="col">
  <label for="address">Address:</label>
    <input type="text" id="address" class="form-control" >
  </div>
  <div class="col">
  <label for="pin">Pin:</label>
    <input type="number" id="pin" class="form-control" >
  </div>
  
</div>
    <div class="row mt-4">
        
        <form class="col-md-4">
            
            <label for="selectCategory">Select Category</label>
            <select id="selectCategory" class="form-control select2">
                <option>Select</option>
                <?php
                if ($resultCategories) {
                    while ($rowCategory = mysqli_fetch_assoc($resultCategories)) {
                        echo '<option value="' . $rowCategory['cat_id'] . '">' . $rowCategory['cat_name'] . '</option>';
                    }
                }
                ?>
            </select>
        </form>

        <form class="col-md-4" id="productsForm">
            <label for="selectProducts">Select Products</label>
            <select id="selectProducts" class="form-control select2" disabled>
                <option>Select a Category First</option>
                <!-- Options will be dynamically added here based on the selected category -->
            </select>
        </form>
        <div class="col-md-4">
            <label for="quantity">Quantity</label>
            <div class="quantity-input">
                <button id="decrease" class=" btn-danger" onclick="decreaseQuantity()"><b>-</b></button>
                <input id="quantity" type="text" value="1" readonly>
                <button id="increase" class=" btn-success" onclick="increaseQuantity()"><b>+</b></button>
            </div>
            

        </div>
        <div class="col-md-4">
        <button class="btn btn-success mt-4 mb-4" onclick="addProduct()">Add Product</button>
    </div>
    </div>
    
    <table class="table mt-2" id="orderTable">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Quantity</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody id="orderBody">
            <!-- Table rows for added products will go here -->
        </tbody>
        
    </table>
    <div >
        <h5 id="totalAmount"> </h5>
    </div>
    <div class="row g-3 mt-4">
    <div class="col">
        <label for="paymentStatus">Payment Status:</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="paymentStatus" id="pending" value="pending" checked>
            <label class="form-check-label" for="pending">
                Pending
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="paymentStatus" id="complete" value="complete">
            <label class="form-check-label" for="complete">
                Complete
            </label>
        </div>
    </div>
    <div class="col">
        <label for="paymentMode">Payment Mode:</label>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="paymentMode" id="cash" value="cash" checked>
            <label class="form-check-label" for="cash">
                Cash
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="paymentMode" id="upi" value="upi">
            <label class="form-check-label" for="upi">
                UPI
            </label>
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="paymentMode" id="none" value="none">
            <label class="form-check-label" for="none">
                None
            </label>
        </div>
    </div>
</div>

    <button class="btn btn-success mt-4 mb-4" onclick="placeOrder()">Place Order</button>

</div>

<script>
    $(document).ready(function() {
        $('#placeOrderButton').prop('disabled', true);

    $('.select2').select2();

    // Enable Place Order button when both category and product selections are completed
    function enablePlaceOrderButton() {
        $('#placeOrderButton').prop('disabled', false);
    }
        $('.select2').select2();

           // Handle category selection
           $('#selectCategory').on('change', function () {
    var categoryId = $(this).val();
    if (categoryId !== 'Select') {
        // Clear existing options before fetching new ones
        $('#selectProducts').empty();
        // Enable and fetch products based on the selected category
        $('#selectProducts').prop('disabled', false);
        fetchProducts(categoryId, enablePlaceOrderButton);
    } else {
        // If "Select" is chosen, disable products dropdown
        $('#selectProducts').prop('disabled', true).val('Select a Category First');
    }
});
    function fetchProducts(categoryId) {
        // Fetch products based on the selected category
        $.ajax({
            url: 'partials/get_products.php',
            method: 'POST',
            data: { categoryId: categoryId },
            success: function(data) {
                    console.log("Raw response:", data);

                    // No need to parse the data since it's already an object
                    var productsData = data;

                    // Clear existing options
                    $('#selectProducts').empty();

                    // Add new options based on the fetched data
                    for (var i = 0; i < productsData.length; i++) {
                var option = '<option value="' + productsData[i].sr_no + '" data-discounted_price="' + productsData[i].discounted_price + '">' + productsData[i].pr_name + '</option>';
                $('#selectProducts').append(option);
            }

                    // Trigger Select2 to update the UI
                    $('#selectProducts').trigger('change');
                    enablePlaceOrderButton();
                },
                error: function() {
                    alert('Error fetching products');
                }
            });
        }
// Disable payment mode by default
$('input[name="paymentMode"]').prop('disabled', true);

// Set default values when payment status is 'pending'
$('input[name="paymentStatus"][value="pending"]').prop('checked', true);
$('input[name="paymentMode"][value="none"]').prop('checked', true);

// Handle payment status change
$('input[name="paymentStatus"]').on('change', function() {
    var paymentStatus = $(this).val();
    var paymentModeInput = $('input[name="paymentMode"]');

    // Enable or disable payment mode based on payment status
    paymentModeInput.prop('disabled', paymentStatus === 'pending');

    // If the status is 'complete', check the first payment mode option
    if (paymentStatus === 'complete') {
        // Assuming your payment mode options have IDs like 'cash' and 'upi'
        $('#cash').prop('checked', true);
        // You can also use the following line to check the first available payment mode
        // paymentModeInput.first().prop('checked', true);
    } else {
        // Check the 'None' option if the status is 'pending'
        $('#none').prop('checked', true);
        // You can also use the following line to check the first available payment mode
        // paymentModeInput.first().prop('checked', true);
    }
});



    });
    function increaseQuantity() {
        var quantityInput = document.getElementById('quantity');
        var currentQuantity = parseInt(quantityInput.value);
        quantityInput.value = currentQuantity + 1;
    }

    function decreaseQuantity() {
        var quantityInput = document.getElementById('quantity');
        var currentQuantity = parseInt(quantityInput.value);
        if (currentQuantity > 1) {
            quantityInput.value = currentQuantity - 1;
        }
    }
    var totalAmount = 0;
function addProduct() {
    var selectedProduct = $('#selectProducts option:selected');
    var productName = selectedProduct.text();
    var quantity = parseInt($('#quantity').val());
    var price = parseFloat(selectedProduct.data('discounted_price'));
    var totalPrice = quantity * price;
    var productID = selectedProduct.val();
    var categoryID = $('#selectCategory').val(); // Store the category ID

    // Add a new row to the order table with both product and category IDs
    var newRow = '<tr data-product-id="' + productID + '" data-category-id="' + categoryID + '"><td>' + productName + '</td><td>' + quantity + '</td><td>' + totalPrice + '</td><td><button class="btn btn-danger btn-sm" onclick="deleteProduct(this)">Delete</button></td></tr>';
    $('#orderBody').append(newRow);

    // Update the total amount
    totalAmount += totalPrice;
    updateTotalAmount();
}

    
function deleteProduct(button) {
    // Find the closest row and remove it
    var row = $(button).closest('tr');
    var price = parseFloat(row.find('td:nth-child(3)').text());
    totalAmount -= price;
    updateTotalAmount();

    // Use the stored product ID to remove the correct row
    var productID = row.data('product-id');
    $('#orderBody tr[data-product-id="' + productID + '"]').remove();
}


function updateTotalAmount() {
    $('#totalAmount').text('Total Amount: ' +'       Rs.' + totalAmount +'/-');
}
function placeOrder() {
        $('#placeOrderButton').prop('disabled', true);

// Display a loading spinner
Swal.fire({
            title: 'Placing Order...',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        var customerDetails = {
            name: $('#name').val(),
            phone: $('#phone').val(),
            email: $('#email').val(),
            address: $('#address').val(),
            pin: $('#pin').val()
        };

    var products = [];
    $('#orderBody tr').each(function () {
        var productName = $(this).find('td:first').text();
        var quantity = $(this).find('td:nth-child(2)').text();
        var price = $(this).find('td:nth-child(3)').text();
        var productID = $(this).data('product-id');
       // var categoryID = $(this).data('category-id');

        products.push({
            productID: productID,
          //  categoryID: categoryID, // Include category ID
            quantity: quantity,
            price: price
        });
    });

    var paymentStatus = $('input[name="paymentStatus"]:checked').val();
    var paymentMode = $('input[name="paymentMode"]:checked').val();
    
        // Send an AJAX request to place_order.php
        $.ajax({
        url: 'partials/place_order.php',
        method: 'POST',
        data: {
            name: customerDetails.name,
            phone: customerDetails.phone,
            email: customerDetails.email,
            address: customerDetails.address,
            pin: customerDetails.pin,
            products: products,
            paymentStatus: paymentStatus,
            paymentMode: paymentMode
        },
        dataType: 'json',
        success: function(response) {
            console.log('Order placed successfully');
            console.log('Order ID:', response.orderID);
            var orderID = response.orderID;
            // Close the loading spinner
            Swal.close();

            // Display SweetAlert for success with a button to clear inputs
            Swal.fire({
                icon: 'success',
                title: 'Order Placed Successfully!',
                showConfirmButton: false,
                timer: 1000
            }).then(() => {
                // Redirect to the invoice page with the order ID
                setTimeout(() => {
        location.reload();
        // Redirect to the invoice page with the order ID
        window.location.href = 'partials/invoice.php?orderID=' + response.orderID;
    }, 100);

            });

            // Clear input fields and reset total amount
            clearInputs();
        },
        error: function() {
    console.error('Error placing order',error);

    // Close the loading spinner
    Swal.close();

    // Display SweetAlert for error with a button to try again
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: 'There was an error placing your order. Please try again.',
        showConfirmButton: true,
        confirmButtonText: 'Try Again',
        didClose: function() {
            // Enable the Place Order button on close
            $('#placeOrderButton').prop('disabled', false);
        }
    });
}

    });
    }
    function clearInputs() {
    $('#name').val('');
    $('#phone').val('');
    $('#email').val('');
    $('#address').val('');
    $('#pin').val('');
    $('#selectCategory').val('Select').trigger('change');
    $('#quantity').val('1');
    $('#orderBody').empty();
    totalAmount = 0; // Set total amount to zero
    updateTotalAmount();

    $('input[name="paymentStatus"]').prop('checked', false);
    $('input[name="paymentMode"]').prop('checked', false);
}
</script>
<footer>
    Admin Panel &copy; <?php echo date('Y'); ?> Ahire Agro Mall
</footer>
<script>
   $(document).ready(function () {
    $("#sidebarCollapse").on("click", function () {
        $("#sidebar").toggleClass("active");
        $("#content").toggleClass("active");
        $(".custom-navbar").toggleClass("active");
    });
   


       
    });

</script>

</body>
</html>
<!-- 

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>

</body>
</html> -->
