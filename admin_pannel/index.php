<?php
require 'header.php';

?>
<?php
require "footer.php";
if ($logedin == false) {
    include "partials/loginModal.php";
}
?>