<?php
include "header.php";
?>
 <div class="back_re">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="title">
                     <h2>My Rooms</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-lg-12 mt-4">
                                    <div class="d-flex align-items-center">
                                      <a  href="room_detailed.php">
                                        <img class="flex-shrink-0 img-fluid rounded" src="images/room1.jpg" alt="" style="width: 80px;">
                                        <div class="w-100 d-flex flex-column text-start ps-4">
                                            <h5 class="d-flex justify-content-between border-bottom pb-2">
                                                <span class="mt-2 fs-4" >Room Name</span>
                                                <span class="mt-2 fs-4" >Rent: Rs.2000/-</span>
                                      </a>
                                                <span class="mt-2"><a class="btn btn-success text-white fs-4 fw-bolder py-2 px-5" href="room_update.php">Edit</a>
                                                  <a class="btn btn-danger text-white fs-4 fw-bolder py-2 px-5" data-bs-toggle="modal" data-bs-target="#delete">Delete</a></span>
                                            </h5>
                                            
                                        </div>
                                        
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                   
                                    
                                    
                                    
                                    
                                    
                                </div>
                                  <!--order modal-->
                                <div class="modal fade  modal-dialog-scrollable" id="delete" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="modal-header">
<h5 class="modal-title" id="staticBackdropLabel">Delete</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">

<h3>Are you really want to delete....</h3>



</div>
<div class="modal-footer">
<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>


</div>

</div>
</div>
</div>
                            
                                
                                
<?php
include "footer.php";
?>