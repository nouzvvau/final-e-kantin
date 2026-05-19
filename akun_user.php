<?php
session_start();
include "koneksi.php";

// 1. Proteksi Halaman: Hanya user dengan role 'user' yang bisa masuk
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

// 2. Ambil data user terbaru dari database berdasarkan session id
$user_id = $_SESSION['user_id'];
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>Profil Saya - CanteenJoy</title>
</head>
<body class="bg-gray-50 pb-24">

    <!-- Header Profil (Sesuai source 1) -->
    <div class="bg-white p-8 rounded-b-[3rem] shadow-sm text-center">
        <div class="w-24 h-24 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4 border-4 border-white shadow-md">
            <span class="material-symbols-outlined text-red-600 text-5xl">person</span>
        </div>
        <h1 class="text-2xl font-black text-gray-800"><?= $user['nama']; ?></h1>
        <p class="text-gray-400 text-sm italic">Siswa / User</p>
    </div>

    <!-- Informasi Detail (Sesuai source 1) -->
    <div class="p-6 space-y-4">
        <div class="bg-white p-6 rounded-[2rem] shadow-sm border border-gray-100 space-y-6">
            
            <div class="flex items-center gap-4">
                <div class="p-3 bg-gray-50 rounded-2xl text-gray-400">
                    <span class="material-symbols-outlined">badge</span>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Nama Lengkap</p>
                    <p class="font-semibold text-gray-800"><?= $user['nama']; ?></p>
                </div>
            </div>

            <div class="flex items-center gap-4">
                <div class="p-3 bg-gray-50 rounded-2xl text-gray-400">
                    <span class="material-symbols-outlined">id_card</span>
                </div>
                <div>
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">NISN</p>
                    <p class="font-semibold text-gray-800"><?= $user['nisn']; ?></p>
                </div>
            </div>

            <div class="flex items-center gap-4 border-t pt-6">
                <div class="p-3 bg-red-50 rounded-2xl text-red-600">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                </div>
                <div class="flex-1">
                    <p class="text-xs text-gray-400 uppercase font-bold tracking-wider">Campus Wallet</p>
                    <p class="text-xl font-black text-red-600">Rp <?= number_format($user['saldo'], 0, ',', '.'); ?></p>
                </div>
                <button class="bg-red-600 text-white px-4 py-2 rounded-xl text-xs font-bold">Top Up</button>
            </div>

        </div>

        <!-- Menu Lainnya -->
        <div class="bg-white p-2 rounded-[2rem] shadow-sm border border-gray-100 overflow-hidden">
            <a href="edit_profil.php" class="flex items-center justify-between p-4 hover:bg-gray-50 transition-all">
                <div class="flex items-center gap-3 text-gray-700">
                    <span class="material-symbols-outlined">settings</span>
                    <span class="font-medium">Pengaturan Akun</span>
                </div>
                <span class="material-symbols-outlined text-gray-300">chevron_right</span>
            </a>
            
            <hr class="mx-4 border-gray-50">

            <a href="logout.php" onclick="return confirm('Apakah Anda yakin ingin keluar?')" class="flex items-center justify-between p-4 hover:bg-red-50 transition-all text-red-600">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined">logout</span>
                    <span class="font-bold">Keluar Aplikasi</span>
                </div>
                <span class="material-symbols-outlined">chevron_right</span>
            </a>
        </div>
    </div>

    <!-- Navbar Bawah (Sesuai source 4) -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 p-4 flex justify-around items-center rounded-t-[2rem] shadow-[0_-10px_20px_rgba(0,0,0,0.05)]">
        <a href="homepage.php" class="text-gray-400 flex flex-col items-center">
            <span class="material-symbols-outlined">home</span>
            <span class="text-[10px]">Home</span>
        </a>
        <a href="orders.php" class="text-gray-400 flex flex-col items-center">
            <span class="material-symbols-outlined">receipt_long</span>
            <span class="text-[10px]">Pesanan</span>
        </a>
        <a href="akun_user.php" class="text-red-600 flex flex-col items-center">
            <span class="material-symbols-outlined font-variation-fill">person</span>
            <span class="text-[10px] font-bold">Profil</span>
        </a>
    </div>

</body>
</html>