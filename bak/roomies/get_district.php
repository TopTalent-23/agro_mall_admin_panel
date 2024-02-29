<?php
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
if(!empty($_POST["state_id"])) 
{
$stateid=$_POST["state_id"];
$sql=$dbh->prepare("SELECT * FROM district WHERE StCode=:stateid");
$sql->execute(array(':stateid' => $stateid));	
?>
<option value="">Select District</option>
<?php
while($row =$sql->fetch())
{
?>
<option value="<?php echo $row["DistrictName"]; ?>"><?php echo $row["DistrictName"]; ?></option>
<?php
}
}
?>
