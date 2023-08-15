<?php
// connect to db
$host = "localhost";
$username = "root";
$password = "";
$db = "20_dhimasekaprasetya";

$koneksi = mysqli_connect($host, $username, $password, $db);
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>