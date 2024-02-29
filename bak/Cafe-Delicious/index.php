<?php
include('header.php');
?>
 
 <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script>
	$(document).ready(function(){
		$("#myModal").modal('show');
	});
    
</script>

<div class="modal fade" id="myModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="staticBackdropLabel">Are you Entered into the cafe ?</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
      <div class="modal-footer">
      <a href="home.php?cafe=<?php echo$cafe_id?>" class="btn btn-primary py-2 px-4">No, I'm at my Home.</a>
      <a href="order.php?cafe=<?php echo$cafe_id?>" class="btn btn-primary py-2 px-4">Yess, I'm Entered in the Cafe.</a>
       
      </div>
    </div>
  </div>
</div>


        

        <!-- Footer Start -->
        <?php
       include('footer.php')
       ?>