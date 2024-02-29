<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Page Title</title>
    <!-- Include SweetAlert library CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10/dist/sweetalert2.min.css">
    <!-- Include your custom CSS stylesheets if needed -->
    <!-- <link rel="stylesheet" href="path/to/your/styles.css"> -->
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>
    <?php
    $showerror = false;
    $signup = false;
    require '../db_config.php';
    $path = $_SERVER['HTTP_REFERER'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $pincode = $_POST['pincode'];
        $password = $_POST['password'];

        // Check for duplicate entries
        $checkQuery = "SELECT * FROM `customers` WHERE `cust_email` = '$email' OR `cust_phone` = '$phone'";
        $checkResult = mysqli_query($conn, $checkQuery);

        if (mysqli_num_rows($checkResult) > 0) {
            echo '<script>
                    Swal.fire({
                        title: "Error",
                        text: "Email or Phone Already Exist",
                        text: "Please login.",
                        icon: "error"
                    }).then(function() {
                        window.location.href = "'.$path.'";
                    });
                 </script>';
            $showerror = true;
            exit();
        }

        $hash_password = password_hash($password, PASSWORD_DEFAULT);

        $sql = "INSERT INTO `customers` (`password`, `cust_name`, `cust_address`, `cust_phone`, `cust_email`, `cust_pincode`) VALUES ('$hash_password', '$name', '$address', '$phone', '$email', '$pincode')";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            // Display SweetAlert after successful signup
            echo '<script>
                    Swal.fire({
                        title: "Signup successful!",
                        text: "Please login.",
                        icon: "success"
                    }).then(function() {
                        window.location.href = "'.$path.'";
                    });
                 </script>';
            exit();
        } else {
            echo '
            <script>
                    Swal.fire({
                        title: "Error",
                        text: "Signup failed",
                        icon: "error"
                    }).then(function() {
                        window.location.href = "'.$path.'";
                    });
                 </script>';
            $showerror = true;
            exit();
        }
    } else {
        $path = $_SERVER['HTTP_REFERER'];
    }
    ?>
    <!-- Your HTML content goes here -->

    <!-- Include SweetAlert library JS -->
  
    <!-- Include your JavaScript code -->
    <script>
        // Your JavaScript code with SweetAlert
        // For example:
        console.log("Script is running");

        // Simple SweetAlert test
        // Uncomment the following line to test SweetAlert
        // Swal.fire("Hello, this is a basic SweetAlert!");

        // Your other JavaScript code goes here
    </script>
</body>

</html>
