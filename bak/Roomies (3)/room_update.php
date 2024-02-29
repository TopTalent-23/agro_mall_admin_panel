<?php

  include 'header.php';
  if (!isset($_SESSION['id']) && !isset($_GET['id'])) {
    echo "<script>window.location.href='register.php';</script>";
 }
 $id1=$_GET['id'];
 $id= base64_decode($_GET['id']) ;
 $sqlcmd="SELECT sell.id, sell.city, sell.pin, sell.description, sell.bed_price, sell.bed_available, sell.Address, sell.mno, sell.Address, sell.pin, sell.amount, sell.sellid, GROUP_CONCAT(img_upload.img_name) AS images
 FROM sell
 JOIN img_upload ON img_upload.id = sell.id WHERE sell.id=$id
 GROUP BY sell.id;
  ";
$result=mysqli_query($connect,$sqlcmd);
if (mysqli_num_rows($result)>0) {
  $row=mysqli_fetch_assoc($result);
}else{
  echo "<script>window.location.href='index.php';</script>";
}


?>

    <!-- <div class="container py-5">
      <div class="row">
        <div class="col-md-6">
          <a href="sell.php?" class="btn btn-danger">Private Room</a>
        </div>
        <div class="col-md-6">    
          <a href="" class="btn btn-danger">Sharing Room</a>
        </div>
      </div>
    </div> -->
    <div class="back_re mt-2">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="title">
                      <h2>Update Your Room</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>



      <?php
  if (isset($_POST['submit']) && isset($_GET['id'])) {
    $id2=base64_decode($_GET['id']) ;
    $abed=$_POST['abed'];
    $bprice=$_POST['bprice'];
    $city=$_POST['city'];
    $address=$_POST['area'];
    $pin=$_POST['pin'];
    $mno=$_POST['mno'];
    $description=$_POST['description'];
    echo $description;
    echo $abed;
    // $sql = "UPDATE `sell` SET `bed_available` = $abed, `bed_price` = $bprice,  `city` = '$city', `Address` = '$address' , `description` = '$description', `pin` = '$pin', `mno` = $mno,  WHERE `id` = $id2";
    //$sql = "UPDATE `sell` SET `bed_available` = '$abed', `bed_price` = '$bprice', `city` = '$city', `Address` = '$address', `description` = '$description', `pin` = '$pin', `mno` = '$mno' WHERE `sell`.`id` = $id2";
    $sql="UPDATE `sell` SET `bed_available` = '$abed', `bed_price` = '$bprice', `city` = '$city', `Address` = '$address', `description` = '$description', `pin` = '$pin', `mno` = '$mno' WHERE `sell`.`id` = $id2";
    $res1=mysqli_query($connect,$sql);
      echo '<script> alert("Room Details Updated Successfully");</script>';
      echo "<script>window.location.href='my_rooms.php';</script>";
  }
?>


    <div class="container py-5">
    <form action="room_update.php?id=<?php echo $id1; ?>" enctype="multipart/form-data" method="POST">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Available bed</label>
      <input type="number" value="<?php echo $row['bed_available']; ?>" name="abed" class="form-control" id="abed" placeholder="Quantity" required>
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Per Bed price</label>
      <input type="number" value="<?php echo $row['bed_price']; ?>" name="bprice" class="form-control" id="bprice" placeholder="One Bed Price" required>
    </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-6">
    <label for="inputAddress">City</label>
    <input type="text" value="<?php echo $row['city']; ?>" class="form-control" name="city" id="city" placeholder="Enter City name" required>
  </div>
  <div class="form-group col-md-6">
    <label for="inputAddress">Local Area</label>
    <input type="text" value="<?php echo $row['Address']; ?>" class="form-control" name="area" id="address" placeholder="Local Address" required>
  </div>
  </div>
  <div class="form-row">
  <div class="form-group col-md-6">
    <label for="inputAddress2">City pin code</label>
    <input type="number" value="<?php echo $row['pin']; ?>" name="pin" class="form-control" id="pin" placeholder="City pin" required>
  </div>
  
  <div class="form-group col-md-6">
      <label for="inputCity">Contact No</label>
      <input type="number" value="<?php echo $row['mno']; ?>" name="mno" class="form-control" id="mno" placeholder="Contact Number" required>
    </div>
  </div>
  <div class="form-outline">
  <label class="form-label" for="textAreaExample3">Discription</label>
  <textarea class="form-control" name="description" id="description" placeholder="Enter Room Description" rows="3" required><?php echo $row['description']; ?></textarea>
  
</div>

    <!-- <input multiple="" accept="image/png, image/jpeg" class="form-control form-control-lg" id="formFileLg" name="img[]" type="file" /> -->

    <!-- <div class="form-group col-md-4">
      <label for="inputState">State</label>
      <select id="inputState" class="form-control">
        <option selected>Choose...</option>
        <option>...</option>
      </select>
    </div> -->
    <!-- <div class="form-group col-md-2">
      <label for="inputZip">Select image</label>
      <input type="file" name="img[]" multipart="" id="img" class="form-control" id="inputZip">
    </div> -->

  
  <!-- <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div> -->
  <!-- <button type="submit" class="btn btn-primary">Sign in</button> -->
  <input type="submit" class="btn btn-danger mt-3 py-2 px-5" value="Update" name="submit">

</form>
    </div>


<?php
  include 'footer.php';
?>