<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $query = "UPDATE products SET status_produk = 'dihapus' WHERE id = $id";
    
    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Menu berhasil dinonaktifkan!'); window.location='admin_menu.php';</script>";
        exit;
    } else {
        echo "Gagal menonaktifkan menu." . mysqli_error($koneksi);
    }
} else {
    header("Location: admin_menu.php");
    exit;
}
?>