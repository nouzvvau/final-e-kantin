<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($query);

$total_item_keranjang = 0;
if (isset($_SESSION['cart'])) {
    $total_item_keranjang = array_sum($_SESSION['cart']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <title>Profil Saya - CanteenJoy</title>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#EAE0CF] pb-24">

    <!-- Header Profil -->
    <div class="bg-white p-8 rounded-b-[3rem] shadow-sm text-center border-b border-[#7288AE]/10">

        <div class="w-24 h-24 bg-[#EAE0CF] rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-md">

            <span class="material-symbols-outlined text-[#4B5694] text-5xl">
                person
            </span>

        </div>

        <h1 class="text-2xl font-black text-[#111844]">
            <?= $user['nama']; ?>
        </h1>

        <p class="text-[#7288AE] text-sm italic">
            Siswa / User
        </p>

    </div>

    <!-- Informasi -->
    <div class="p-6 space-y-4">

        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-[#7288AE]/20 space-y-6">

            <!-- Nama -->
            <div class="flex items-center gap-4">

                <div class="p-3 bg-[#EAE0CF]/40 rounded-2xl text-[#7288AE]">

                    <span class="material-symbols-outlined">
                        badge
                    </span>

                </div>

                <div>

                    <p class="text-xs text-[#7288AE] uppercase font-bold tracking-wider">
                        Nama Lengkap
                    </p>

                    <p class="font-semibold text-[#111844]">
                        <?= $user['nama']; ?>
                    </p>

                </div>

            </div>

            <!-- NISN -->
            <div class="flex items-center gap-4">

                <div class="p-3 bg-[#EAE0CF]/40 rounded-2xl text-[#7288AE]">

                    <span class="material-symbols-outlined">
                        id_card
                    </span>

                </div>

                <div>

                    <p class="text-xs text-[#7288AE] uppercase font-bold tracking-wider">
                        NISN
                    </p>

                    <p class="font-semibold text-[#111844]">
                        <?= $user['nisn']; ?>
                    </p>

                </div>

            </div>

            <!-- Wallet -->
            <div class="flex items-center gap-4 border-t border-[#7288AE]/10 pt-6">

                <div class="p-3 bg-[#4B5694]/10 rounded-2xl text-[#4B5694]">

                    <span class="material-symbols-outlined">
                        account_balance_wallet
                    </span>

                </div>

                <div class="flex-1">

                    <p class="text-xs text-[#7288AE] uppercase font-bold tracking-wider">
                        Campus Wallet
                    </p>

                    <p class="text-xl font-black text-[#111844]">

                        Rp <?= number_format($user['saldo'], 0, ',', '.'); ?>

                    </p>

                </div>

                <a href="topup.php">

                    <button class="bg-[#4B5694] hover:bg-[#111844] text-white px-4 py-2 rounded-xl text-xs font-bold transition-all">

                        Top Up

                    </button>

                </a>

            </div>

        </div>

        <!-- Menu -->
        <div class="bg-white p-2 rounded-[2rem] shadow-sm border border-[#7288AE]/20 overflow-hidden">

            <hr class="mx-4 border-[#7288AE]/10">

            <!-- Logout -->
            <a href="logout.php"
               onclick="return confirm('Apakah Anda yakin ingin keluar?')"

               class="flex items-center justify-between p-4 hover:bg-red-50 transition-all text-red-500">

                <div class="flex items-center gap-3">

                    <span class="material-symbols-outlined">
                        logout
                    </span>

                    <span class="font-bold">
                        Keluar Aplikasi
                    </span>

                </div>

                <span class="material-symbols-outlined">
                    chevron_right
                </span>

            </a>

        </div>

    </div>

    <!-- Bottom Navbar -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-[#7288AE]/10 p-4 flex justify-around items-center rounded-t-[2rem] shadow-[0_-10px_20px_rgba(0,0,0,0.05)]">

        <!-- Home -->
        <a href="homepage.php"
           class="text-[#7288AE] flex flex-col items-center">

            <span class="material-symbols-outlined">
                home
            </span>

            <span class="text-[10px]">
                Home
            </span>

        </a>

        <!-- Cart -->
        <a href="cart.php"
           class="text-[#7288AE] flex flex-col items-center gap-0.5 relative">

            <span class="material-symbols-outlined">
                shopping_cart
            </span>

            <?php if($total_item_keranjang > 0): ?>

            <span class="absolute -top-1 -right-2 bg-[#111844] text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center animate-bounce">

                <?= $total_item_keranjang; ?>

            </span>

            <?php endif; ?>

            <span class="text-[10px]">
                Cart
            </span>

        </a>

        <!-- Pesanan -->
        <a href="orders.php"
           class="text-[#7288AE] flex flex-col items-center">

            <span class="material-symbols-outlined">
                receipt_long
            </span>

            <span class="text-[10px]">
                Pesanan
            </span>

        </a>

        <!-- Profil -->
        <a href="akun_user.php"
           class="text-[#111844] flex flex-col items-center">

            <span class="material-symbols-outlined font-variation-fill">
                person
            </span>

            <span class="text-[10px] font-bold">
                Profil
            </span>

        </a>

    </div>

</body>
</html>