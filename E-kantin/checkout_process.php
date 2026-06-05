<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}
$user_id = $_SESSION['user_id'];

if (empty($_SESSION['cart'])) {
    echo "<script>alert('Keranjang belanja kamu masih kosong!'); window.location='homepage.php';</script>";
    exit;
}

$total_belanja = 0;
foreach ($_SESSION['cart'] as $id_produk => $jumlah) {
    $query_p = mysqli_query($koneksi, "SELECT harga FROM products WHERE id = $id_produk AND status_produk = 'tersedia'");
    $produk = mysqli_fetch_assoc($query_p);
    if ($produk) {
        $total_belanja += ($produk['harga'] * $jumlah);
    }
}

$query_u = mysqli_query($koneksi, "SELECT saldo, nama FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($query_u);
$saldo_user = $user['saldo'];


if ($saldo_user < $total_belanja) {
    echo "<script>
            alert('Maaf, saldo Campus Wallet kamu tidak cukup! Total belanja: Rp " . number_format($total_belanja, 0, ',', '.') . " | Saldo kamu: Rp " . number_format($saldo_user, 0, ',', '.') . "');
            window.location='cart.php';
          </script>";
    exit;
}


$saldo_baru = $saldo_user - $total_belanja;
mysqli_query($koneksi, "UPDATE users SET saldo = $saldo_baru WHERE id = $user_id");


$tanggal_pesan = date('Y-m-d H:i:s');
$metode_pembayaran = 'Campus Wallet';
$status_pesanan = 'pending';

$query_insert_order = "INSERT INTO orders (user_id, total_bayar, metode_pembayaran, status_pesanan, tanggal_pesan) 
                       VALUES ($user_id, $total_belanja, '$metode_pembayaran', '$status_pesanan', '$tanggal_pesan')";

if (mysqli_query($koneksi, $query_insert_order)) {
    $order_id = mysqli_insert_id($koneksi);

    foreach ($_SESSION['cart'] as $id_produk => $jumlah) {

        $query_produk = mysqli_query($koneksi, "
            SELECT harga 
            FROM products 
            WHERE id = $id_produk
        ");

        $produk = mysqli_fetch_assoc($query_produk);

        $harga = $produk['harga'];

        $subtotal = $harga * $jumlah;

        mysqli_query($koneksi, "
            INSERT INTO order_items
            (order_id, product_id, quantity, subtotal)
            VALUES
            ($order_id, $id_produk, $jumlah, $subtotal)
        ");
    }

    unset($_SESSION['cart']);

    echo "<script>
            alert('Pembayaran Berhasil! Pesananmu telah diteruskan ke kantin.');
            window.location='order_detail.php?id=$order_id';
          </script>";
    exit;
} else {
    echo "Terjadi kesalahan sistem saat memproses checkout: " . mysqli_error($koneksi);
}
?>