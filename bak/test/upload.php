<?php
if(isset($_POST["submit"])){

    $b = getimagesize($_FILES["userImage"]["tmp_name"]);

    //Check if the user has selected an image
    if($b !== false){
        //Get the contents of the image
        $file = $_FILES['userImage']['tmp_name'];
        $image = addslashes(file_get_contents($file));
        
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
        
        //Insert the image into the database
        $query = $db->query("INSERT into gallery (image) VALUES ('$image')");
        if($query){
            echo "File uploaded successfully.";
        }else{
            echo "File upload failed.";
        } 
    }else{
        echo "Please select an image to upload.";
    }
}
?>