<?php 
session_start();
session_destroy();
// return to login page on root
header("Location: login.php");
?>