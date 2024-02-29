<?php 
   $connect=mysqli_connect("localhost","root","","project") or die("could not connect");
   if(!$connect){ 
     echo "dbugging error:".mysqli_connect_error();
   }
   
  
?>
