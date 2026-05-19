<?php
// Pengaturan Database
$host = "localhost";
$user = "root";      // Default XAMPP adalah root
$pass = "";          // Default XAMPP adalah kosong
$db   = "canteen_joy";

// Membuat Koneksi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek Koneksi
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Opsional: Mengatur zona waktu agar sesuai dengan Indonesia (WIB)
date_default_timezone_get();
date_default_timezone_set('Asia/Jakarta');

// Sekarang variabel $koneksi siap digunakan di file lain
?>