<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$total_belanja = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_belanja += $item['harga'] * $item['jumlah'];
}

$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT saldo FROM users WHERE id = $user_id"));

if ($user['saldo'] >= $total_belanja) {
    $saldo_baru = $user['saldo'] - $total_belanja;

    mysqli_query($koneksi, "UPDATE users SET saldo = $saldo_baru WHERE id = $user_id");

    mysqli_query($koneksi, "INSERT INTO orders (user_id, total_bayar, metode_pembayaran, status_pesanan) 
                            VALUES ($user_id, $total_belanja, 'Campus Wallet', 'diproses')");

    unset($_SESSION['cart']);

    echo "<script>alert('Pembayaran Berhasil!'); window.location='orders.php';</script>";
} else {
    echo "<script>alert('Saldo Gagal!'); window.location='homepage.php';</script>";
}
?>