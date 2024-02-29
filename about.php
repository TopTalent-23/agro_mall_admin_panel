<?php
require 'header.php';


// Fetch all images from the shop_gallery_images table
$sql = "SELECT image_data FROM shop_gallery_images";
$result = mysqli_query($conn, $sql);

// Array to store the image URLs
$imageUrls = array();

if (mysqli_num_rows($result) > 0) {
    // Loop through each row in the result set
    while ($row = mysqli_fetch_assoc($result)) {
        // Add the base64 encoded image data to the array
        $imageUrls[] = 'data:image/jpeg;base64,' . base64_encode($row['image_data']);
    }
}

// Fetch about description from the about_us table
// Initialize variables to store about and owner information
$aboutHeading = '';
$aboutDescription = '';
$ownerName = "";
$ownerQualification = "";
$ownerDescription = "";
$ownerImage = ""; // Assuming the owner image path is stored in the database
$address = '';
$phone = '';
$email = '';
$facebook = '';
$twitter = '';
$linkedin = '';
$instagram = '';
$gstin = '';


// Fetch about details from the about_us table
$sqlAbout = "SELECT * FROM about_us WHERE id = 1"; // Assuming the about_us table has a single row with id = 1
$resultAbout = mysqli_query($conn, $sqlAbout);

if (mysqli_num_rows($resultAbout) > 0) {
    $rowAbout = mysqli_fetch_assoc($resultAbout);
    $aboutHeading = $rowAbout['about_heading'];
    $aboutDescription = $rowAbout['about_description'];
    $ownerName = $rowAbout['owner_name'];
    $ownerQualification = $rowAbout['owner_qualification'];
    $ownerDescription = $rowAbout['about_owner'];
    // Assuming the owner image path is stored in the database
    // You need to fetch the owner image path from the database and assign it to the $ownerImage variable
    $ownerImage = $rowAbout['owner_image']; // Adjust this according to your database structure
    $address = $rowAbout['address'];
    $phone = $rowAbout['phone1'];
    $email = $rowAbout['email'];
    $facebook = $rowAbout['facebook'];
    $twitter = $rowAbout['twitter'];
    $linkedin = $rowAbout['linkedin'];
    $instagram = $rowAbout['instagram'];
    $gstin = $rowAbout['gstin'];
    
}
// Display only the initial words of the about description
$words = explode(' ', $aboutDescription);
$initialWords = implode(' ', array_slice($words, 0, 20)); // Display the first 20 words, adjust as needed
$remainingWords = implode(' ', array_slice($words, 20)); // Remaining words after the initial portion
?>

<section class="about_section bg-light" id="About">
    <div class="container py-3">
        <div class="text-center mb-4">
        <div class="heading_container">
            <h1>
                <b>About <span>Us</span></b>
            </h1>
        </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                    <!-- Carousel indicators -->
                    <div class="carousel-indicators">
                        <?php
                        // Generate carousel indicators
                        for ($i = 0; $i < count($imageUrls); $i++) {
                            $active = ($i == 0) ? 'active' : ''; // Add 'active' class to the first indicator
                            echo '<button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="' . $i . '" class="' . $active . '" aria-current="true" aria-label="Slide ' . ($i + 1) . '"></button>';
                        }
                        ?>
                    </div>
                    <!-- Carousel slides -->
                    <div class="carousel-inner">
                        <?php
                        // Generate carousel items
                        foreach ($imageUrls as $index => $imageUrl) {
                            $active = ($index == 0) ? 'active' : ''; // Add 'active' class to the first item
                            echo '<div class="carousel-item ' . $active . '">';
                            echo '<img src="' . $imageUrl . '" class="d-block w-100" alt="Shop Image">';
                            echo '</div>';
                        }
                        ?>
                    </div>
                    <!-- Carousel navigation controls -->
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            <div class="col-lg-6 align-self-center mt-4">
                <div class="about-description">
                    <h2 class="mb-4"><?php echo $aboutHeading; ?></h2>
                    <p class="lead"><?php echo $initialWords; ?></p>
                    <?php if (!empty($remainingWords)) : ?>
                        
                        <div class="collapse" id="collapseAboutDescription">
                            <p class="lead"><?php echo $remainingWords; ?></p>
                        </div>
                        <a href="#" class="read-more-link" data-bs-toggle="collapse" data-bs-target="#collapseAboutDescription" aria-expanded="false" aria-controls="collapseAboutDescription">Read more</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    /* Owner Section Styles */
    .owner_section {
        padding: 50px 0;
        background-color: #f9f9f9;
    }
 
    .owner-image {
        border: 8px solid #fff;
        border-radius: 50%;
        transition: transform 0.3s ease-in-out;
        box-shadow: 0 4px 8px rgba(5, 0, 0, 1);
        width: 400px;
            height: 450px;
    }

    .owner-image:hover {
        transform: scale(1.05);
    }

    .owner-details {
        padding-left: 20px;
    }

    .owner-name {
        font-size: 28px;
        color: #333;
        margin-bottom: 10px;
    }

    .owner-qualification {
        font-size: 20px;
        color: #666;
        margin-bottom: 15px;
    }

    .owner-description {
        font-size: 18px;
        color: #777;
        line-height: 1.6;
    }
    .owner_section {
    background-color: #fff;
    padding: 8px;
    margin: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}
    .about_section {
    background-color: #fff;
    padding: 8px;
    margin: 30px;
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

    /* Owner Section Media Queries */
    @media (max-width: 768px) {
        .owner-details {
            padding-left: 0;
            margin-top: 30px;
        }

        .owner-image {
            width: 200px;
            height: 250px;
        }

        .owner-name {
            font-size: 24px;
        }

        .owner-qualification {
            font-size: 18px;
        }

        .owner-description {
            font-size: 16px;
        }

    }
</style>
<hr>
<section class="owner_section" id="Owner">
    <div class="container py-5">
        <div class="text-center mb-5">
        <div class="heading_container">
            <h1>
                <b>Meet Our <span>Owner</span></b>
            </h1>
        </div>
        </div>
        <div class="row">
            <div class="col-lg-6 text-center">
                <?php
                    echo '<img src="data:products/jpg;charset=utf8;base64,' .
                        base64_encode($ownerImage) . '" 
                        class="img-fluid owner-image" alt="Owner Image">';
                ?>
            </div>
            <div class="col-lg-6 align-self-center">
                <div class="owner-details">
                    <h3 class="owner-name"><?php echo $ownerName; ?></h3>
                    <p class="owner-qualification"><?php echo $ownerQualification; ?></p>
                    <p class="owner-description"><?php echo $ownerDescription; ?></p>
                </div>
            </div>
        </div>
    </div>
</section>
<hr>
<style>
    /* Contact Section Styles */
    .contact_section {
        background-color: #f8f9fa;
       margin-bottom: 15px;
       margin-top: 15px;
       margin: 20px;
    }

    .section-heading {
        color: #333;
        font-size: 36px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .section-subheading {
        color: #666;
        font-size: 18px;
        margin-bottom: 40px;
    }

    .contact-form {
        background-color: #fff;
        border-radius: 10px;
        padding: 40px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    }

    
    .btn-primary {
        background-color: #007bff;
        color: #fff;
        border-radius: 8px;
        padding: 5px 5px;
        font-size: 18px;
        border: none;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }

    .contact-info {
    background-color: #fff;
    padding: 20px;
    
    border-radius: 10px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.contact-item i {
    font-size: 24px;
    color: #000;
    margin-right: 10px;
}

.contact-item p {
    color: #333;
    font-size: 16px;
    margin: 0;
}

.social-media p {
    color: #333;
    font-size: 16px;
    margin-bottom: 10px;
}

.list-inline-item {
    margin-right: 10px;
}

.list-inline-item a {
    color: #000;
    font-size: 24px;
    transition: color 0.3s ease;
}

.list-inline-item a:hover {
    color: #ffc107;
}

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

<section class="contact_section" id="Contact">
    <div class="container">
        <div class="text-center mb-4">
            <h2 class="section-heading">Contact Us</h2>
            <p class="section-subheading">We'd love to hear from you!</p>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="contact-form">
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
                        <button type="submit" class="btn btn-success" >Send</button>
                    </form>
                    <div id="loadingSpinner" class="spinner" style="display: none;"></div>
                </div>
            </div>
            <div class="col-lg-6">
    <div class="contact-info mt-4 owner-description">
        <div class="contact-item owner-description">
        <i class="fa-solid fa-map-location-dot"></i>
            <p class="owner-description"><?php echo $address; ?></p>
        </div>
        <div class="contact-item owner-description">
        <i class="fa-solid fa-phone-volume"></i>
            <p class="owner-description"><?php echo '<a href="tel:' . $phone . '">' . $phone . '</a>'; ?></p>
        </div>
        <div class="contact-item owner-description">
        <i class="fa-solid fa-envelope"></i>
            <p class="owner-description"><?php echo '<a href="tel:' . $email . '">' . $email . '</a>'; ?></p>
        </div>
        <div class="contact-item owner-description">
        <i class="fa-solid fa-registered"></i>GSTIN No.
            <p class="owner-description"><?php echo  $gstin . '</a>'; ?></p>
        </div>
        <div class="social-media owner-description">
            <p>Follow Us:</p>
            <ul class="list-inline owner-description">
                <li class="list-inline-item"><a href="<?php echo $facebook; ?>"><i class="fab fa-facebook-f"></i></a></li>
                <li class="list-inline-item"><a href="<?php echo $twitter; ?>"><i class="fab fa-twitter"></i></a></li>
                <li class="list-inline-item"><a href="<?php echo $linkedin; ?>"><i class="fab fa-linkedin-in"></i></a></li>
                <li class="list-inline-item"><a href="<?php echo $instagram; ?>"><i class="fab fa-instagram"></i></a></li>
            </ul>
        </div>
    </div>
</div>

        </div>
    </div>
</section>



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
<?php
require 'footer.php';
?>
