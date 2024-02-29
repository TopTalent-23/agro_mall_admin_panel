<?php
include('db_config.php');
date_default_timezone_set('Asia/Kolkata');
$sql = "SET time_zone = '+05:30'";
mysqli_query($conn, $sql);
function generateOrderID() {
    // Get the current timestamp
    $timestamp = time();

    // Generate a random number between 1000 and 9999
    $randomNumber = mt_rand(1000, 9999);

    // Generate a unique identifier using uniqid()
    $uniqueID = uniqid();

    // Concatenate the timestamp, random number, and unique identifier
    $orderID = 'ORD-' . $randomNumber . $uniqueID;

    // Return the generated order ID
    return $orderID;
}

// Example usage
$orderID = generateOrderID();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve form inputs
  $name = $_POST['name'];
  $phone = $_POST['phone'];
  $email = $_POST['email'];
  $quantity = $_POST['quantity'];
  $address = $_POST['address'];
  $pincode = $_POST['pincode'];
  $pr_id = $_POST['pr_id'];
  $price = $_POST['amt'];
  $usr = $_POST['usr'];
  $amt = $quantity * $price;
  $payment_status = "pending";
  $payment_mode = "Cash-On-Delivery";
 

  // Validate form inputs
 
  $errors = array();

  if (empty($name)) {
    $errors[] = "Name is required";
  }

  if (empty($phone)) {
    $errors[] = "Phone number is required";
  }

  if (empty($quantity)) {
    $errors[] = "Quantity is required";
  }

  if (empty($address)) {
    $errors[] = "Address is required";
  }

  if (empty($pincode)) {
    $errors[] = "Pincode is required";
  }

  // Perform any additional validation checks as needed

  // Check if there are any validation errors
  if (!empty($errors)) {
    // Display the errors or handle them as desired
    foreach ($errors as $error) {
    
      echo '<script> alert("'.$error.'")</script>';
    }
    exit; // Stop further execution if there are errors
  }

  // If there are no validation errors, process the cash on delivery order
  // Perform any necessary actions, such as storing order details in the database or sending email notifications

  // Connect to the database
  

 

  // Prepare the SQL statement to insert the order details into the database
  $sql = "INSERT INTO `orders` (`order_id`, `usr_id`, `product_id`, `name`, `phone_no`, `email`, `quantity`, `address`, `pin`, `payment_status`, `payment_mode`, `amount`,`shopVisit`,`payid`, `order_status`, `date_time`)
        VALUES ('$orderID', '$usr', $pr_id, '$name', '$phone', '$email', '$quantity', '$address', '$pincode', '$payment_status', '$payment_mode', '$amt','-','-', 'not_confirmed', NOW())";

  // Execute the SQL statement
  if ($conn->query($sql) === TRUE) {
     echo '<script> alert("Order Placed Successfully...")</script>';
     
      echo "<script>window.location.href='my_order.php';</script>";
     
     
  
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
    echo '<script> alert("Order Failed")</script>';
  }

  // Close the database connection
  $conn->close();
} else {
  // Redirect the user to the appropriate page if accessed directly
  header('Location: my_order.php');
  exit;
}
?>
