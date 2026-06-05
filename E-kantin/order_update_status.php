<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_GET['id']) && isset($_GET['status'])) {
    $order_id = $_GET['id'];
    $status_baru = $_GET['status'];

    $allowed_status = ['pending', 'diproses', 'selesai', 'dibatalkan'];
    
    if (in_array($status_baru, $allowed_status)) {
        $query = "UPDATE orders SET status_pesanan = '$status_baru' WHERE id = $order_id";
        
        if (mysqli_query($koneksi, $query)) {
            header("Location: admin_pesanan.php");
            exit;
        } else {
            echo "Gagal memperbarui status pesanan: " . mysqli_error($koneksi);
        }
    } else {
        echo "Aksi tidak valid.";
    }
} else {
    header("Location: admin_pesanan.php");
    exit;
}
?>