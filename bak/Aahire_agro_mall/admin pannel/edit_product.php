<?php
require 'header.php';
require_once 'dbConfig.php';
?>
<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['pr_name'];
    $model_no = $_POST['pr_model_no'];
    $desc = $_POST['pr_desc'];
    $price = $_POST['price'];
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
    $sql = "UPDATE `products` SET `pr_name` = '$name', `pr_model_no` = '$model_no', `pr_desc` = '$desc', `price` = '$price', `img1` = '$img1Content', `img2` = '$img2Content', `img3` = '$img3Content', `img4` = '$img4Content', `img5` = '$img5Content' WHERE `products`.`sr_no` = $sr_no";
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Success</strong>  Your record has been updated  successfully...
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    <a class="btn btn-primary" href="sybca.php" role="button">Home</a>
    </div>';
    }
   // header('Location: products.php');
}

?>
<?php
//if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $sr_no = $_GET['sr_no'];
    $sql = "SELECT * FROM `products` WHERE sr_no =$sr_no";
    $result = mysqli_query($conn, $sql);





    while ($row = mysqli_fetch_assoc($result)) {
        $pr_name = $row['pr_name'];
        $model_no = $row['pr_model_no'];
        $price = $row['price'];
        $desc = $row['pr_desc'];
        $img1 = $row['img1'];
        $img2 = $row['img2'];
        $img3 = $row['img3'];
        $img4 = $row['img4'];
        $img5 = $row['img5'];
    }

?>

<section class="contact_section layout_padding">
    <div class="container">
        <div class="heading_container">
            <h2>
                Check <span>Details</span>
            </h2>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form_container contact-form">
                    <form action="<?php echo $_SERVER['REQUEST_URI'];?>" method="post" enctype="multipart/form-data">
                        <div>
                            <label>Product name :</label>
                            <input type="text" placeholder="Product name" name="pr_name" value="<?php echo $pr_name ?>" />
                        </div>
                        <div>
                            <label>Model no. :</label>
                            <input type="text" placeholder="Model no." name="pr_model_no" value="<?php echo $model_no ?>" />
                        </div>
                        <div>
                            <label>Price :</label>
                            <input type="text" placeholder="Price per piece" name="price" value="<?php echo $price ?>" />
                        </div>

                        <div>
                            <label>Description :</label>
                            <input type="text-area" class="message-box" placeholder="Description" name="pr_desc" value="<?php echo $desc ?>" />
                        </div>
                        <div>
                            <label>Previous Images:</label>
                            ----------------
                            
                                <div class="box">
                                    <div class="img-box">
                                        
                                        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
                                            <div class="carousel-indicators">
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3" aria-label="Slide 4"></button>
                                                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4" aria-label="Slide 5"></button>
                                            </div>
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="data:products/jpg;charset=utf8;base64,<?php echo base64_encode($img1); ?>" class="d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="data:products/jpg;charset=utf8;base64,<?php echo base64_encode($img2); ?>" class="d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="data:products/jpg;charset=utf8;base64,<?php echo base64_encode($img3); ?>" class="d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="data:products/jpg;charset=utf8;base64,<?php echo base64_encode($img4); ?>" class="d-block w-100" alt="...">
                                                </div>
                                                <div class="carousel-item">
                                                    <img src="data:products/jpg;charset=utf8;base64,<?php echo base64_encode($img5); ?>" class="d-block w-100" alt="...">
                                                </div>
                                            </div>
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
                                </div>
                            

                            ----------------






                            <div>
                                <label>Choose new Images:</label>
                                <input type="file" name="img1">
                                <input type="file" name="img2">
                                <input type="file" name="img3">
                                <input type="file" name="img4">
                                <input type="file" name="img5">
                            </div>
                        </div>

                        <div class="btn_box">
                            <button type="submit" name="update">
                                Update
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