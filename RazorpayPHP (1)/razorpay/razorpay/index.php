<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
  </head>
  <body>
    <h1>Hello, world!</h1>
    
    <a class="btn btn-success d-flex mt-2 justify-content-center" data-bs-toggle="modal" data-bs-target="#staticBackdrop"><b>Buy Now</b></a>
    
    
    <?php
include ('db.php');
  $usr= 34;
   $sql1 = "SELECT * FROM `customers` WHERE `sr_no` = '$usr'";
$result1 = mysqli_query($con, $sql1);
$num1 = mysqli_num_rows($result1);
if ($num1 > 0) {

  while ($row1 = mysqli_fetch_assoc($result1)) { 
    
    $name= $row1['cust_name'];
    $phone= $row1['cust_phone'];
    $email= $row1['cust_email'];
    $pincode= $row1['cust_pincode'];
    $address= $row1['cust_address'];
  }
}

?>

<div class="modal fade  modal-dialog-scrollable" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form class="mx-auto justify-content-center" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Buy Now</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
   

<div class="mb-3">
<input type="text" class="form-control" id="name"  name="name" value="<?php echo $name;?>" >
</div>


<div class="mb-3">
<input type="number" class="form-control" id="pno" value="<?php echo $phone;?>" name="phone" >
</div>


<div class="mb-3">
<input type="email" class="form-control" id="email"  name="email"    value="<?php echo $email;?>">
</div>


                      <div class="row">
                        <div class="col-lg-2 mb-3">
                          <lable class="mb-3">Quantity : </lable>
                          <div class="input-group">
                            <span class="input-group-btn">
                              <button type="button" class="quantity-left-minus btn btn-danger btn-number fa fa-minus" data-type="minus" data-field="">
                                <span class="glyphicon glyphicon-minus"></span>
                              </button>
                            </span>

                            <input type="text" id="quantity" name="quantity" class="form-control input-number" value="1" min="1" max="1000" placeholder="Quantity">
                            <span class="input-group-btn">
                              <button type="button" class="quantity-right-plus btn btn-success btn-number fa fa-plus" data-type="plus" data-field="">
                                <span class="glyphicon glyphicon-plus"></span>
                              </button>
                            </span>
                          </div>
                        </div>
                      </div>
                      <div class="mb-3">

                        <textarea class="form-control" id="addr" rows="3" value="" placeholder="Address"><?php echo $address;?></textarea>
                      </div>
                      <div class="mb-3">

                        <input type="text" class="form-control" id="pin" value="<?php echo $pincode;?>" placeholder="Pincode">
                        <input type="text" class="form-control" hidden="" id="pr_id" value="<?php echo 20;?>" placeholder="Pincode">
                        <input type="text" class="form-control" hidden id="amt" value="<?php echo 600;?>" placeholder="Pincode">
                      </div>



                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    
                     <input type="button" class="btn btn-success" name="btn" id="btn" value="Pay Now" onclick="pay_now()"/>
                  
                    </div>
                  
                </div>
                </form>
              </div>
            </div>
    
  
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
  </body>
</html>




<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>


<script>
    function pay_now(){
        var name=jQuery('#name').val();
        var amt=jQuery('#amt').val();
        var pno=jQuery('#pno').val();
         var email=jQuery('#email').val();
        var quantity=jQuery('#quantity').val();
        var addr=jQuery('#addr').val();
        var pin=jQuery('#pin').val();
        
        var pr_id=jQuery('#pr_id').val();
         jQuery.ajax({
               type:'post',
               url:'payment_process.php',
               data:"amt="+amt+"&name="+name+"&pno="+pno+"&email="+email+"&quantity="+quantity+"&addr="+addr+"&pin="+pin+"&pr_id="+pr_id,
               success:function(result){
                   var options = {
                        "key": "rzp_test_XkyAfIibqTU8Oz", 
                        "amount": amt*100, 
                        "currency": "INR",
                        "name": "Acme Corp",
                        "description": "Test Transaction",
                        "image": "https://image.freepik.com/free-vector/logo-sample-text_355-558.jpg",
                        "handler": function (response){
                           jQuery.ajax({
                               type:'post',
                               url:'payment_process.php',
                               data:"payment_id="+response.razorpay_payment_id,
                               success:function(result){
                                   window.location.href="thank_you.php";
                               }
                           });
                        }
                    };
                    var rzp1 = new Razorpay(options);
                    rzp1.open();
               }
           });
        
        
    }
</script>