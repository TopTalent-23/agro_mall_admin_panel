<?php

$xml=simplexml_load_file("untitled.xml") or die("Error: Cannot create object");
echo '<h2>Employees Informations</h2>';

$list = $xml->record;

foreach($xml->"" as $books) {


echo "hello";
    echo 'Name: '.$list[$i]->attributes()->Employee_Number . '<br>';
    echo 'Name: '.$list[$i]->Name . '<br>';

    echo "Department:". $list[$i]->Department .'<br><br>';

    echo "Telephone:". $list[$i]->Telephone .'<br><br>';
    echo "Email:". $list[$i]->Email .'<br><br>';
}

?>