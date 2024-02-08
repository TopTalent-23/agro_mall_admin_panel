<?php
require 'header.php';

// Check if the form was submitted
if (isset($_POST['button'])) {
    $name = $_POST['name'];
    $phone = $_POST['pno'];
    $email = $_POST['email'];
    $address = $_POST['addr'];
    $pincode = $_POST['pin'];

    // Update the profile details in the database
    $usr = $_SESSION['id'];
    $sql = "UPDATE `customers` SET `cust_name`='$name', `cust_phone`='$phone', `cust_email`='$email', `cust_pincode`='$pincode', `cust_address`='$address' WHERE `sr_no`='$usr'";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        echo '<script>alert("Profile updated successfully.")</script>';
        // Update the values in the session
       
        // Redirect to the profile page to reflect the updated details
        
        
    } else {
        echo '<script>alert("Email or Phone already exist....")</script>';
    }
}

// Retrieve the profile details from the session
if (isset($_SESSION['id'])) {
    $usr = $_SESSION['id'];
    $sql1 = "SELECT * FROM `customers` WHERE `sr_no` = '$usr'";
    $result1 = mysqli_query($conn, $sql1);
    $num1 = mysqli_num_rows($result1);

    if ($num1 > 0) {
        while ($row1 = mysqli_fetch_assoc($result1)) {
            $name = $row1['cust_name'];
            $phone = $row1['cust_phone'];
            $email = $row1['cust_email'];
            $pincode = $row1['cust_pincode'];
            $address = $row1['cust_address'];
        }
    }
}
?>

<style>
    .profile {
        width: 400px;
        margin: 0 auto;
        border: 2px solid #ccc;
        padding: 20px;
        font-family: Arial, sans-serif;
        align-items: center;
    }

    .profile h1 {
        text-align: center;
        margin-bottom: 30px;
        font-family: Arial, sans-serif;
    }
    .profile td{
      margin-right: 20px ;
    }

    .profile p {
        margin-bottom: 20px;
        font-family: Arial, sans-serif;
    }
</style>

<div class="profile">
    <h1>My Profile</h1>
    <table><tr><th>
    <p><strong>Name:</strong></th> <td><?php echo $name; ?></p></td></tr><tr><th>
    <p><strong>Phone Number:</strong></th> <td> <?php echo $phone; ?></p></td></tr><tr><th>
    <p><strong>Email:</strong> </th> <td><?php echo $email; ?></p></td></tr><tr><th>
    <p><strong>Pin Code:</strong> </th> <td><?php echo $pincode; ?></p></td></tr><tr><th>
    <p><strong>Address:</strong> </th> <td><?php echo $address; ?></p></td></tr></table>
    <p><a class="btn btn-success d-flex mt-2 justify-content-center" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><b>Update Profile</b></a></p>
</div>

<div class="modal fade modal-dialog-scrollable" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="mx-auto justify-content-center" action="profile.php" method="POST">
                    <div class="mb-3">
                        <input type="text" class="form-control" id="name" aria-describedby="emailHelp" name="name" value="<?php echo $name; ?>" placeholder="Your Name">
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="pno" name="pno" value="<?php echo $phone; ?>" placeholder="Phone Number">
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" placeholder="Email">
                    </div>
                    <div class="mb-3">
                        <textarea class="form-control" id="addr" name="addr" rows="3" placeholder="Address"><?php echo $address; ?></textarea>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" id="pin" name="pin" value="<?php echo $pincode; ?>" placeholder="Pincode">
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" class="btn btn-success" value="Update" name="button">
            </div>
            </form>
        </div>
    </div>
</div>
<?php
require 'footer.php';

?>