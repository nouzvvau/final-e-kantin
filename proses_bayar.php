<?php
session_start();
include "koneksi.php";

$user_id = $_SESSION['user_id'];

// 1. Hitung total lagi untuk keamanan
$total_belanja = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_belanja += $item['harga'] * $item['jumlah'];
}

// 2. Cek saldo terakhir di database
$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT saldo FROM users WHERE id = $user_id"));

if ($user['saldo'] >= $total_belanja) {
    $saldo_baru = $user['saldo'] - $total_belanja;

    // A. Kurangi saldo user
    mysqli_query($koneksi, "UPDATE users SET saldo = $saldo_baru WHERE id = $user_id");

    // B. Masukkan data ke tabel orders (Sesuai source 2)
    mysqli_query($koneksi, "INSERT INTO orders (user_id, total_bayar, metode_pembayaran, status_pesanan) 
                            VALUES ($user_id, $total_belanja, 'Campus Wallet', 'diproses')");

    // C. Kosongkan keranjang
    unset($_SESSION['cart']);

    // D. Lempar ke halaman pesanan dengan pesan sukses
    echo "<script>alert('Pembayaran Berhasil!'); window.location='orders.php';</script>";
} else {
    echo "<script>alert('Saldo Gagal!'); window.location='homepage.php';</script>";
}
?>