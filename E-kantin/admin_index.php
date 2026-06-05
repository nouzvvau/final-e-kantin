<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$total_menu = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM products WHERE status_produk = 1"));
$total_siswa = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM users WHERE role = 'user'"));
$total_pesanan_baru = mysqli_num_rows(mysqli_query($koneksi, "SELECT id FROM orders WHERE status_pesanan = 'pending' OR status_pesanan = 'diproses'"));

$query_pendapatan = mysqli_query($koneksi, "SELECT SUM(total_bayar) AS omset FROM orders WHERE status_pesanan = 'selesai' OR status_pesanan = 'diproses'");
$data_pendapatan = mysqli_fetch_assoc($query_pendapatan);
$total_pendapatan = $data_pendapatan['omset'] ? $data_pendapatan['omset'] : 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <title>Dashboard Admin - CanteenJoy</title>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#EAE0CF] min-h-screen p-4 sm:p-6">

    <div class="max-w-4xl mx-auto">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6 bg-white p-6 rounded-[2rem] shadow-sm border border-[#7288AE]/20">

            <div>

                <h1 class="text-2xl font-black text-[#111844]">
                    CanteenJoy Admin
                </h1>

                <p class="text-sm text-[#7288AE]">
                    Selamat datang di Panel Kendali Kantin
                </p>

            </div>

            <a href="logout.php"
               onclick="return confirm('Keluar dari panel admin?')"

               class="text-[#4B5694] hover:bg-[#EAE0CF]/40 p-3 rounded-2xl transition-all flex items-center gap-2 font-bold text-sm">

                <span class="material-symbols-outlined">
                    logout
                </span>

                Keluar

            </a>

        </div>

        <!-- Pendapatan -->
        <div class="bg-[#4B5694] text-white p-6 rounded-[2.5rem] shadow-xl mb-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

            <div>

                <p class="text-xs font-bold text-[#EAE0CF] uppercase tracking-widest mb-1">
                    Total Pendapatan Kantin
                </p>

                <h2 class="text-3xl font-black">
                    Rp <?= number_format($total_pendapatan, 0, ',', '.'); ?>
                </h2>

                <p class="text-[10px] text-[#EAE0CF]/70 mt-1">
                    *Akumulasi dari pesanan masuk dengan status Diproses & Selesai
                </p>

            </div>

            <div class="bg-white/10 p-4 rounded-2xl backdrop-blur-md hidden sm:block">

                <span class="material-symbols-outlined text-4xl text-white">
                    payments
                </span>

            </div>

        </div>

        <!-- Menu Dashboard -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            <!-- Menu -->
            <a href="admin_menu.php"

               class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-[#7288AE]/20 hover:shadow-md hover:border-[#4B5694]/40 transition-all group flex flex-col justify-between min-h-[160px]">

                <div class="flex justify-between items-start">

                    <div class="p-3 bg-[#EAE0CF]/50 text-[#4B5694] rounded-2xl group-hover:bg-[#4B5694] group-hover:text-white transition-all">

                        <span class="material-symbols-outlined text-2xl">
                            restaurant_menu
                        </span>

                    </div>

                    <span class="material-symbols-outlined text-[#7288AE] group-hover:text-[#4B5694] transition-colors text-sm">
                        arrow_forward_ios
                    </span>

                </div>

                <div class="mt-4">

                    <h2 class="text-base font-bold text-[#111844] mb-0.5">
                        Manajemen Menu
                    </h2>

                    <p class="text-[11px] text-[#7288AE]">
                        <?= $total_menu; ?> Item Terdaftar
                    </p>

                </div>

            </a>

            <!-- Pesanan -->
            <a href="admin_pesanan.php"

               class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-[#7288AE]/20 hover:shadow-md hover:border-[#4B5694]/40 transition-all group flex flex-col justify-between min-h-[160px]">

                <div class="flex justify-between items-start">

                    <div class="p-3 bg-[#EAE0CF]/50 text-[#4B5694] rounded-2xl group-hover:bg-[#4B5694] group-hover:text-white transition-all">

                        <span class="material-symbols-outlined text-2xl">
                            receipt_long
                        </span>

                    </div>

                    <div class="flex items-center gap-1.5">

                        <?php if($total_pesanan_baru > 0): ?>

                            <span class="bg-[#111844] text-white text-[9px] font-bold px-2 py-0.5 rounded-full animate-pulse">

                                <?= $total_pesanan_baru; ?> Baru

                            </span>

                        <?php endif; ?>

                        <span class="material-symbols-outlined text-[#7288AE] group-hover:text-[#4B5694] transition-colors text-sm">
                            arrow_forward_ios
                        </span>

                    </div>

                </div>

                <div class="mt-4">

                    <h2 class="text-base font-bold text-[#111844] mb-0.5">
                        Kelola Pesanan
                    </h2>

                    <p class="text-[11px] text-[#7288AE]">
                        Antrean & Riwayat Dapur
                    </p>

                </div>

            </a>

            <!-- Siswa -->
            <a href="admin_siswa.php"

               class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-[#7288AE]/20 hover:shadow-md hover:border-[#4B5694]/40 transition-all group flex flex-col justify-between min-h-[160px]">

                <div class="flex justify-between items-start">

                    <div class="p-3 bg-[#EAE0CF]/50 text-[#4B5694] rounded-2xl group-hover:bg-[#4B5694] group-hover:text-white transition-all">

                        <span class="material-symbols-outlined text-2xl">
                            group
                        </span>

                    </div>

                    <span class="material-symbols-outlined text-[#7288AE] group-hover:text-[#4B5694] transition-colors text-sm">
                        arrow_forward_ios
                    </span>

                </div>

                <div class="mt-4">

                    <h2 class="text-base font-bold text-[#111844] mb-0.5">
                        Manajemen Siswa
                    </h2>

                    <p class="text-[11px] text-[#7288AE]">
                        <?= $total_siswa; ?> Akun Siswa
                    </p>

                </div>

            </a>

        </div>

    </div>

</body>
</html>