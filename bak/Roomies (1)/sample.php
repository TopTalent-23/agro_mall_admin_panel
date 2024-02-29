<form action="#" enctype="multipart/form-data" method="post">
<input multiple="" name="img[]" type="file" />
<input name="submit" type="submit" />
</form>
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
$sql="INSERT INTO `img_upload`(`img_name`,`sellid`) values('$temp',1)"; 
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
$sql="SELECT * FROM img_upload";
$result=mysqli_query($connect,$sql);

while($row = mysqli_fetch_array($result)){
$displ = $row['img_name'];


echo '<img src="data:image/jpeg;base64,'.base64_encode($displ).'" height=250 width=250 />';
echo "<br />";
}
?>