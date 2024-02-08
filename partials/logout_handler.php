<?php
session_start();
session_unset();
session_destroy();
$path = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '../index.php';
header("location: " . $path);
?>
