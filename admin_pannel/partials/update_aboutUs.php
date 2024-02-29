<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    include("../../db_config.php");

    // Process and validate the form data here
    $id = $_POST['id'];
    $shop_name = $_POST['shop_name'];
    $owner_name = $_POST['owner_name'];
    $phone1 = $_POST['phone1'];
    $phone2 = $_POST['phone2'];
    $email = $_POST['email'];
    $owner_qualification = $_POST['owner_qualification'];
    $about_owner = $_POST['about_owner'];
    $about_heading = $_POST['about_heading'];
    $about_description = $_POST['about_description'];
    $website = $_POST['website'];
    $linkedin = $_POST['linkedin'];
    $facebook = $_POST['facebook'];
    $twitter = $_POST['twitter'];
    $instagram = $_POST['instagram'];
    $gstin = $_POST['gstin'];
    $address = $_POST['address'];

    // Check if any images were uploaded
    if (isset($_FILES['shop_gallery_images']) && !empty($_FILES['shop_gallery_images']['name'][0])) {
        $imageContents = array();

        // Loop through each uploaded image
        foreach ($_FILES['shop_gallery_images']['name'] as $index => $filename) {
            // Generate a unique temporary file name based on the original filename
            $tempFilename = tempnam(sys_get_temp_dir(), 'uploaded_image_');
            // Get the temporary file extension
            $extension = pathinfo($filename, PATHINFO_EXTENSION);
            // Append the original file extension to the temporary filename
            $tempFilenameWithExtension = $tempFilename . '.' . $extension;
            // Move the uploaded file to the temporary location with the new filename
            if (move_uploaded_file($_FILES['shop_gallery_images']['tmp_name'][$index], $tempFilenameWithExtension)) {
                // Read the image content from the temporary file
                $imageContent = file_get_contents($tempFilenameWithExtension);
                // Add the image content to the array
                $imageContents[] = $imageContent;
                // Delete the temporary file
                unlink($tempFilenameWithExtension);
            } else {
                // Failed to move the uploaded file
                echo "Failed to upload image: $filename<br>";
            }
        }
    }

    // Simulate processing delay
    sleep(2);

    // Update information in the database using prepared statements
    $updateQuery = "UPDATE about_us SET 
                    shop_name=?, 
                    owner_name=?, 
                    phone1=?, 
                    phone2=?, 
                    email=?, 
                    owner_qualification=?, 
                    about_owner=?, 
                    about_heading=?, 
                    about_description=?, 
                    website=?, 
                    linkedin=?, 
                    facebook=?, 
                    twitter=?, 
                    instagram=?, 
                    gstin=?, 
                    address=? 
                    WHERE id=?";

    // Prepare the query
    $stmt = mysqli_prepare($conn, $updateQuery);

    // Bind parameters
    mysqli_stmt_bind_param($stmt, "ssssssssssssssssi", 
                           $shop_name, $owner_name, $phone1, $phone2, 
                           $email, $owner_qualification, $about_owner, 
                           $about_heading, $about_description, $website, 
                           $linkedin, $facebook, $twitter, $instagram, $gstin, 
                           $address, $id);

    // Execute the query
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        // Loop through the uploaded images and update them in the shop_gallery_images table
        foreach ($imageContents as $index => $imgContent) {
            $imgOrder = $index + 1; // Set the image order (1-based)
            $imgInsertQuery = "INSERT INTO shop_gallery_images (about_us_id, image_order, image_data ) 
                               VALUES (?, ?, ?)";

            // Prepare the query for image insertion
            $stmt = mysqli_prepare($conn, $imgInsertQuery);
            mysqli_stmt_bind_param($stmt, "iis", $id, $imgOrder, $imgContent);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        // Success message or further actions
        $response = 'success';
    } else {
        // Display error message
        $response = 'Error updating record: ' . mysqli_error($conn);
    }

    // Return a response
    echo $response;
} else {
    $response = 'Please fill input fields';
    echo $response;
}
?>
