<?php
require_once("config.php");
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8">
		<meta charset="utf-8">
		<title>PHP GURUKUL | DEMO</title>
		<meta name="generator" content="Bootply" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<!--[if lt IE 9]>
			<script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		<link href="css/styles.css" rel="stylesheet">
		
		<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->


<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
		  <script>
function getdistrict(val) {
	$.ajax({
	type: "POST",
	url: "get_district.php",
	data:'state_id='+val,
	success: function(data){
		$("#district-list").html(data);
	}
	});
}
function selectCountry(val) {
$("#search-box").val(val);
$("#suggesstion-box").hide();
}
</script>	
	</head>
	<body>
<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
	<div class="navbar-header">
        <a class="navbar-brand" rel="home" href="#">PHPGURUKUL | Programming Blog</a>
		
	</div>

</nav>

<div class="container-fluid">
  
  <!--left-->
 <div class="col-sm-2">
      
    	<div class="panel panel-default">
         
         	<div class="panel-body"></div>
        </div>
        <hr>
       
		 </div>
      
     
 <!--/left-->
  
  <!--center-->
  <div class="col-sm-8">
    <div class="row">
      <div class="col-xs-12">
        <h3>jQuery Dependent DropDown List – States and Districts </h3>
		<hr >
		<form name="insert" action="" method="post">
  <table width="100%" height="117"  border="0">
  <tr>
    <th width="27%" height="63" scope="row">Sate :</th>
    <td width="73%"><select onChange="getdistrict(this.value);"  name="state" id="state" class="form-control select2" >
<option value="">Select</option>
<!--- Fetching States--->
<?php
$sql="SELECT * FROM state";
$stmt=$dbh->query($sql);
$stmt->setFetchMode(PDO::FETCH_ASSOC);
while($row =$stmt->fetch()) { 
  ?>
<option value="<?php echo $row['StCode'];?>"><?php echo $row['StateName'];?></option>
<?php }?>
                    </select></td>
  </tr>
  <tr>
    <th scope="row">District :</th>
    <td><select name="district" id="district-list" class="form-control select2">
<option value="">Select</option>
</select></td>
  </tr>
</table>



     </form>
 
      </div>
    </div>
    <hr>
        
   
  </div><!--/center-->

  <!--right-->
  <div class="col-sm-2">
      
    	<div class="panel panel-default">
         	
         	<div class="panel-body"></div>
        </div>
        <hr>
   
  </div>
<!--/right-->
  <hr>
</div><!--/container-fluid-->
	<!-- script references -->
	 <script>
   
    $('.select2').select2();
</script>
		<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
	</body>
</html>