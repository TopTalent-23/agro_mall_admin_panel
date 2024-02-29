<?php 
echo 'Functions in php<br>';
function totalMarks($sumMarks){
 $sum = 0;
 foreach ($sumMarks as $value){
     $sum += $value;
 }
     echo '<br>';
 return $sum;
}
function percentage($perMarks){
 $sum = 0;
 $i = 0;
 foreach ($perMarks as $value){
     $sum += $value;
     $i++;
 }
     echo '<br>';
 return $sum/$i;
}

$bhavesh = [80, 90, 70, 75, 80, 78];
$marks = totalMarks($bhavesh);
$percentage = percentage($bhavesh);

echo 'bhavesh got ' . $marks . ' marks out of 600 and ' . $percentage . ' % out of 100 <br>';



$vaibhav = [60, 60, 70, 65, 50, 79];
$marks = totalMarks($vaibhav);
$percentage = percentage($vaibhav);

echo 'vaibhav got ' . $marks . ' marks out of 600 and ' . $percentage . ' % out of 100 <br>';



$chandu = [85, 50, 30, 75, 80, 78];
$marks = totalMarks($chandu);
$percentage = percentage($chandu);

echo 'chandu got ' . $marks . ' marks out of 600 and ' . $percentage . ' % out of 100 <br>';



$raj = [70, 40, 50, 35, 80, 78];
$marks = totalMarks($raj);
$percentage = percentage($raj);

echo 'raj got ' . $marks . ' marks out of 600 and ' . $percentage . ' % out of 100 <br>';


?>