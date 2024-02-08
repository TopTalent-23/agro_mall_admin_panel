

<section class="  bg-dark text-light ">
        <div class="container">
            <div class="row ">
                <div class="col-sm-6 col-md-4 col-lg-3 footer-col mt-4">
                   <div class="footer_detail">
                        <a href="index.html"  class="text-light text-decoration-none">
                             <h2 class="text-success">
                             Agro Mall
                            </h2>
                        </a>
                        <p>
                            Soluta odit exercitationem rerum aperiam eos consectetur impedit delectus qui reiciendis, distinctio, asperiores fuga labore a? Magni natus.
                        </p>
                        <div class="social_box p-0">
                            <a href="" class="text-light text-decoration-none">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                            <a href="" class="text-light text-decoration-none">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                            <a href="" class="text-light text-decoration-none">
                                <i class="fa fa-linkedin" aria-hidden="true"></i>
                            </a>
                            <a href="" class="text-light text-decoration-none">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-4 col-lg-3 mx-auto footer-col mt-4">
                    <h4>
                        Contact us
                    </h4>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipisicing elit
                    </p>
                    <div class="contact_nav text-decoration-none" class="text-light">

                            <a href="" class="text-light text-decoration-none">
                                <i class="fa fa-phone " aria-hidden="true"></i>
                                <span class="text-decoration-none">
                                    : +01 123455678990
                                </span>
                            </a>
                            <div>
                                <a href="" class="text-light text-decoration-none">
                                    <i class="fa fa-envelope" aria-hidden="true"></i>
                                    <span>

                                        : demo@gmail.com
                                    </span>
                                </a>
                            </div>
                        </div>
                </div>
                <div class="col-md-4 footer-col mt-4">
                    <div class="footer_form">
                        <h4>
                            SIGN UP TO OUR NEWSLETTER
                        </h4>
                        <form action="">
                            <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
                            <button type="button" class="btn btn-outline-success mt-2">Subscribe</button>
                                
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            <hr>
           <div class="footer-info text-center my-1 ">
                    <p class="">
                        &copy; <span id="displayYear"></span>Copyright 2022 | All Rights Reserved By
                        <a href="https://html.design/" class="text-success text-decoration-none"><b>Agro Mall pvt ltd.</b></a>
                    </p>
                </div>
        </div>
    </section>



        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <!--js files-->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
            <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
            -->
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script>$(document).ready(function(){

var quantitiy=0;
   $('.quantity-right-plus').click(function(e){
        
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());
        
        // If is not undefined
            
            $('#quantity').val(quantity + 1);

          
            // Increment
        
    });

     $('.quantity-left-minus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var quantity = parseInt($('#quantity').val());
        
        // If is not undefined
      
            // Increment
            if(quantity>0){
            $('#quantity').val(quantity - 1);
            }
    });
    
});



$(function() {
  $('.email, .phone').hide(); // hide div1 and div2 on page load
  
  $('[name=btnradio]').on('change', function() { // bind an onchange function to the inputs
    if( $('[name=btnradio]:checked').val() == 'btnradio1' ) { // get the value that is checked
      $('.email').show();        // show div1
      $('.phone, .default').hide(); // hide other divs
    }
    else {
      $('.phone').show();        // show div2
      $('.email, .default').hide(); // hide other divs
    }
  });
});


</script>

    </body>
</html>