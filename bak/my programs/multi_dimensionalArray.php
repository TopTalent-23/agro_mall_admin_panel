<?php 
echo 'wellcome to multidimensional array in php<br>';
$arr = array(array(array(2,3,4,5,6,7)),
    array(array(2,3,4,5,6,7)),
    array(array(2,3,4,5,6,7)),
    );
for ($i = 0; $i < count($arr); $i++) {
     
     for ($j = 0; $j < count($arr[$i]); $j++) {
         
         
         for ($k = 0; $k < count($arr[$i][$j]); $k++) {
          echo $arr[$i][$j][$k];
          echo '  '; 
     }
     echo '<br>';
}

}

?>