<!-- login Modal -->
<div class="modal fade  modal-dialog-scrollable" id="login" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
   
       
       
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<p>
  

 <div class="mx-auto justify-content-center btn-group my-3" role="group" aria-label="Basic radio toggle button group" onchange="this.form.submit()">
          <h5 class="modal-title mx-3" >Login Using: </h5>
  <input type="radio" class="btn-check" name="btnradio" id="btnradio1" value="btnradio1" autocomplete="off" >
  <label class="btn btn-outline-primary" for="btnradio1">Email</label>

  <input type="radio" class="btn-check" name="btnradio" id="btnradio2" value="btnradio2" autocomplete="off">
  <label class="btn btn-outline-primary" for="btnradio2">Phone no.</label>

  
</div>
<div class="email">
    <form  class="mx-auto justify-content-center" action="partials/login_handler.php" method="post">

 <div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="email"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Email : </label>
</div>


<div class="form-floating mb-3 ">
<input type="password" class="form-control" id="floatingInput"  name="password"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Password: </label>
</div>
<P><a  data-bs-toggle="modal" data-bs-target="#resetPasswordModal" class=" btn-outline-success">Forgot Password?</a></P>
<div class="form-floating mb-3 ">
    <P>Do not have account: <button type="button"  data-bs-toggle="modal" data-bs-target="#signup" class="btn btn-outline-success">Signup</button></P>
    
    </div>
<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="email_login">Login</button>
      </div>
      </form>
</div>

<div class="phone">
    <form  class="mx-auto justify-content-center" action="partials/login_handler.php" method="post">

   <div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="phone"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Phone : </label>
</div>


<div class="form-floating mb-3 ">
<input type="password" class="form-control" id="floatingInput"  name="password"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Password: </label>
</div>
<P><a  data-bs-toggle="modal" data-bs-target="#resetPasswordModal" class=" btn-outline-success">Forgot Password?</a></P>
<div class="form-floating mb-3 ">
    <P>Do not have account:<button type="button" data-bs-toggle="modal" data-bs-target="#signup" class="btn btn-outline-success">Signup</button></P>
    </div>
<div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="phone_login">Login</button>
      </div>
      </form>
</div>

       
       
       





      </div>
      
    </div>
  </div>
</div>
</div>
    







<div class="modal fade  modal-dialog-scrollable" id="signup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Create new account</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
   <form class="mx-auto justify-content-center" action="partials/signup_handler.php" method="post">

<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="name"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Name: </label>
</div>


<div class="form-floating mb-3 ">
<input type="number" class="form-control" id="floatingInput"  name="phone"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Phone: </label>
</div>


<div class="form-floating mb-3 ">
<input type="email" class="form-control" id="floatingInput"  name="email"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Email: </label>
</div>


<div class="form-floating mb-3 ">
 <textarea class="form-control" placeholder="Discriptiopn" name="address" id="floatingTextarea2" style="height: 100px"></textarea>
  <label for="floatingTextarea2">Dilivery Address: </label>
</div>


<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="pincode"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Pincode: </label>
</div>





<div class="form-floating mb-3 ">
<input type="" class="form-control" id="floatingInput"  name="password"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Create Password: </label>
</div>
<div class="form-floating mb-3 ">
    <P>Already have account:<button type="button" data-bs-toggle="modal" data-bs-target="#login" class="btn btn-outline-success">Login</button></P>
    </div>





      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-success" name="signup">Create Account</button>
      </div>
      </form>
    </div>
  </div>
</div>
  
  
  
  <!-- Add this link to your existing HTML file -->


<!-- Add the modal for password reset -->
<div class="modal fade" id="resetPasswordModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="resetPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="resetPasswordModalLabel">Reset Password</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="reset_password.php" method="post">
          <div class="mb-3">
            <label for="token" class="form-label">Enter your email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <button type="submit" class="btn btn-primary">Reset Password</button>
        </form>
      </div>
    </div>
  </div>
</div>

  
