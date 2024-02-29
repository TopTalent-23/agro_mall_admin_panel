<?php
include 'header.php';
if(!isset($_SESSION['id'])){
    echo "<script>window.location.href='register.php';</script>";
}else{
    $userid=$_SESSION['id'];
}
?>
<style>
input::file-selector-button {
    font-weight: bold;
    font-size: 40px;
    color: dodgerblue;
    padding: 0.5em;
    border: thick solid black;
    border-radius: 100px;
    height: 100px;
    background: yellow;
}
.container {
  text-align: center;
}
input[type="submit"] {
  background-color: #4CAF50;
  border: none;
  border-radius: 30px;
  align-items: center;  
  color: white;
  padding: 10px 20px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
  margin: 4px 2px;
  cursor: pointer;
  height: 80px;
  width: 200px;
  font-size: 40px;
}
input[type="submit"]:hover {
  background-color: red;
  color: black;
}
</style>

<div class="back_re">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="title">
                      <h2>Upload Room Images here</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>
<div class="container py-5">
<form action="#" enctype="multipart/form-data" method="post">
<input multiple="" accept="image/png, image/jpeg" class="form-control form-control-lg" id="formFileLg" name="img[]" type="file" />
<input name="submit" value="Upload" type="submit" class="my-5"/>
</form>
</div>
<?php
include "partials/configure.php";    
if(isset($_POST["submit"])){
$filename = $_FILES['img']['name'];
$file_tmp = $_FILES['img']['tmp_name'];    
$filetype = $_FILES['img']['type'];
$filesize = $_FILES['img']['size'];
for($i=0; $i<=count($file_tmp); $i++){
if(!empty($file_tmp[$i])){
$name = addslashes($filename[$i]);
$temp = addslashes(file_get_contents($file_tmp[$i]));
$sql="INSERT INTO `img_upload`(`img_name`) values('$temp')"; 
$result=mysqli_query($connect,$sql);
if($result){
}
else{
echo "failed";
echo "<br />";
}
}
}
}
// $sql="SELECT * FROM img_upload";
// $result=mysqli_query($connect,$sql);

// while($row = mysqli_fetch_array($result)){
// $displ = $row['img_name'];


// echo '<img src="data:image/jpeg;base64,'.base64_encode($displ).'" height=250 width=250 />';
// echo "<br />";
// }
?>

<?php
include 'footer.php';
?>