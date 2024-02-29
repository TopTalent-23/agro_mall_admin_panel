<?php
   include 'header.php';
   if(isset($_SESSION['id'])){
      echo "<script>window.location.href='index.php';</script>";
   }
   echo "<script type='text/javascript'>
         $(window).on('load', function() {
         $('#myModal').modal('show');
         });
         </script>";

   if (isset($_POST['submit'])) {
      $name=$_POST['Name'];
      $address=$_POST['address'];
      $email=$_POST['Email'];
      $pno=$_POST['Pno'];
      $password=$_POST['password'];
      $cpassword= $_POST['cpassword'];
   
      if ($password==$cpassword){
         
      $sql = "INSERT INTO `register` (`Id`, `name`, `email`, `phone_no`, `address`, `password`, `datetime`) VALUES (NULL, '$name', '$email', '$pno', '$address','$password', current_timestamp());";
      $result=mysqli_query($connect,$sql);
      if ($result) {
         echo '<script> alert("Registration successful")</script>';
         /*echo '<div class="alert alert-success" role="alert">
         Registration Succesfull <a href="#" class="alert-link" data-bs-toggle="modal" data-bs-target="#exampleModal"> login</a>. 
         </div>
         ';*/


            echo "<script type='text/javascript'>
            $(window).on('load', function() {
            $('#myModal').modal('show'); 
            });
            </script>";

      }
   }
   }
   
?>
<div class="back_re mt-2">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="title">
                      <h2>Register Now</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>
     
      <!--  contact -->
      <div class="contact">
         <div class="container">
            <div class="row justify-content-center">
               <div class="col-md-8">
                  <form id="request" method="POST" action="register.php" class="main_form">
                     <div class="row">
                        <div class="col-md-12 ">
                           <input class="contactus" placeholder="Name" value="<?php if(isset($_POST['submit'])){ echo $name; } ?>" type="text" name="Name" required> 
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Email" value="<?php if(isset($_POST['submit'])){ echo $email; } ?>" type="email" name="Email" required> 
                           <?php 
                           if (isset($_POST['submit'])) {
                              $emails=$_POST['Email'];
                              $sqlcmd="SELECT email FROM register WHERE `email`='$emails' ";
                              $res=mysqli_query($connect,$sqlcmd);
                              if (mysqli_num_rows($res)>0) {
                                 echo '<div class="alert alert-warning" role="alert"><h6>Email Id aleady Exist</h6></div>';
                                 
                              }
                           }
                           ?>
                     
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Phone Number" value="<?php if(isset($_POST['submit'])){ echo $pno; } ?>" type="number" name="Pno" maxlength="10" minlength="10" required>                          
                        </div>
                        <div class="col-md-12">
                           <textarea class="textarea" placeholder="Address" name="address" type="type" required><?php if(isset($_POST['submit'])){ echo $address; } ?></textarea>
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Password" type="password"  name="password" required>                          
                        </div>
                        <div class="col-md-12">
                           <input class="contactus" placeholder="Confirm Password" type="password" name="cpassword" required>   
                           <?php 
                           if(isset($_POST['submit'])){
                              if ($password!=$cpassword){
                                 echo '<script>alert("confirm your password");</script>';
                                 echo '<div class="alert alert-warning" role="alert">
                                 password not match!
                                 </div>';
                              }
                           }
                           ?>                       
                        </div>
                        <div class="col-md-6">
                           <button class="send_btn" type="submit"   name="submit">Register</button>
                        </div>
                        <div class="col-md-6">
                           <type="button" class="btn send_btn" data-bs-toggle="modal" data-bs-target="#myModal" data-bs-whatever="@mdo" name="submit1">Login</button>
                        </div>
                        
                     </div>
                  </form>
               </div>
               
            </div>
         </div>
      </div>

               



<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Login</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="partials/login.php" method="POST">
          <div class="mb-3">
            <label for="recipient-name" class="col-form-label">Email:</label>
            <input class="form-control" placeholder="Email" type="email" name="email" required> 
          </div>
          <div class="mb-3">
            <label for="message-text" class="col-form-label">Password:</label>
            <input class="form-control" placeholder="Password" type="password" name="password" required> 
          </div>
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary" name="submit">Login</button>
      </div>
      </form>
    </div>
  </div>
</div>

      
     
<?php
include 'footer.php';
?> 