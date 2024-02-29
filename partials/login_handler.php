<?php
$logedin = false;
$error = false;
$path = $_SERVER['HTTP_REFERER'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include '../db_config.php';
    include '../header.php';

    $email = isset($_POST['email']) ? $_POST['email'] : null;
    $phone = isset($_POST['phone']) ? $_POST['phone'] : null;
    $password = $_POST['password'];

    if ($email) {
        $sql = "SELECT * FROM `customers` WHERE cust_email = '$email'";
    } elseif ($phone) {
        $sql = "SELECT * FROM `customers` WHERE cust_phone = '$phone'";
    }

    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);

    if ($num == 1) {
        $row = mysqli_fetch_assoc($result);

        if (password_verify($password, $row['password'])) {
            $_SESSION['logedin'] = true;
            $_SESSION['id'] = $row['sr_no'];

            // Debug statement
            echo '<script>console.log("Executing Swal.fire() for success");</script>';

            // SweetAlert success message with redirection
            echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Login successful',
                        icon: 'success',
                        timer: 1000, // Set the timer in milliseconds (1 second)
                        showConfirmButton: false // Hide the  button
                    }).then(() => {
                        window.location.replace('".$path."');
                    });
                  </script>";
        } else {
            // Handle login error
            $error = true;
            echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Password not match',
                        icon: 'error',
                        timer: 1000, // Set the timer in milliseconds (1 second)
                        showConfirmButton: false // 
                    }).then(() => {
                        window.location.replace('".$path."');
                    });
                  </script>";
        }
    } else {
        // Handle user not found
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'User not found',
                    icon: 'error',
                    timer: 1000, // Set the timer in milliseconds (1 second)
                    showConfirmButton: false // 
                }).then(() => {
                    window.location.replace('".$path."');
                });
              </script>";
}
}
include '../footer.php';
?>
