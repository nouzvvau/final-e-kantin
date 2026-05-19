<?php
session_start();
include "koneksi.php";

$id_produk = $_GET['id'];

// Ambil data produk untuk mendapatkan harga
$query = mysqli_query($koneksi, "SELECT * FROM products WHERE id = '$id_produk'");
$produk = mysqli_fetch_assoc($query);

if ($produk) {
    // Simpan ke session keranjang
    $_SESSION['cart'][$id_produk] = [
        'nama' => $produk['nama_produk'],
        'harga' => $produk['harga'],
        'jumlah' => 1
    ];
}

// Lempar ke halaman checkout
header("Location: checkout.php");
exit;
?>