<?php

  include 'header.php';
  if (!isset($_SESSION['id'])) {
    echo "<script>window.location.href='register.php';</script>";
 }
?>

    <!-- <div class="container py-5">
      <div class="row">
        <div class="col-md-6">
          <a href="sell.php?" class="btn btn-danger">Private Room</a>
        </div>
        <div class="col-md-6">    
          <a href="" class="btn btn-danger">Sharing Room</a>
        </div>
      </div>
    </div> -->
    <div class="back_re">
         <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <div class="title">
                      <h2>Share Your Room</h2>
                  </div>
               </div>
            </div>
         </div>
      </div>

    <div class="container py-5">
    <form action="sell.php" enctype="multipart/form-data" method="post">
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputEmail4">Available bed</label>
      <input type="number" name="abed" class="form-control" id="abed" placeholder="Quantity" required>
    </div>
    <div class="form-group col-md-6">
      <label for="inputPassword4">Per Bed price</label>
      <input type="number" name="bprice" class="form-control" id="bprice" placeholder="One Bed Price" required>
    </div>
  </div>
  <div class="form-group">
    <label for="inputAddress">Address</label>
    <input type="text" class="form-control" id="address" placeholder="Local Address" required>
  </div>
  <div class="form-group">
    <label class="form-label" for="discription">Discrition</label>
  <textarea class="form-control" id="discription" rows="5" placeholder="Enter room Discription"></textarea>
  
  </div>
  <div class="form-group">
    <label for="inputAddress2">City pin code</label>
    <input type="number" class="form-control" id="pin" placeholder="City pin" required>
  </div>
  <div class="form-row">
    <div class="form-group col-md-6">
      <label for="inputCity">Contact No</label>
      <input type="number" class="form-control" id="mno" placeholder="Contact Number" required>
    </div>
    <!-- <div class="form-group col-md-4">
      <label for="inputState">State</label>
      <select id="inputState" class="form-control">
        <option selected>Choose...</option>
        <option>...</option>
      </select>
    </div> -->
    <!-- <div class="form-group col-md-2">
      <label for="inputZip">Select image</label>
      <input type="file" name="img[]" multipart="" id="img" class="form-control" id="inputZip">
    </div> -->
  </div>
  <!-- <div class="form-group">
    <div class="form-check">
      <input class="form-check-input" type="checkbox" id="gridCheck">
      <label class="form-check-label" for="gridCheck">
        Check me out
      </label>
    </div>
  </div> -->
  <!-- <button type="submit" class="btn btn-primary">Sign in</button> -->
  <input type="button" class="btn btn-danger mb-2" value="Sell Now" name="button" onclick="MakePayment100()">
</form>
    </div>


    <script>
	function MakePayment100(){
		//var name= $("#paynow").val();
		//var name= 
		//var amount= $("#amount").val();
    // var email =document.getElementById('email').value;
    // alert(email);
    var Available_bed=document.getElementById('abed').value;
    var bprice=document.getElementById('bprice').value;
    var add=document.getElementById('address').value;
    var pin=document.getElementById('pin').value;
    var mno=document.getElementById('mno').value;
    // alert(Available_bed);
    // alert(bprice);
    // alert(pin);
		var amount=100;

		var options = {
    "key": "rzp_test_fZz9Db1zYFolnI", // Enter the Key ID generated from the Dashboard 
    "amount": amount*100, // Amount is in currency subunits. Default currency is INR. Hence, 50000 refers to 50000 paise
    "currency": "INR",
    "name": "name",
    "description": "Test Transaction",
    "image": "image/myimage.jpg",
    //"order_id": "order_IluGWxBm9U8zJ8", //This is a sample Order ID. Pass the `id` obtained in the response of Step 1
    "handler": function (response){
    	$.ajax({
    		type:"POST",
    		url:"sell_server.php",
    		data:"payid="+response.razorpay_payment_id+"&amount="+amount+"&availablebed="+Available_bed+"&bprice="+bprice+"&address="+add+"&pin="+pin+"&mno="+mno,
    		success:function(result){
    			alert("Payment successfull Done"); //window.location.href="payment.php"; 
          window.location.href="upload_img.php";
    		}
    	})
    }
};
var rzp1 = new Razorpay(options);
//document.getElementById('rzp-button1').onclick = function(e){
    rzp1.open();
    e.preventDefault();
//}
			
   
	} 
</script>


<?php
  include 'footer.php';
?>