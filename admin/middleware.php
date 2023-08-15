<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: ../../login.php"); // Ganti dengan halaman login
    exit();
}
?>
