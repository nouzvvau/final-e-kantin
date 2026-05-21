<?php
session_start();
include "koneksi.php";

// 1. Proteksi Halaman
if (!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// 2. Ambil ID Pesanan dari URL
$order_id = $_GET['id'];

// 3. Ambil informasi utama pesanan (Tanggal, Total, Status)
$query_order = mysqli_query($koneksi, "SELECT * FROM orders WHERE id = $order_id");
$order = mysqli_fetch_assoc($query_order);

// 4. Ambil detail produk yang dibeli (Jika kamu memiliki tabel order_items)
// Jika kamu belum membuat tabel detail, ini adalah saatnya membuatnya.
// Namun jika sementara hanya menampilkan total, gunakan query berikut:
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>Detail Pesanan #<?= $order_id; ?></title>
</head>
<body class="bg-gray-50 p-6 pb-24">
    <div class="max-w-md mx-auto">
        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">
            <a href="orders.php" class="text-gray-400">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h1 class="text-xl font-black text-gray-800">Detail Pesanan</h1>
        </div>

        <!-- Status Card (Sesuai source 2) -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm mb-4 border border-gray-100 text-center">
            <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-3">
                <span class="material-symbols-outlined text-3xl">
                    <?php 
                        if($order['status_pesanan'] == 'selesai') echo 'check_circle';
                        elseif($order['status_pesanan'] == 'dibatalkan') echo 'cancel';
                        else echo 'pending_actions';
                    ?>
                </span>
            </div>
            <h2 class="font-bold text-lg capitalize"><?= $order['status_pesanan']; ?></h2>
            <p class="text-xs text-gray-400"><?= date('d F Y • H:i', strtotime($order['tanggal_pesan'])); ?></p>
        </div>

        <!-- Rincian Pembayaran -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm mb-4 border border-gray-100">
            <h3 class="font-bold mb-4 text-gray-800">Informasi Pembayaran</h3>
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">Metode Pembayaran</span>
                    <span class="font-semibold text-gray-800"><?= $order['metode_pembayaran']; ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-400">ID Transaksi</span>
                    <span class="font-semibold text-gray-800">#CJ-<?= $order['id']; ?>00<?= $order['id']; ?></span>
                </div>
                <hr class="border-dashed">
                <div class="flex justify-between items-center pt-2">
                    <span class="font-bold text-gray-800">Total Bayar</span>
                    <span class="text-xl font-black text-red-600">Rp <?= number_format($order['total_bayar'], 0, ',', '.'); ?></span>
                </div>
            </div>
        </div>

        <!-- Tombol Bantuan -->
        <div class="bg-white p-4 rounded-[1.5rem] shadow-sm border border-gray-100 flex items-center justify-between">
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <span class="material-symbols-outlined text-gray-400">support_agent</span>
                Ada kendala dengan pesanan?
            </div>
            <button class="text-red-600 font-bold text-sm">Chat Kantin</button>
        </div>

        <!-- Tombol Kembali -->
        <a href="homepage.php" class="block w-full mt-8 bg-gray-800 text-white text-center py-4 rounded-2xl font-bold shadow-lg">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>