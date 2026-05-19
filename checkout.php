<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['login']) || empty($_SESSION['cart'])) {
    header("Location: homepage.php");
    exit;
}

// Ambil data saldo terbaru user
$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM users WHERE id = $user_id"));

$total_belanja = 0;
foreach ($_SESSION['cart'] as $item) {
    $total_belanja += $item['harga'] * $item['jumlah'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>Konfirmasi Bayar</title>
</head>
<body class="bg-gray-50 p-6">
    <div class="max-w-md mx-auto">
        <h1 class="text-2xl font-black mb-6">Checkout</h1>

        <!-- Ringkasan Pesanan -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm mb-4">
            <h2 class="font-bold mb-4">Ringkasan Menu</h2>
            <?php foreach($_SESSION['cart'] as $id => $item): ?>
            <div class="flex justify-between mb-2">
                <p class="text-gray-600"><?= $item['nama']; ?> (x1)</p>
                <p class="font-bold text-gray-800">Rp <?= number_format($item['harga'], 0, ',', '.'); ?></p>
            </div>
            <?php endforeach; ?>
            <div class="border-t mt-4 pt-4 flex justify-between">
                <p class="font-bold">Total Tagihan</p>
                <p class="font-black text-red-600 text-xl">Rp <?= number_format($total_belanja, 0, ',', '.'); ?></p>
            </div>
        </div>

        <!-- Metode Pembayaran & Saldo (Sesuai source 2) -->
        <div class="bg-white p-6 rounded-[2rem] shadow-sm mb-6 border-2 border-red-100">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-red-600">account_balance_wallet</span>
                    <div>
                        <p class="text-xs text-gray-400">Saldo Campus Wallet</p>
                        <p class="font-bold">Rp <?= number_format($user['saldo'], 0, ',', '.'); ?></p>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($user['saldo'] >= $total_belanja): ?>
            <a href="proses_bayar.php" class="block w-full bg-red-600 text-white text-center py-4 rounded-2xl font-bold shadow-lg">
                Bayar Sekarang
            </a>
        <?php else: ?>
            <div class="bg-red-50 p-4 rounded-2xl text-red-600 text-center mb-4">
                <p class="text-sm font-bold">Saldo Tidak Cukup!</p>
            </div>
            <a href="akun_user.php" class="block w-full bg-gray-200 text-gray-600 text-center py-4 rounded-2xl font-bold">
                Top Up Saldo
            </a>
        <?php endif; ?>
    </div>
</body>
</html>