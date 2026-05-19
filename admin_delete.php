<?php
session_start();

// Cek apakah sudah login DAN apakah rolenya admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include "koneksi.php";
$id = $_GET['id'];

$sql = "DELETE FROM products WHERE id = $id";
if (mysqli_query($koneksi, $sql)) {
    header("Location: admin_index.php");
} else {
    echo "Gagal menghapus: " . mysqli_error($koneksi);
}
?>