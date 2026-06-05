<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

$order_id = $_GET['id'];

$query_order = mysqli_query($koneksi, "SELECT * FROM orders WHERE id = $order_id");
$order = mysqli_fetch_assoc($query_order);

$query_items = mysqli_query($koneksi, "
    SELECT 
        order_items.*,
        products.nama_produk,
        products.gambar,
        products.harga

    FROM order_items

    JOIN products
    ON order_items.product_id = products.id

    WHERE order_items.order_id = $order_id
");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <title>Detail Pesanan #<?= $order_id; ?></title>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#EAE0CF] p-6 pb-24">

    <div class="max-w-md mx-auto">

        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">

            <a href="orders.php"
               class="text-[#7288AE] hover:text-[#111844] transition">

                <span class="material-symbols-outlined">
                    arrow_back
                </span>

            </a>

            <h1 class="text-xl font-black text-[#111844]">
                Detail Pesanan
            </h1>

        </div>

        <!-- Status Card -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm mb-4 border border-[#7288AE]/20 text-center">

            <div class="w-16 h-16 bg-[#EAE0CF]/50 text-[#4B5694] rounded-full flex items-center justify-center mx-auto mb-3">

                <span class="material-symbols-outlined text-3xl">

                    <?php 
                        if($order['status_pesanan'] == 'selesai') echo 'check_circle';
                        elseif($order['status_pesanan'] == 'dibatalkan') echo 'cancel';
                        else echo 'pending_actions';
                    ?>

                </span>

            </div>

            <h2 class="font-bold text-lg capitalize text-[#111844]">

                <?= $order['status_pesanan']; ?>

            </h2>

            <p class="text-xs text-[#7288AE]">

                <?= date('d F Y • H:i', strtotime($order['tanggal_pesan'])); ?>

            </p>

        </div>

        <!-- Informasi Pembayaran -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm mb-4 border border-[#7288AE]/20">

            <h3 class="font-bold mb-4 text-[#111844]">

                Informasi Pembayaran

            </h3>

            <!-- Menu Pesanan -->
            <div class="bg-white p-6 rounded-[2rem] shadow-sm mb-4 border border-[#7288AE]/20">

                <h3 class="font-bold mb-4 text-[#111844]">
                    Menu Dipesan
                </h3>

                <div class="space-y-4">

                    <?php while($item = mysqli_fetch_assoc($query_items)) : ?>

                        <div class="flex items-center gap-4">

                            <!-- Gambar -->
                            <img src="images/<?= $item['gambar']; ?>" 
                                class="w-16 h-16 rounded-xl object-cover">

                            <!-- Info -->
                            <div class="flex-1">

                                <h4 class="font-bold text-[#111844]">
                                    <?= $item['nama_produk']; ?>
                                </h4>

                                <p class="text-sm text-[#7288AE]">
                                    <?= $item['quantity']; ?> x 
                                    Rp <?= number_format($item['harga'], 0, ',', '.'); ?>
                                </p>

                            </div>

                            <!-- Subtotal -->
                            <div class="font-bold text-[#4B5694]">
                                Rp <?= number_format($item['subtotal'], 0, ',', '.'); ?>
                            </div>

                        </div>
                    <?php endwhile; ?>
                </div>
            </div>

            <div class="space-y-3">

                <!-- Metode -->
                <div class="flex justify-between text-sm">

                    <span class="text-[#7288AE]">
                        Metode Pembayaran
                    </span>

                    <span class="font-semibold text-[#111844]">

                        <?= $order['metode_pembayaran']; ?>

                    </span>

                </div>

                <!-- ID -->
                <div class="flex justify-between text-sm">

                    <span class="text-[#7288AE]">
                        ID Transaksi
                    </span>

                    <span class="font-semibold text-[#111844]">

                        #CJ-<?= $order['id']; ?>00<?= $order['id']; ?>

                    </span>

                </div>

                <hr class="border-dashed border-[#7288AE]/20">

                <!-- Total -->
                <div class="flex justify-between items-center pt-2">

                    <span class="font-bold text-[#111844]">
                        Total Bayar
                    </span>

                    <span class="text-xl font-black text-[#4B5694]">

                        Rp <?= number_format($order['total_bayar'], 0, ',', '.'); ?>

                    </span>

                </div>

            </div>

        </div>

        <!-- Tombol -->
        <a href="homepage.php"

           class="block w-full mt-8 bg-[#4B5694] hover:bg-[#111844] text-white text-center py-4 rounded-2xl font-bold shadow-lg transition-all">

            Kembali ke Beranda

        </a>

    </div>

</body>
</html>