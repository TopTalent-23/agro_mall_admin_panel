<?php
include ("../db_config.php");
$cafe_id = $_GET['cafe'];
$sql = "SELECT * FROM `orders`";
$result = mysqli_query($conn, $sql);
     $num = mysqli_num_rows($result);
     if ($num > 0) {
          echo '<table class="table table-bordered">'
           .'<th>Order id</th>'
           .'<th>Dish id</th>'
           .'<th>Dish Name</th>'
           .'<th>Table Number</th>'
           .'<th>Quantity</th>'
           .'<th>Customer id</th>'
           .'<th>Time</th>';
    while ($row = mysqli_fetch_assoc($result)) {
         echo '<tr>'
            .'<td>'.$order_id.'</td>'
            .'<td>'.$dish_id.'</td>'
            .'<td>'.$dish_name.'</td>'
            .'<td>'.$table_no.'</td>'
            .'<td>'.$quantity.'</td>'
            .'<td>'.$cust_id.'</td>'
            .'<td>'.$time.'</td>'
            .'</tr>';
        $dish_name=$row['dish_name'];
        $dish_id=$row['dish_id'];
        $cust_id=$row['customer_id'];
        $table_no=$row['table_no'];
        $quantity=$row['quantity'];
        $time=$row['time'];
        $order_id=$row['order_id'];
        
    }
    echo '</table>';
     }

    
   
?>     