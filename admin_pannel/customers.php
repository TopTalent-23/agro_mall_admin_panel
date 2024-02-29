<?php
session_start();
if (!isset($_SESSION['admin_logedin']) && !isset($_SESSION['manager_logedin']) && !isset($_SESSION['executiveOfficer_logedin']))  {
    // Display an alert using JavaScript
    echo "<script>alert('You do not have access to this page. Please go back.')</script>";
  
    // Redirect the user to the previous page
    echo "<script>window.history.back();</script>";
  
    // Exit the script to prevent further execution
    exit();
  }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Customers</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="css/admin.css">
    <script src="https://kit.fontawesome.com/c932d99d51.js" crossorigin="anonymous"></script>
    <style>
/* CSS for row hover effect */
.table-row-hover:hover {
    background-color: blanchedalmond !important; /* Change background color on hover */
}
</style>
</head>
<body>
<?php include("navbar.php"); 
include("../db_config.php");
$query = "SELECT * FROM customers";
$result = mysqli_query($conn, $query);
?>

<div class="content mt-5">
    <h2>Customers</h2>

    
    <!-- Display Orders in Table -->
    <table class="table m-3">
    <thead>
        <tr>
            <th>Sr.no</th>
            <th>Name</th>
            <th>Phone</th>
            <th>email</th>
            <th>Address</th>
            <th>Pincode</th>
            <th>Date and Time</th>
        </tr>
    </thead>
    <tbody>
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr class='table-row-hover'>";
            echo "<td>" . $row['sr_no'] . "</td>";
            echo "<td>" . $row['cust_name'] . "</td>";
            echo '<td><a href="tel:' . $row['cust_phone'] . '">' . $row['cust_phone'] . '</a></td>';
            echo '<td><a href="mailto:' . $row['cust_email'] . '">' . $row['cust_email'] . '</a></td>';
            echo "<td>" . $row['cust_address'] . "</td>";
            echo "<td>" . $row['cust_pincode'] . "</td>";
            echo "<td>" . $row['datetime'] . "</td>";
            echo "</tr>";
        }
        ?>
    </tbody>
</table>


   
</div>

<footer>
    Admin Panel &copy; <?php echo date('Y'); ?> Ahire Agro Mall
</footer>


<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>

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
