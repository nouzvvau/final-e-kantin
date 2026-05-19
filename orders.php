<?php
session_start();
include "koneksi.php";

// Proteksi: Hanya user yang bisa akses
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil riwayat pesanan dari database
// Kita urutkan berdasarkan yang terbaru (DESC)
$query_orders = mysqli_query($koneksi, "SELECT * FROM orders WHERE user_id = $user_id ORDER BY tanggal_pesan DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>Pesanan Saya - CanteenJoy</title>
</head>
<body class="bg-gray-50 pb-24">

    <!-- Header -->
    <div class="bg-white p-6 sticky top-0 z-10 shadow-sm rounded-b-[2rem]">
        <h1 class="text-xl font-black text-gray-800">Riwayat Pesanan</h1>
    </div>

    <div class="p-6 space-y-4">
        <?php if(mysqli_num_rows($query_orders) > 0): ?>
            <?php while($order = mysqli_fetch_assoc($query_orders)): 
                // Logika warna status
                $status = $order['status_pesanan'];
                $status_class = "bg-blue-50 text-blue-600"; // Default: Diproses
                if($status == 'dimasak') $status_class = "bg-amber-50 text-amber-600";
                if($status == 'selesai') $status_class = "bg-green-50 text-green-600";
                if($status == 'dibatalkan') $status_class = "bg-red-50 text-red-600";
            ?>
                <!-- Card Pesanan (Sesuai source 2) -->
                <div class="bg-white p-5 rounded-[2rem] shadow-sm border border-gray-100">
                    <div class="flex justify-between items-start mb-4">
                        <div>
                            <p class="text-xs text-gray-400">ID Pesanan: #ORD-<?= $order['id']; ?></p>
                            <p class="text-[10px] text-gray-400"><?= date('d M Y, H:i', strtotime($order['tanggal_pesan'])); ?></p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase <?= $status_class; ?>">
                            <?= $status; ?>
                        </span>
                    </div>

                    <div class="flex items-center gap-4 py-3 border-t border-dashed">
                        <div class="p-3 bg-gray-50 rounded-2xl text-red-600">
                            <span class="material-symbols-outlined">restaurant</span>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-bold text-gray-800">Total Pembayaran</p>
                            <p class="text-lg font-black text-red-600">Rp <?= number_format($order['total_bayar'], 0, ',', '.'); ?></p>
                        </div>
                    </div>

                    <div class="mt-2 pt-3 border-t border-gray-50 flex justify-between items-center">
                        <p class="text-[10px] text-gray-400 italic">Via <?= $order['metode_pembayaran']; ?></p>
                        <a href="order_detail.php?id=<?= $order['id']; ?>" class="text-xs font-bold text-blue-600 hover:underline flex items-center gap-1">
                            Lihat Detail <span class="material-symbols-outlined text-xs">arrow_forward_ios</span>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <!-- Jika belum ada pesanan -->
            <div class="text-center py-20">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="material-symbols-outlined text-gray-300 text-4xl">receipt_long</span>
                </div>
                <h3 class="text-gray-800 font-bold">Belum Ada Pesanan</h3>
                <p class="text-gray-400 text-sm mt-2">Makanan lezat sedang menunggumu!</p>
                <a href="homepage.php" class="inline-block mt-6 bg-red-600 text-white px-8 py-3 rounded-2xl font-bold">Pesan Sekarang</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Navbar Bawah (Sesuai source 4) -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 p-4 flex justify-around items-center rounded-t-[2rem] shadow-[0_-10px_20px_rgba(0,0,0,0.05)]">
        <a href="homepage.php" class="text-gray-400 flex flex-col items-center">
            <span class="material-symbols-outlined">home</span>
            <span class="text-[10px]">Home</span>
        </a>
        <a href="orders.php" class="text-red-600 flex flex-col items-center">
            <span class="material-symbols-outlined font-variation-fill">receipt_long</span>
            <span class="text-[10px] font-bold">Pesanan</span>
        </a>
        <a href="akun_user.php" class="text-gray-400 flex flex-col items-center">
            <span class="material-symbols-outlined">person</span>
            <span class="text-[10px]">Profil</span>
        </a>
    </div>

</body>
</html>