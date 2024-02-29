<script>
  function getdistrict(val) {
    $.ajax({
      type: "POST",
      url: "get_district.php",
      data: 'state_id='+val,
      success: function(data) {
        $("#district-list").html(data);
      }
    });
  }
  function selectCountry(val) {
    $("#search-box").val(val);
    $("#suggesstion-box").hide();
  }
</script>
<!--ye niche vala imp h de-->
<?php
include "header.php";
error_reporting(0);
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','project');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>

<div class="back_re">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div class="title">
          <h2>Update Room Details</h2>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="container py-5">
  <form action="sell.php" enctype="multipart/form-data" method="post">
    <div class="form-row">
      <div class="form-group col-md-6">
        <label for="inputEmail4">Available bed</label>
        <input type="number" name="abed" value="2" class="form-control" id="abed" placeholder="Quantity" required>
      </div>
      <div class="form-group col-md-6">
        <label for="inputPassword4">Per Bed price</label>
        <input type="number" name="bprice" value="2000" class="form-control" id="bprice" placeholder="One Bed Price" required>
      </div>
    </div>
    <div class="form-row">
      <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
      <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
    <div class="form-group col-md-6">
      <label for="inputAddress">State</label>
      <select onChange="getdistrict(this.value);" name="state" id="state" class="form-control select2">
        <option>Select</option>
        <!--- Fetching States--->
        <?php
        $sql = "SELECT * FROM state";
        $stmt = $dbh->query($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        while ($row = $stmt->fetch()) {
          ?>
          <option value="<?php echo $row['StCode']; ?>"><?php echo $row['StateName']; ?></option>
          <?php
        } ?>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="inputAddress">District</label>
      <select name="district" id="district-list" class="form-control select2">
        <option value="">Select</option>
      </select>
    </div>
    <div class="form-group col-md-6">
      <label for="inputAddress">Taluka</label>
      <input type="text" class="form-control" value="Malegaon" id="address" placeholder="Taluka" required>
    </div>
    <div class="form-group col-md-6">
      <label for="inputAddress">Village</label>
      <input type="text" class="form-control" value="Noorbagh" id="address" placeholder="Village" required>
    </div>
    <div class="form-group col-md-6">
      <label for="inputAddress">Near By Place</label>
      <input type="text" class="form-control" value="Near by Indian Butics" id="address" placeholder="Naer by" required>
    </div>
    <div class="form-group col-md-6">
      <label for="inputAddress2">City pin code</label>
      <input type="number" class="form-control" value="423205" id="pin" placeholder="City pin" required>
    </div>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Contact No</label>
      <input type="number" class="form-control" value="7326647623" id="mno" placeholder="Contact Number" required>
    </div>
  </div>
  
  

<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
  <ol class="carousel-indicators">
    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
  </ol>
  <div class="carousel-inner">
    <div class="carousel-item">
  <img src="images/room1.jpg" alt="...">
  <div class="carousel-caption d-none d-md-block">
    <h5>Change Image</h5>
    <p><input accept="image/png, image/jpeg" class="form-control form-control-lg" id="formFileLg" name="img[]" type="file" /></p>
  </div>
</div>
  </div>
  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>

  
  
  
  
  
  <div class="container">
  <div class="row">
    <div class="col-sm-3">
      <div class="card">
        <div class="card-image">
          <img class="img-responsive" src="images/room1.jpg">
          <span class="card-title">Update Image</span>
        </div>
        <div class="card-action">
         <input accept="image/png, image/jpeg" class="form-control form-control-lg" id="formFileLg" name="img[]" type="file" />
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="card">
        <div class="card-image">
          <img class="img-responsive" src="images/room1.jpg">
          <span class="card-title">Update Image</span>
        </div>
        <div class="card-action">
         <input accept="image/png, image/jpeg" class="form-control form-control-lg" id="formFileLg" name="img[]" type="file" />
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="card">
        <div class="card-image">
          <img class="img-responsive" src="images/room1.jpg">
          <span class="card-title">Update Image</span>
        </div>
        <div class="card-action">
         <input accept="image/png, image/jpeg" class="form-control form-control-lg" id="formFileLg" name="img[]" type="file" />
        </div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="card">
        <div class="card-image">
          <img class="img-responsive" src="images/room1.jpg">
          <span class="card-title">Update Image</span>
        </div>
        <div class="card-action">
         <input accept="image/png, image/jpeg" class="form-control form-control-lg" id="formFileLg" name="img[]" type="file" />
        </div>
      </div>
    </div>
    

  </div>

</div>






<div class="m-auto form-group">
  
  <input type="button" class="btn btn-success text-white fs-4 fw-bolder py-6 px-5 mt-5 "  value="Update" name="button">
  </div>
</form>
</div>

<script>

$('.select2').select2();
</script>
<?php
include "footer.php";
?>