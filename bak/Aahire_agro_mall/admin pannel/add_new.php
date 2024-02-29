<?php
require 'header.php';
require_once 'dbConfig.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['pr_name'];
    $model_no = $_POST['pr_model_no'];
    $desc = $_POST['pr_desc'];
    $price = $_POST['price'];
    // Get file info
    //below part is only for image files
    $filename = [basename($_FILES["img1"]["name"]),
        basename($_FILES["img2"]["name"]),
        basename($_FILES["img3"]["name"]),
        basename($_FILES["img4"]["name"]),
        basename($_FILES["img5"]["name"])];
    foreach ($filename as $value) {

        $filetype = [pathinfo($value, PATHINFO_EXTENSION)];
        foreach ($filetype as $value) {

            // Allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'mp4', 'mp3', 'pdf');
            if (in_array($value, $allowTypes)) {
                if (!empty($_FILES["img1"]["name"])) {
                    $img1 = $_FILES['img1']['tmp_name'];
                    $img1Content = addslashes(file_get_contents($img1));
                }
                if (!empty($_FILES["img2"]["name"])) {
                    $img2 = $_FILES['img2']['tmp_name'];
                    $img2Content = addslashes(file_get_contents($img2));
                }
                if (!empty($_FILES["img3"]["name"])) {
                    $img3 = $_FILES['img3']['tmp_name'];
                    $img3Content = addslashes(file_get_contents($img3));
                }
                if (!empty($_FILES["img4"]["name"])) {
                    $img4 = $_FILES['img4']['tmp_name'];
                    $img4Content = addslashes(file_get_contents($img4));
                }
                if (!empty($_FILES["img5"]["name"])) {
                    $img5 = $_FILES['img5']['tmp_name'];
                    $img5Content = addslashes(file_get_contents($img5));
                }

                // Insert image content into database

            }
        }
    }

    // below is the control off full programe
    $sql = "INSERT INTO `products` (`pr_name`, `pr_model_no`, `pr_desc`, `price`, `img1`, `img2`, `img3`, `img4`, `img5`) VALUES ('$name', '$model_no', '$desc', '$price', '$img1Content', '$img2Content', '$img3Content', '$img4Content', '$img5Content')";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success</strong>  Your details are submitted succesfully...
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  <a class="btn btn-primary" href="sybca.php" role="button">Home</a>
</div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error</strong> roll no ' . $roll_no .' is already exists..
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
}


?>
<section class="contact_section layout_padding">
    <div class="container">
        <div class="heading_container">
            <h2>
                Add New <span>Product</span>
            </h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form_container contact-form">
                    <form action="add_new.php" method="post" enctype="multipart/form-data">
                        <div>
                            <input type="text" placeholder="Product name" name="pr_name" />
                        </div>
                        <div>
                            <input type="text" placeholder="Model no." name="pr_model_no" />
                        </div>
                        <div>
                            <input type="text" placeholder="Price per piece" name="price" />
                        </div>
                        
                        <div>
                            <input type="text-area" class="message-box" placeholder="Description" name="pr_desc" />
                        </div>
                        <div>
                            <label>Select Image Files:</label>

                            <input type="file" name="img1">
                            <input type="file" name="img2">
                            <input type="file" name="img3">
                            <input type="file" name="img4">
                            <input type="file" name="img5">

                        </div>

                        <div class="btn_box">
                            <button>
                                Add Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php

require 'footer.php';
?>