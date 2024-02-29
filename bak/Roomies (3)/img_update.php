<?php 
include 'header.php';
// if (!isset($_GET['id'])) {
//     echo "<script>window.location.href='my_rooms.php';</script>";
// }
// $id1=$_GET['id'];
// $id=base64_decode($_GET['id']);
$sqlcmd="SELECT * FROM img_upload";
$result=mysqli_query($connect,$sqlcmd);   
?>
<div class="container">
  <div class="row">
        <?php
        if (mysqli_num_rows($result)) {
            while($row=mysqli_fetch_array($result)){
                $imgid=$row['imgid'];
        ?>
    <div class="col-sm-3">
        <form action="img_update.php?id=<?php echo $id1; ?>" method="POST">
      <div class="card">
        <div class="card-image">
          <!-- <img class="img-responsive" src="images/room1.jpg"> -->
          <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($row['img_name']).'"/>'; ?>
                
          <span class="card-title">Update Image</span>

        </div>
        <div class="card-action">
         <input accept="image/png, image/jpeg"  class="form-control form-control-lg" id="formFileLg" name="image" type="file" />
        </div>
        <input type="submit" name="submit" value="Update" class="btn btn-success mt-2">
      </div>
      </form>
    </div>
        <?php } } ?>
    </div>
    </div>
<?php 

$status = $statusMsg = ''; 
                      if(isset($_POST["submit"])){
                          $status = 'error'; 
                          if(!empty($_FILES["image"]["name"])) { 
                              // Get file info 
                              $fileName = basename($_FILES["image"]["name"]); 
                              $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
                              
                              // Allow certain file formats 
                              $allowTypes = array('jpg','png','jpeg','gif'); 
                              if(in_array($fileType, $allowTypes)){ 
                                  $image = $_FILES['image']['tmp_name']; 
                                  $imgContent = addslashes(file_get_contents($image));
                              
                                  /* Insert image content into database 
                                  $insert = $db->query("INSERT into imagetest (number,image) VALUES (NULL,'$imgContent')"); 
                                  */
                                  if($imgContent){ 
                                      $status = 'success'; 
                                      $statusMsg = 1;
                                      $check_img=1;
                                  }else{
                                    echo '<div class="alert alert-info alert-dismissible fade show" role="alert" style="padding:0px;margin-top:2px;">Image not upload please try again</div>'; 
                                      $check_img=0;
                                  }
                                }
                            }
                            $sql="UPDATE img_upload SET img_name='$imgContent' WHERE imgid=$imgid";
                        $res1=mysqli_query($connect,$sql);
                        }
                        

?>


<?php 
include 'footer.php';
?>