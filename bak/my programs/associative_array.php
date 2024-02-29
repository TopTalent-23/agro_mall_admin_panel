<?php
echo 'wellcome to associative array in php <br>';
$arr = ['bhavesh'=> 'jadhav', 'sai'=> 'deore', 'nil'=> 'sonawane', 'vaibhav'=> 'jadhav' ];

foreach ($arr as $key => $value){
    echo $key .' '. $value . '<br>';
}
$filename = [basename($_FILES["img1"]["name"]), basename($_FILES["img2"]["name"]), basename($_FILES["img3"]["name"]), basename($_FILES["img4"]["name"]), basename($_FILES["img5"]["name"])];
foreach ($filename as $value){
    
    $filetype = [pathinfo($value, PATHINFO_EXTENSION)];
    foreach ($filetype as $value){
    echo $value; 
}
}

        $fileName = basename($_FILES["image"]["name"]); 
        $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
       


?>