<?php
if(!empty($_GET['id'])){

    $host     = 'localhost';
    $username = 'root';
    $password = '';
    $db     = 'test';
    
    //Create the connection and select the database
    $db = new mysqli($host, $username, $password, $db);
    
    // Check the connection
    if($db->connect_error){
        die("Connexion error: " . $db->connect_error);
    }
    
    //Get the image from the database
    $res = $db->query("SELECT image FROM gallery WHERE id = {$_GET['id']}");
    
    if($res->num_rows > 0){
        $img = $res->fetch_assoc();
        
        //Render the image
        header("Content-type: image/jpg"); 
        echo $img['image']; 
    }else{
        echo 'Image not found...';
    }
}
?>