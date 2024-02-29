<!doctype html>
<html lang="en">
  <head>
      
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css" type="text/css" media="all" />
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    
    <script src="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js" type="text/javascript" charset="utf-8"></script>

    <title>Hello, world!</title>
  </head>
  <body>
          <?php
    include 'navbar.php';
    ?>
    <?php
 
include 'connection.php';
$sql = "SELECT * FROM `clients`";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
//if database connection not successfull
if ($num>0) {
     $sno = 0; 
  
 
  
  echo '<div class="">
  <table style="width:100%" class ="table" id ="myTable" m-auto>
  <thead>
   <tr>
   <th>Sr.no</th>
   <th>Name</th>
   <th>Email Id</th>
       <th>Phone no.</th>
       <th>Pan no.</th>
       <th>Aadhar no.</th>
       <th>Photo</th>
       <th>Address</th>
       <th>Date-Time</th>
      
   </tr>   
  </thead>
  <tbody>';
  //`clients_id`, `clients_name`, `clients_email`, `clients_phone`, `clients_pan`, `clients_aadhar`,`clients_photo`, `clients_address`, `registering_date
  while($row = mysqli_fetch_assoc($result)){ 
 
  $sno +=1;
  echo '<tr>
    
    <td>'. $sno . '</td>
    <td>'. $row['clients_name'] . '</td>
    
   
   
   
    
    
    
    <td>'. '<a href="mailto:'.$row['clients_email'].'">'. $row['clients_email'] . '</td>
    
  
  
    <td>'. '<a href="tel:'.$row['clients_phone'].'">'. $row['clients_phone'] . '</td>
    
   
    <td>'. $row['clients_pan'] . '</td>
    
   
    <td>'. $row['clients_aadhar'] . '</td>

    <td> <img src="'. $row['clients_photo'] .'height="300" width="300" "/></td>
   
    <td>'. $row['clients_address'] . '</td>
    <td>'. $row['registering_date'] . '</td>
  </tr>';
  }
  echo 
  ' </tbody>
</table> </div><br>';
}

?>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script type="text/javascript" charset="utf-8">
        $(document).ready( function () {
    $('#myTable').DataTable();
} );
    </script>
    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>