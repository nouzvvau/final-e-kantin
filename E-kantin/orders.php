<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$query_orders = mysqli_query($koneksi, "SELECT * FROM orders WHERE user_id = $user_id ORDER BY tanggal_pesan DESC");

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

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <title>Pesanan Saya - CanteenJoy</title>

    <style>
        body {
            font-family: sans-serif;
        }
    </style>
</head>

<body class="bg-[#EAE0CF] pb-24">

    <!-- Header -->
    <div class="bg-white p-6 sticky top-0 z-10 shadow-sm rounded-b-[2rem] border-b border-[#7288AE]/20">

        <h1 class="text-xl font-black text-[#111844]">
            Riwayat Pesanan
        </h1>

    </div>

    <div class="p-6 space-y-4">

        <?php if(mysqli_num_rows($query_orders) > 0): ?>

            <?php while($order = mysqli_fetch_assoc($query_orders)): 

                $status = $order['status_pesanan'];

                $status_class = "bg-[#7288AE]/20 text-[#4B5694]";

                if($status == 'dimasak') {
                    $status_class = "bg-[#4B5694]/20 text-[#4B5694]";
                }

                if($status == 'selesai') {
                    $status_class = "bg-[#7288AE]/30 text-[#111844]";
                }

                if($status == 'dibatalkan') {
                    $status_class = "bg-red-100 text-red-600";
                }

            ?>

                <!-- Card Pesanan -->
                <div class="bg-white p-5 rounded-[2rem] shadow-sm border border-[#7288AE]/20">

                    <div class="flex justify-between items-start mb-4">

                        <div>

                            <p class="text-xs text-[#7288AE]">
                                ID Pesanan: #ORD-<?= $order['id']; ?>
                            </p>

                            <p class="text-[10px] text-[#7288AE]">
                                <?= date('d M Y, H:i', strtotime($order['tanggal_pesan'])); ?>
                            </p>

                        </div>

                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase <?= $status_class; ?>">

                            <?= $status; ?>

                        </span>

                    </div>

                    <div class="flex items-center gap-4 py-3 border-t border-dashed border-[#7288AE]/20">

                        <div class="p-3 bg-[#EAE0CF] rounded-2xl text-[#4B5694]">

                            <span class="material-symbols-outlined">
                                restaurant
                            </span>

                        </div>

                        <div class="flex-1">

                            <p class="text-sm font-bold text-[#111844]">
                                Total Pembayaran
                            </p>

                            <p class="text-lg font-black text-[#4B5694]">

                                Rp <?= number_format($order['total_bayar'], 0, ',', '.'); ?>

                            </p>

                        </div>

                    </div>

                    <div class="mt-2 pt-3 border-t border-[#7288AE]/10 flex justify-between items-center">

                        <p class="text-[10px] text-[#7288AE] italic">

                            Via <?= $order['metode_pembayaran']; ?>

                        </p>

                        <a href="order_detail.php?id=<?= $order['id']; ?>" 
                           class="text-xs font-bold text-[#4B5694] hover:text-[#111844] transition flex items-center gap-1">

                            Lihat Detail

                            <span class="material-symbols-outlined text-xs">
                                arrow_forward_ios
                            </span>

                        </a>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <!-- Jika belum ada pesanan -->

            <div class="text-center py-20">

                <div class="w-20 h-20 bg-white border border-[#7288AE]/20 rounded-full flex items-center justify-center mx-auto mb-4">

                    <span class="material-symbols-outlined text-[#7288AE] text-4xl">
                        receipt_long
                    </span>

                </div>

                <h3 class="text-[#111844] font-bold">
                    Belum Ada Pesanan
                </h3>

                <p class="text-[#7288AE] text-sm mt-2">
                    Makanan lezat sedang menunggumu!
                </p>

                <a href="homepage.php"
                   class="inline-block mt-6 bg-[#4B5694] hover:bg-[#111844] text-white px-8 py-3 rounded-2xl font-bold transition-all">

                    Pesan Sekarang

                </a>

            </div>

        <?php endif; ?>

    </div>

    <!-- Navbar -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-[#7288AE]/20 p-4 flex justify-around items-center rounded-t-[2rem] shadow-[0_-10px_20px_rgba(0,0,0,0.05)]">

        <a href="homepage.php"
           class="text-[#7288AE] flex flex-col items-center">

            <span class="material-symbols-outlined">
                home
            </span>

            <span class="text-[10px]">
                Home
            </span>

        </a>

        <a href="cart.php"
           class="text-[#7288AE] flex flex-col items-center gap-0.5 relative">

            <span class="material-symbols-outlined">
                shopping_cart
            </span>

            <?php if($total_item_keranjang > 0): ?>

            <span class="absolute -top-1 -right-2 bg-[#4B5694] text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center animate-bounce">

                <?= $total_item_keranjang; ?>

            </span>

            <?php endif; ?>

            <span class="text-[10px]">
                Cart
            </span>

        </a>

        <a href="orders.php"
           class="text-[#111844] flex flex-col items-center">

            <span class="material-symbols-outlined">
                receipt_long
            </span>

            <span class="text-[10px] font-bold">
                Pesanan
            </span>

        </a>

        <a href="akun_user.php"
           class="text-[#7288AE] flex flex-col items-center">

            <span class="material-symbols-outlined">
                person
            </span>

            <span class="text-[10px]">
                Profil
            </span>

        </a>

    </div>

</body>
</html>