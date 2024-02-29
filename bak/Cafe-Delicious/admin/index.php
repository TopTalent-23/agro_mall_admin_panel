<?php

include ("header.php");
$cafe_id = $_GET['cafe'];

?>




 <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script>
    

        var conn = new WebSocket('ws://localhost:8080');
        conn.onopen = function(e) {
            console.log("Connection established!");
        };
       
        conn.onmessage = function(e) {
            var getData = jQuery.parseJSON(e.data);
              var html = '<table class="table table-bordered"><th>Dish id</th> <th>Dish Name</th><th>Table Number</th>  <th>Quantity</th>  <th>Customer id</th>  <th>Time</th><tr><td> '+getData.dish_id+'</td><td>'+getData.dish_name+'</td><td>'+getData.table_no+'</td><td>'+getData.quantity+'</td><td>'+getData.cust_id+'</td><td></td></tr></table>';
            jQuery('#displaydata').append(html);
        };

         jQuery('#order').click(function() {
            var cafe_id = jQuery('#cafe_id').val();
            var dish_id = jQuery('#dish_id').val();
            var dish_name = jQuery('#dish_name').val();
            var cust_id = jQuery('#cust_id').val();
            var table_no = jQuery('#table_no').val();
            var quantity = jQuery('#quantity').val();
           
            
            var content = {
                cafe_id: cafe_id,
                dish_id: dish_id,
                dish_name: dish_name,
                cust_id: cust_id,
                table_no: table_no,
                quantity: quantity

            };
            conn.send(JSON.stringify(content));
            var html = '<table class="table table-bordered"><th>Dish id</th> <th>Dish Name</th><th>Table Number</th>  <th>Quantity</th>  <th>Customer id</th>  <th>Time</th><tr><td> '+dish_id+'</td><td>'+dish_name+'</td><td>'+table_no+'</td><td>'+quantity+'</td><td>'+cust_id+'</td><td></td></tr></table>';
            jQuery('#displaydata').append(html);
             jQuery('#cafe_id').val('');
            jQuery('#dish_id').val('');
            jQuery('#dish_name').val('');
            jQuery('#cust_id').val('');
            jQuery('#table_no').val('');
            jQuery('#quantity').val('');
        });
      
    </script>
<h1><b>Orders</b></h1>
<div id="displaydata">
</div>







<?php

include ("footer.php");
if ($logedin == false) {
    include "partials/loginModal.php";

}
?>