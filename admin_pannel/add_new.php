<?php
require 'header.php';

?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
     $cat_id = $_GET['category'];
    $name = $_POST['pr_name'];
    $seed_type = $_POST['seed_type'];
    $net_wt = $_POST['net_wt'];
    $width = $_POST['width'];
    $breadth = $_POST['breadth'];
    $pr_state = $_POST['pr_state'];
    $manufacturer = $_POST['pr_manufacturer'];
    $desc = $_POST['pr_desc'];
    $main_price = $_POST['main_price'];
    $dis_price = $_POST['discounted_price'];
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
    $sql = "INSERT INTO `products` (`cat_id`, `pr_name`, `seed_type`, `net_wt`, `width`, `breadth`, `pr_state`, `pr_manufacturer`, `pr_desc`, `main_price`, `discounted_price`, `img1`, `img2`, `img3`, `img4`, `img5`) VALUES ('$cat_id', '$name', '$seed_type', '$net_wt', '$width', '$breadth', '$pr_state', '$manufacturer', '$desc', '$main_price', '$dis_price', '$img1Content', '$img2Content', '$img3Content', '$img4Content', '$img5Content')";
   
    $result = mysqli_query($conn, $sql);
    if ($result) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success</strong>  Your details are submitted succesfully...
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  <a class="btn btn-primary" href="sybca.php" role="button">Home</a>
</div>';
    } else {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error</strong> '. mysqli_error($conn). '
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
}
?>
<div class="">

    <div class=" m-4">
        <form action="">
            <label><h3>Please select category: </h3></label>
            <select class="form-select" name="category" onchange="this.form.submit()" id="floatingSelect" aria-label="Floating label select example">
                <option selected>Select</option>
                <?php

                $show = "SELECT * FROM `categories` ORDER BY `categories`.`cat_id` ASC";
                $result = mysqli_query($conn, $show);
                $num = mysqli_num_rows($result);
                if ($num > 0) {

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="'.($row['cat_id']).'"><a href="add_new.php?category='.($row['cat_id']).'">'.$row['cat_name'].'</a></option>';
                    }
                }
                ?>

            </select>
        </form>
        <div class="container">
            <div class="heading_container text-center mt-2">
                <?php

                if (isset($_GET['category'])) {

                    $cat_id = $_GET['category'];
                    $sql = "SELECT * FROM `categories` WHERE `categories`.`cat_id` = $cat_id";
                    $result = mysqli_query($conn, $sql);
                    $num = mysqli_num_rows($result);
                    if ($num > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo '
                     <section class="contact_section layout_padding my-4 text-center" id="Contact">
                    <div class="container">
                    <hr>
            <div class="heading_container">
            <h2>
            <b> '.$row['cat_name'].'</b>
            </h2>
            </div>
          
            ';
                        }
                    }
                    ?>


                    <div class="row">
                        <div class="">
                            <div class="form_container contact-form ">

                                <form class="mx-auto justify-content-center" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data">
                                    <div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput" aria-describedby="emailHelp" name="pr_name" placeholder="Banner Name">
<label for="floatingInput">Banner Name</label>
</div>

                                    <?php
                                    switch ($cat_id) {
                                        case '1':
                                            echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="seed_type" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
    <option value="Summary">Summary</option>
    <option value="Winter">Winter</option>
    <option value="Rainy">Rainy</option>
  </select>
  <label for="floatingSelect">Type of seed</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>


                                            ';
                                            break;
                                        case '2':
                                            echo '


<div class="form-floating mb-3 ">
<div class="input-group">
  <span class="input-group-text">Size in metre</span>
  <input type="text" aria-label="height" name="widht" class="form-control"> 
  <h4> X </h4>
   <input type="text" aria-label="width" name="breadth" class="form-control">
</div>
</div>

                                            ';
                                            break;
                                        case '3':
                                           echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
    
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>

                                            ';
                                            break;
                                            case '4':
                                           echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
    
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>


                                            ';
                                            break;
                                            case '5':
                                           echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
    
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>

                                            ';
                                            break;
                                            case '6':
                                           echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
    
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>

                                            ';
                                            break;
                                            case '7':
                                           echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
    
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>


                                            ';
                                            break;
                                            case '8':
                                           echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
    
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>

                                            ';
                                            break;
                                            case '9':
                                           echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
    
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>

                                            ';
                                            break;
                                       case '10':
                                           echo '

<div class="mb-3">
<div class="form-floating">
  <select class="form-select" id="floatingSelect" name="pr_state" aria-label="Floating label select example">
    <option selected>select</option>
    <option value="Dried">Dried</option>
    <option value="Cold">Cold</option>
    <option value="Liquid">Liquid</option>
    
  </select>
  <label for="floatingSelect">State of Insecticide</label>
</div>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="net_wt"  aria-describedby="emailHelp" placeholder="Net wt.">
<label for="floatingInput">Net wt.</label>
</div>

                                            ';
                                            break;
                                    }
                                    ?>
                                    <div class="form-floating mb-3 ">

  <textarea class="form-control" placeholder="Discriptiopn" name="pr_desc" id="floatingTextarea2" style="height: 100px"></textarea>
  <label for="floatingTextarea2">Discription</label>

</div>
                                    <div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="pr_manufacturer"  aria-describedby="emailHelp" placeholder="Manufacturer">
<label for="floatingInput">Manufacturer</label>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="main_price"  aria-describedby="emailHelp" placeholder="Main price">
<label for="floatingInput">Main price</label>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="discounted_price"  aria-describedby="emailHelp" placeholder="Discounted price">
<label for="floatingInput">Discounted price</label>
</div>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="img1" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">

                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="img2" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">

                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="img3" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">

                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="img4" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">

                                    </div>
                                    <div class="input-group mb-3">
                                        <input type="file" class="form-control" name="img5" id="inputGroupFile04" aria-describedby="inputGroupFileAddon04" aria-label="Upload">

                                    </div>
                                    <button type="submit" class="btn btn-success" style="width: 18rem;">Add Product</button>
                                </form>



                            </div>
                        </div>

                    </div>
                    <hr>
                </div>
            </section>
            <?php
        }
        ?>
    </div>
</div>
</div>
</div>
<?php
require "footer.php"
?>