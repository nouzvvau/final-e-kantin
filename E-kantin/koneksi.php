<?php
$host = "localhost";
$user = "root";     
$pass = "";         
$db   = "canteen_joy";

$koneksi = mysqli_connect($host, $user, $pass, $db);

if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

date_default_timezone_get();
date_default_timezone_set('Asia/Jakarta');

?>