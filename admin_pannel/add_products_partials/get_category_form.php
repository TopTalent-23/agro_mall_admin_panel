<?php
$cat_id = $_GET['category'];
include("../../db_config.php");
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
// Generate input fields based on the selected category
echo '       <div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput" required aria-describedby="emailHelp" name="pr_name" placeholder="Banner Name">
<label for="floatingInput">Banner Name</label>
</div>
<div class="form-floating mb-3 ">
<input hidden   type="text" class="form-control" id="floatingInput"
aria-describedby="emailHelp" name="cat_id" value= "'.$cat_id.'">';
switch ($cat_id) {
  case '1':
    // Generate input fields for category 1
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
    // Generate input fields for category 2
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
  // ... and so on for other categories

}
echo
' <div class="form-floating mb-3 ">

  <textarea class="form-control" placeholder="Discriptiopn" name="pr_desc" id="floatingTextarea2" style="height: 100px"></textarea>
  <label for="floatingTextarea2">Discription</label>

</div>
                                    <div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="pr_manufacturer"  aria-describedby="emailHelp" placeholder="Manufacturer">
<label for="floatingInput">Manufacturer</label>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"
name="wholesale_price"  aria-describedby="emailHelp" placeholder="Wholesale price">
<label for="floatingInput">Wholesale price</label>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="main_price"  aria-describedby="emailHelp" placeholder="Main price">
<label for="floatingInput">Main price</label>
</div>
<div class="form-floating mb-3 ">
<input type="text" class="form-control" id="floatingInput"  name="discounted_price"  aria-describedby="emailHelp" placeholder="Discounted price">
<label for="floatingInput">Discounted price</label>
</div>
       <div class="mb-3">
            <input type="file" class="form-control" name="images[]" multiple id="images" accept="image/*">
        </div>

        <button type="button" id="submitForm" class="btn btn-primary">Add Product</button>';
?>