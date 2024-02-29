<?php
include 'partials/configure.php';
include 'header.php';
if ( isset($_GET['id']) ) {
    $id=base64_decode($_GET['id']);
      $sqlcmd="SELECT sell.id, sell.pin, sell.description, sell.bed_price, sell.bed_available, sell.Address, sell.mno, sell.Address, sell.pin, sell.amount, sell.sellid, GROUP_CONCAT(img_upload.img_name) AS images
               FROM sell
               JOIN img_upload ON img_upload.id = sell.id WHERE sell.id=$id
               GROUP BY sell.id;
                ";
      $result=mysqli_query($connect,$sqlcmd);
}else{
  echo "<script>window.location.href='register.php';</script>";
}
?>
<div class="row">
  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <div id="carouselExampleIndicators" class="carousel slide " data-bs-ride="carousel">

          <div class="carousel-inner">
          <?php 
            if (mysqli_num_rows($result)) {
              $row=mysqli_fetch_assoc($result);
              $sql="SELECT * FROM img_upload WHERE id=$id";
              $res1=mysqli_query($connect,$sql);
              
            if(mysqli_num_rows($res1)){
              while($row1=mysqli_fetch_array($res1)){
          ?>

            <div class="carousel-item active">
              <!-- <img src="images/room7.jpg" class="d-block w-100" class="d-block w-100" alt="..."> -->
              <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($row1['img_name']).'" class="d-block w-100"  />'; ?>
            </div>


            <?php } } }else{
                echo "<script>window.location.href='index.php';</script>";
            } ?>

            <!-- <div class="carousel-item">
              <img src="images/room7.jpg" class="d-block w-100" class="d-block w-100" alt="...">
            </div>


            <div class="carousel-item ">
              <img src="images/room8.jpg" class="d-block w-100" class="d-block w-100" alt="...">
            </div>


            <div class="carousel-item ">
              <img src="images/room7.jpg" class="d-block w-100" class="d-block w-100" alt="...">
            </div>



            <div class="carousel-item ">
              <img src="images/room8.jpg" class="d-block w-100" class="d-block w-100" alt="...">
            </div>

            
            <div class="carousel-item ">
              <img src="images/room2.jpg" class="d-block w-100" class="d-block w-100" alt="...">
            </div> -->


          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
          <div class="btn-group me-2" role="group" aria-label="First group">
          <?php
          // if(mysqli_num_rows($res1)>0){
          //   $count=0;
          //   $count1=1;
          //     while($row1=mysqli_fetch_array($res1)){
                
          ?>
            <!-- <button type="button" class="btn" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="<?php echo $count; ?>" class="active" aria-current="true" aria-label="Slide <?php echo $count1; ?>"> <?php // echo '<img src="data:image/jpeg;base64,'.base64_encode($row1['img_name']).'" class="d-block w-100" class="d-block w-100"  />'; ?></button> -->
                <?php //echo $count++; }} ?>  
            <!-- <button type="button" class="btn" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"> <img src="images/room1.jpg" class="d-block w-100" class="d-block w-100" alt="..."></button>


            <button type="button" class="btn" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"> <img src="images/room7.jpg" class="d-block w-100" class="d-block w-100" alt="..."></button>


            <button type="button" class="btn" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"> <img src="images/room1.jpg" class="d-block w-100" class="d-block w-100" alt="..."></button>


            <button type="button" class="btn" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"><img src="images/room1.jpg" class="d-block w-100" class="d-block w-100" alt="..."></button> -->

          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6">
    <div class="card">
      <div class="card-body">
        <h class="card-title mt-6 text-uppercase fs-3 text-success fw-bold">my room </h>
        <p class="card-title mt-6 ">
           <b class="text-success fs-4">Rs.<?php echo $row['bed_price'] * $row['bed_available']; ?>/- </b>
        </p>
        <hr>
        <h class="card-title mt-3 text-uppercase fs-5 ">Details :</h>
        <div class="row text-uppercase fs-6 fw-normal mt-2">
          <div class="col-6">
            one Bed Price per month :
          </div>
          <div class="col-4 text-success">
          <?php echo $row['bed_price']; ?>
          </div>
        </div>
        <div class="row text-uppercase fs-6 fw-normal mt-2">
          <div class="col-6">
            Available Beds :
          </div>
          <div class="col-4 text-success">
          <?php     echo $row['bed_available']; ?>
          </div>
        </div>
        <div class="row text-uppercase fs-6 fw-normal mt-2">
          <div class="col-6">
            Phone number:
          </div>
          <div class="col-4 text-success">
          <?php     echo $row['mno']; ?>
          </div>
        </div>
        <div class="mt-2">
          <h class="card-title text-uppercase fs-5 ">Discription :</h>
          <p class="lead">
            <?php echo $row['description']; ?>
          </p>
        </div>
        <!-- <a class="btn btn-success d-flex mt-2 justify-content-center" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><b>Buy Now</b></a> -->
      </div>

    </div>
  </div>
</div>

<?php 
 $pin=$row['pin'];
//  $sqlcmd="SELECT sell.id, sell.pin, sell.description, sell.bed_price, sell.bed_available, sell.Address, sell.mno, sell.Address, sell.pin, sell.amount, sell.sellid, GROUP_CONCAT(img_upload.img_name) AS images
//                FROM sell
//                JOIN img_upload ON img_upload.id = sell.id WHERE sell.pin=$pin
//                GROUP BY sell.id;
//                 ";
//       $result=mysqli_query($connect,$sqlcmd);
?>
      <div  class="our_room">
         <div class="container">
         <div class="row">
            <?php
                
                $sqlcmd="SELECT sell.id, sell.pin, sell.description, sell.bed_price, sell.bed_available, sell.Address, sell.mno, sell.Address, sell.pin, sell.amount, sell.sellid, GROUP_CONCAT(img_upload.img_name) AS images
                FROM sell
                JOIN img_upload ON img_upload.id = sell.id WHERE sell.pin=$pin
                GROUP BY sell.id;
                 ";
                
                $result=mysqli_query($connect,$sqlcmd);
               if(mysqli_num_rows($result)>0){
                while($row=mysqli_fetch_array($result)){
                  $id=base64_encode($row['id']);
                  
            
               ?>
               <div class="col-md-4 col-sm-6">
                  <a href="room_detailed.php?id=<?php echo $id; ?>">
                  <div id="serv_hover"  class="room">
                     <div class="room_img">
                        <figure>
                           <?php echo '<img src="data:image/jpeg;base64,'.base64_encode($row['images']).'"/>'; ?>
                        </figure> 
                     </div>
                     <div class="bed_room">
                        <h3><?php echo $row['Address']; ?></h3>
                        <p >If you are going to use a passage of Lorem Ipsum, you need to be sure there </p>
                     </div>
                  </div>
                  </a>
               </div>
               <?php } } else { echo 'error'; } ?>  
               </div>
            </div>
        </div>

<?php
include 'footer.php';
?>