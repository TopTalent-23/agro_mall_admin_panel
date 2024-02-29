<script>
	$(document).ready(function(){
		$("#login").modal('show');
	});
    
</script>
  <!-- login Modal -->
<div class="modal fade  modal-dialog-scrollable" id="login" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Login</h5>
      
      </div>
      <div class="modal-body">
   
       
       
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<p>
  



  

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

<div class="modal-footer">
        
        <button type="submit" class="btn btn-success" name="email_login">Login</button>
      </div>
      </form>
</div>


       
       
       





      </div>
      
    </div>
  </div>
</div>
</div>