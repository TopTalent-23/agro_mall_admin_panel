<?php
include "header.php";
if (!isset($_SESSION['id'])){
   echo "<script>window.location.href='register.php';</script>";
}else{
   $session_id=$_SESSION['id'];
}
$sqlcmd="SELECT sell.id, sell.city, sell.pin, sell.description, sell.bed_price, sell.bed_available, sell.Address, sell.mno, sell.Address, sell.pin, sell.amount, sell.sellid, GROUP_CONCAT(img_upload.img_name) AS images
FROM sell
JOIN img_upload ON img_upload.id = sell.id WHERE sell.sellid=$session_id
GROUP BY sell.id
";
$result=mysqli_query($connect,$sqlcmd);
?>

   <div class="back_re mt-2">
      <div class="container">
         <div class="row">
            <div class="col-md-12">
               <div class="title"> 
                  <h2>My Rooms</h2>
               </div>
            </div>
         </div>         
      </div>
   </div>
    
   <div class="container mt-2">
      <table border="5" height="100%" width="100%">
         <tr style="outline:thin solid">
            <th>Image</th>
            <th>Area</th>
            <th>Total Price</th>
            <th>Update</th>
            <th>Delete</th>   
         </tr>
         <?php   
      if (mysqli_num_rows($result)>0) {
         while ($row=mysqli_fetch_array($result)) {
            $id=base64_encode($row['id']);
      ?>
         <tr style="outline:thin solid">
             <td><a href="room_detailed.php?id=<?php echo $id; ?>"><?php echo '<img class="flex-shrink-0 img-fluid rounded" src="data:image/jpeg;base64,'.base64_encode($row['images']).'" height="100px" width="100px"/>'; ?></a></td>
            <td><h5 class="d-flex justify-content-between  pb-2">
                                                <span class="mt-2 fs-4" ><?php echo $row['city']; ?></span></h5></td>
            <td><h5 class="d-flex justify-content-between  pb-2">
                                                <span class="mt-2 fs-4" ><?php echo $row['bed_price'] * $row['bed_available']; ?></span></h5></td>                                    
        
            <td><a href="room_update.php?id=<?php echo $id; ?>" class="btn btn-success">Update</a></td>
            <td><a href="delete_room.php?id=<?php echo $id; ?>" class="btn btn-danger">Delete</a></td>
         </tr>
         <?php } } ?>
      </table>
   </div>                 
<?php
include "footer.php";
?>