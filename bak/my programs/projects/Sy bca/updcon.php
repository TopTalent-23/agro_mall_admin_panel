<?php
    $Roll_no = $_POST['roll_no'];
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {


        $Roll_no = $_POST['roll_no'];
        if ($Roll_no==0) {
            echo ' ';
        }


        $servername = 'localhost';
        $username = 'root';
        $passwd = '';
        $database = 'bhavesh';

        //create a connection
        $conn = mysqli_connect($servername, $username, $passwd, $database);

        $sql = "SELECT * FROM `sy_bca_students` WHERE Roll_no ='$Roll_no'";
        $result = mysqli_query($conn, $sql);
        $num = mysqli_num_rows($result);

       if ($num > 0) {
            



            if (isset($_POST['update'])) {

                $Roll_no = $_POST['roll_no'];
                $name = $_POST['name'];
                $roll_no = $_POST['roll_no'];
                $email_id = $_POST['email_id'];
                $phone_no = $_POST['phone_no'];
                $address = $_POST['address'];
                $i_sem_sgpa = $_POST['i_sem_sgpa'];
                $ii_sem_sgpa = $_POST['ii_sem_sgpa'];
                $fy_cgpa = $_POST['fy_cgpa'];


                
                $sql = "UPDATE `sy_bca_students` SET `Name` = '$name', `Roll_no` = '$roll_no', `Phone_no` = '$phone_no', `Email_id` = '$email_id', `Address` = '$address', `I_sem-sgpa` = '$i_sem_sgpa', `II_sem_sgpa` = '$ii_sem_sgpa', `FY_cgpa` = '$fy_cgpa' WHERE `sy_bca_students`.`Roll_no` = '$roll_no'";
                $result = mysqli_query($conn, $sql);
                if ($result) {
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success</strong>  Your record has been updated  successfully...
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <a class="btn btn-primary" href="sybca.php" role="button">Home</a>
    </div>';
    echo '<div class="container mt-4">
        <h2>Please enter your roll no for updating your record</h2>

        <form action="update.php" method="post">
            <div class="column mt-4">

                <div class="col mt-4">
                    <input type="number" class="form-control" placeholder="Your roll no. here" name="roll_no">
                </div>

                <div class="container mt-4 mb-4">
                    <button type="submit" class="btn btn-primary">Check</button>
                </div>
            </div>
        </form>
    </div>';
                } 
                else {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Error</strong> Your record has been not updated successfully due to this error ' . mysqli_error($conn).'
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    echo '<div class="container mt-4">
        <h2>Please enter your roll no for updating your record</h2>

        <form action="update.php" method="post">
            <div class="column mt-4">

                <div class="col mt-4">
                    <input type="number" class="form-control" placeholder="Your roll no. here" name="roll_no">
                </div>

                <div class="container mt-4 mb-4">
                    <button type="submit" class="btn btn-primary" >Check</button>
                </div>
            </div>
        </form>
    </div>';
                }

           die; }

            while ($row = mysqli_fetch_assoc($result)) {

            
                echo '<div class="container mt-4">
    <h2>Check your details</h2>
<form action="update.php" method="post">
<div class="column mt-4">
  <div class="column mt-4">
  <h5>Your Name</h5>
    <input type="text" class="form-control" value="'. $row['Name'].'" name="name">
  </div>
  <div class="col mt-4">
  <h5>Roll no.</h5>
    <input type="number" class="form-control" value="'. $row['Roll_no'].'" name="roll_">
  </div>
  <div class="col mt-4">
  <h5>Email</h5>
    <input type="email" class="form-control" value="'. $row['Email_id'].'" name="email_id">
  </div>
  <div class="col mt-4">
  <h5>Phone no.</h5>
    <input type="number" class="form-control" value="'. $row['Phone_no'].'" name="phone_no">
  </div>
  <div class="col mt-4">
  <h5>Address</h5>
      <textarea name="address" class="form-control" rows="8" cols="40">'. $row['Address'].'</textarea>
  </div>
  <div class="col mt-4">
  <h5>1st sem sgpa</h5>
    <input type="text" class="form-control" value="'. $row['I_sem-sgpa'].'" name="i_sem_sgpa">
  </div>
  <div class="col mt-4">
  <h5>2nd sem sgpa</h5>
    <input type="text" class="form-control" value="'. $row['II_sem_sgpa'].'" name="ii_sem_sgpa">
  </div>
  <div class="col mt-4">
  <h5>Fy cgpa</h5>
    <input type="text" class="form-control" value="'. $row['FY_cgpa'].'" name="fy_cgpa">
  </div>
  <div class="container mt-4 mb-4">
  <button type="submit" class="btn btn-primary" name="update">Update</button>
</div>
</div>
</form>
</div>';
            }


        }
        
        else {
             echo '<div class="container mt-4">
        <h2>Sorry...</h2>
        <h3>Record not found</h3>
        </div>';
        }
    }
    else {
    echo '<div class="container mt-4">
        <h2>Please enter your roll no for updating your record</h2>

        <form action="update.php" method="post">
            <div class="column mt-4">

                <div class="col mt-4">
                    <input type="number" class="form-control" placeholder="Your roll no. here" name="roll_no">
                </div>

                <div class="container mt-4 mb-4">
                    <button type="submit" class="btn btn-primary" >Check</button>
                </div>
            </div>
        </form>
    </div>';
    }
    ?>