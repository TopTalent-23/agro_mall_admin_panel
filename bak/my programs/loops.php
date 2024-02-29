<?php 
//while loop started👇👇
echo "<b>While loop in php👇👇<b><br>";
$i = 0;
while($i<100){
    echo $i+1;
    
    echo '<br>';
    $i++;
}
//while loop closed👆👆
//for loop started👇👇
echo "<br><br><br><b>For loop in php👇👇<b><br>";
for ($i = 0; $i < 10; $i++) {
    echo $i+1 . '<br>'; 
}
//for loop closed👆👆
//do_while loop started👇👇
echo "<br><br><br><b>Do_while loop in php👇👇<b><br>";

//at list 1 baar to code run hoga hi hoga
$i = 5;
do {
    echo $i;
    $i++;
} while ($i<5);
echo "<br><br><br>";
//ye 10 tak print karega
$j = 0;
do {
    echo $j+1;
    echo "<br>";
    
    $j++;
} while ($j<10);
//do_while loop closed👆👆
//foreach loop started👇👇
echo "<br><br><br><b>Foreach loop in php👇👇<b><br>";
$arr = array('butter', 'chicken', 'mutton', 'tanduri', 'roti', 'bhakri');
foreach ($arr as $value){
    echo "I am eating  ". $value . "  daily <br>"; 
}
//foreach loop closed👆👆

?>