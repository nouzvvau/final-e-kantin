<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

$total_belanja = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <title>Keranjang Belanja - CanteenJoy</title>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#EAE0CF] pb-24 min-h-screen">

    <div class="max-w-md mx-auto p-5">

        <!-- Header -->
        <div class="flex items-center gap-4 mb-6">

            <a href="homepage.php"
               class="text-[#7288AE] hover:text-[#111844] transition">

                <span class="material-symbols-outlined">
                    arrow_back
                </span>

            </a>

            <h1 class="text-xl font-black text-[#111844]">
                Keranjang Belanja
            </h1>

        </div>

        <!-- Cart Items -->
        <div class="space-y-4 mb-6">

            <?php if (!empty($_SESSION['cart'])): ?>

                <?php 
                foreach ($_SESSION['cart'] as $id_produk => $jumlah): 

                    $query = mysqli_query($koneksi, "SELECT * FROM products WHERE id = $id_produk");

                    $produk = mysqli_fetch_assoc($query);
                    
                    if ($produk):

                        $subtotal = $produk['harga'] * $jumlah;

                        $total_belanja += $subtotal;
                ?>

                <div class="bg-white p-4 rounded-[2rem] shadow-sm border border-[#7288AE]/20 flex items-center justify-between gap-3">

                    <!-- Gambar -->
                    <img src="images/<?= $produk['gambar'] ? $produk['gambar'] : 'default_food.jpg'; ?>" 
                         class="w-16 h-16 object-cover rounded-2xl border border-[#7288AE]/10" 
                         alt="">

                    <!-- Info Produk -->
                    <div class="flex-1 min-w-0">

                        <h3 class="font-bold text-[#111844] text-sm truncate">

                            <?= $produk['nama_produk']; ?>

                        </h3>

                        <p class="text-xs text-[#4B5694] font-black mt-0.5">

                            Rp <?= number_format($produk['harga'], 0, ',', '.'); ?>

                        </p>

                    </div>

                    <!-- Quantity -->
                    <div class="flex items-center gap-2 bg-[#EAE0CF]/40 p-1.5 rounded-xl border border-[#7288AE]/20">

                        <a href="cart_action.php?action=decrease&id=<?= $id_produk; ?>" 

                           class="w-6 h-6 bg-white text-[#4B5694] rounded-lg flex items-center justify-center font-bold text-xs hover:bg-[#EAE0CF] transition">

                            -

                        </a>

                        <span class="text-xs font-bold text-[#111844] px-1">

                            <?= $jumlah; ?>

                        </span>

                        <a href="cart_action.php?action=increase&id=<?= $id_produk; ?>" 

                           class="w-6 h-6 bg-white text-[#4B5694] rounded-lg flex items-center justify-center font-bold text-xs hover:bg-[#EAE0CF] transition">

                            +

                        </a>

                    </div>

                </div>

                <?php 
                    endif;

                endforeach; 
                ?>

            <?php else: ?>

                <!-- Empty Cart -->
                <div class="bg-white p-12 rounded-[2.5rem] shadow-sm text-center border border-[#7288AE]/20">

                    <span class="material-symbols-outlined text-[#7288AE]/40 text-6xl block mb-2">

                        shopping_basket

                    </span>

                    <p class="text-sm text-[#7288AE] font-semibold">

                        Keranjang kamu masih kosong

                    </p>

                    <a href="homepage.php"

                       class="inline-block mt-4 text-xs font-bold bg-[#EAE0CF] text-[#4B5694] px-4 py-2 rounded-full border border-[#7288AE]/20 hover:bg-[#4B5694] hover:text-white transition-all">

                        Yuk, cari makanan!

                    </a>

                </div>

            <?php endif; ?>

        </div>

        <!-- Total -->
        <?php if ($total_belanja > 0): ?>

            <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-[#7288AE]/20">

                <div class="flex justify-between items-center mb-4">

                    <span class="text-sm font-bold text-[#7288AE] uppercase tracking-wider">

                        Total Pembayaran

                    </span>

                    <span class="text-xl font-black text-[#111844]">

                        Rp <?= number_format($total_belanja, 0, ',', '.'); ?>

                    </span>

                </div>

                <!-- Button -->
                <a href="checkout_process.php"

                   class="block w-full bg-[#4B5694] text-white text-center py-4 rounded-2xl font-bold shadow-lg hover:bg-[#111844] active:scale-95 transition-all text-sm">

                    Konfirmasi & Bayar Sekarang

                </a>

            </div>

        <?php endif; ?>

    </div>

</body>
</html>