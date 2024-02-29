<?php
	$to="khanshahezad2002@@gmail.com";
	$subject="OTP SENDER";
	$Message="90747";
	$from="khanshahezad531@gmail.com";
	$headers="From : $from";
	if(mail($to,$subject,$Message,$headers)){
    	echo 'mail successfull';
    }else{
    	echo 'email not send';
    }
?>