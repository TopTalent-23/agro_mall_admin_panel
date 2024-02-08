<?php
require'header.php';


?>

<section class="contact_section layout_padding my-4 text-center" id="Contact">
    <div class="container">
        <div class="heading_container">
            <h2>
                <b>Contact <span>Us</span></b>
            </h2>
        </div>
        <div class="row">
            <div class="">
                <div class="form_container contact-form ">
                    <form id="contactForm" class="mx-auto justify-content-center">
                        <div class="mb-3">
                            <input type="text" class="form-control" name="name" placeholder="Your Name" required>
                        </div>
                        <div class="mb-3">
                            <input type="text" class="form-control" name="phone" placeholder="Phone Number" required>
                        </div>
                        <div class="mb-3">
                            <input type="email" class="form-control" name="email" placeholder="E mail" required>
                        </div>
                        <div class="mb-3">
                            <textarea class="form-control" name="message" rows="3" placeholder="Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success" style="width: 18rem;">Send</button>
                    </form>
                    <div id="loadingSpinner" class="spinner" style="display: none;"></div>
                </div>
            </div>
        </div>
        <hr>
    </div>
</section>
<style>
  .spinner {
    border: 4px solid rgba(255, 255, 255, 0.3);
    border-radius: 50%;
    border-top: 4px solid #00bcd4;
    width: 40px;
    height: 40px;
    animation: spin 1s linear infinite;
    position: absolute;
    top: 50%;
    left: 50%;
    margin-top: -20px;
    margin-left: -20px;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function () {
    $("#contactForm").submit(function (event) {
        event.preventDefault();

        // Display a loading spinner
        $("#loadingSpinner").show();

        var formData = $(this).serialize();

        $.ajax({
            type: "POST",
            url: "partials/submitContact.php", // Replace with the path to your PHP script
            data: formData,
            success: function (response) {
                // Example: Display a success message using SweetAlert
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Form submitted successfully!',
                });

                // Reset the form
                $("#contactForm")[0].reset();

                // Hide the loading spinner
                $("#loadingSpinner").hide();
            },
            error: function (error) {
                // Example: Display an error message using SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Error submitting form!',
                });

                // Hide the loading spinner
                $("#loadingSpinner").hide();
            }
        });
    });
});

</script>
<!-- end contact section -->
<?php
require'footer.php';
?>