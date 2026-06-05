<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$query_orders = mysqli_query($koneksi, "SELECT o.*, u.nama FROM orders o JOIN users u ON o.user_id = u.id ORDER BY o.tanggal_pesan DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <title>Kelola Pesanan - CanteenJoy</title>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#EAE0CF] p-4 sm:p-6">

    <div class="max-w-5xl mx-auto bg-white rounded-[2.5rem] shadow-sm p-6 border border-[#7288AE]/20">

        <!-- Header -->
        <div class="flex items-start gap-3 mb-8">

            <a href="admin_index.php"
               class="text-[#7288AE] hover:text-[#111844] transition-colors mt-1">

                <span class="material-symbols-outlined">
                    arrow_back
                </span>

            </a>

            <div>

                <h1 class="text-2xl font-bold text-[#111844]">
                    Kelola & Laporan Pesanan
                </h1>

                <p class="text-sm text-[#7288AE]">
                    Pantau pesanan masuk dan perbarui status pengerjaan makanan
                </p>

            </div>

        </div>

        <!-- Table -->
        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse min-w-[900px]">

                <thead>

                    <tr class="border-b border-[#7288AE]/20 text-[#7288AE] uppercase text-[10px] tracking-widest">

                        <th class="py-4 px-2">
                            ID & Waktu
                        </th>

                        <th class="py-4 px-2">
                            Nama Siswa
                        </th>

                        <th class="py-4 px-2">
                            Total Bayar
                        </th>

                        <th class="py-4 px-2">
                            Metode
                        </th>

                        <th class="py-4 px-2 text-center">
                            Status Pesanan
                        </th>

                        <th class="py-4 px-2 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php if(mysqli_num_rows($query_orders) > 0): ?>

                        <?php while($order = mysqli_fetch_assoc($query_orders)): ?>

                        <tr class="border-b border-[#7288AE]/10 hover:bg-[#EAE0CF]/20 transition-colors">

                            <!-- ID -->
                            <td class="py-4 px-2">

                                <p class="font-bold text-[#111844]">
                                    #CJ-<?= $order['id']; ?>
                                </p>

                                <p class="text-[10px] text-[#7288AE]">

                                    <?= date('d M, H:i', strtotime($order['tanggal_pesan'])); ?>

                                </p>

                            </td>

                            <!-- Nama -->
                            <td class="py-4 px-2 font-medium text-[#4B5694] text-sm">

                                <?= $order['nama']; ?>

                            </td>

                            <!-- Total -->
                            <td class="py-4 px-2 text-[#111844] font-black text-sm">

                                Rp <?= number_format($order['total_bayar'], 0, ',', '.'); ?>

                            </td>

                            <!-- Metode -->
                            <td class="py-4 px-2 text-[#7288AE] text-xs uppercase font-bold">

                                <?= $order['metode_pembayaran']; ?>

                            </td>

                            <!-- Status -->
                            <td class="py-4 px-2 text-center">

                                <?php 
                                    $status = $order['status_pesanan'];

                                    if ($status == 'pending') {

                                        echo '
                                        <span class="bg-[#EAE0CF] text-[#4B5694] text-[10px] font-bold px-3 py-1 rounded-full border border-[#7288AE]/20 uppercase">
                                            Diterima
                                        </span>';

                                    } elseif ($status == 'diproses') {

                                        echo '
                                        <span class="bg-[#4B5694]/10 text-[#4B5694] text-[10px] font-bold px-3 py-1 rounded-full border border-[#4B5694]/20 uppercase">
                                            Diproses
                                        </span>';

                                    } elseif ($status == 'selesai') {

                                        echo '
                                        <span class="bg-[#111844]/10 text-[#111844] text-[10px] font-bold px-3 py-1 rounded-full border border-[#111844]/20 uppercase">
                                            Selesai
                                        </span>';

                                    } else {

                                        echo '
                                        <span class="bg-gray-100 text-gray-500 text-[10px] font-bold px-3 py-1 rounded-full border border-gray-200 uppercase">
                                            Batal
                                        </span>';

                                    }
                                ?>

                            </td>

                            <!-- Tombol -->
                            <td class="py-4 px-2">

                                <div class="flex justify-center gap-1">

                                    <?php if($status == 'pending'): ?>

                                        <a href="order_update_status.php?id=<?= $order['id']; ?>&status=diproses"

                                           class="bg-[#4B5694] text-white text-[11px] font-bold px-3 py-1.5 rounded-xl shadow-sm hover:bg-[#111844] transition-all">

                                            Proses Masak

                                        </a>

                                    <?php elseif($status == 'diproses'): ?>

                                        <a href="order_update_status.php?id=<?= $order['id']; ?>&status=selesai"

                                           class="bg-[#111844] text-white text-[11px] font-bold px-3 py-1.5 rounded-xl shadow-sm hover:bg-[#4B5694] transition-all">

                                            Siap Diambil

                                        </a>

                                    <?php else: ?>

                                        <span class="text-[#7288AE] text-xs">
                                            -
                                        </span>

                                    <?php endif; ?>

                                </div>

                            </td>

                        </tr>

                        <?php endwhile; ?>

                    <?php else: ?>

                        <tr>

                            <td colspan="6"
                                class="text-center py-12 text-sm text-[#7288AE] font-medium">

                                Belum ada transaksi masuk saat ini.

                            </td>

                        </tr>

                    <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</body>
</html>