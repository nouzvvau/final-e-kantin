<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id = $user_id");
$user_data = mysqli_fetch_assoc($query_user);

$query_cat = mysqli_query($koneksi, "SELECT * FROM categories");

$filter = isset($_GET['category']) ? $_GET['category'] : '';
if ($filter) {
    $query_menu = "SELECT * FROM products WHERE category_id = '$filter' AND status_produk = 'tersedia'";
} else {
    $query_menu = "SELECT * FROM products WHERE status_produk = 'tersedia'";
}
$result_menu = mysqli_query($koneksi, $query_menu);

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

    <title>CanteenJoy - Beranda</title>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>

<body class="bg-[#EAE0CF] pb-24">

    <!-- Header -->
    <div class="p-6 bg-white rounded-b-[2.5rem] shadow-sm border-b border-[#7288AE]/10">

        <div class="flex justify-between items-center gap-4">

            <!-- User -->
            <div>

                <h2 class="text-[#7288AE] text-sm">
                    Selamat Datang,
                </h2>

                <p class="text-xl font-bold text-[#111844]">

                    <?= $user_data['nama']; ?>

                </p>

            </div>

            <!-- Saldo -->
            <div class="text-right bg-[#EAE0CF]/60 px-4 py-2 rounded-2xl border border-[#7288AE]/20 flex items-center gap-3">

                <div>

                    <p class="text-[9px] text-[#7288AE] font-bold uppercase">
                        Saldo
                    </p>

                    <p class="text-sm font-black text-[#111844]">

                        Rp <?= number_format($user_data['saldo'], 0, ',', '.'); ?>

                    </p>

                </div>

                <a href="topup.php"

                   class="bg-[#4B5694] text-white p-1 rounded-lg flex items-center justify-center hover:bg-[#111844] transition-colors">

                    <span class="material-symbols-outlined text-sm font-bold">
                        add
                    </span>

                </a>

            </div>

        </div>

    </div>

    <!-- Kategori -->
    <div class="flex gap-4 p-6 overflow-x-auto no-scrollbar">

        <!-- Semua -->
        <a href="homepage.php"

           class="px-6 py-2 rounded-full border whitespace-nowrap transition-all
           <?= !$filter 
                ? 'bg-[#4B5694] text-white border-[#4B5694]' 
                : 'bg-white text-[#7288AE] border-[#7288AE]/20 hover:bg-[#EAE0CF]/40' ?>">

            Semua

        </a>

        <!-- Dynamic Category -->
        <?php while($cat = mysqli_fetch_assoc($query_cat)): ?>

            <a href="homepage.php?category=<?= $cat['id']; ?>"

               class="px-6 py-2 rounded-full border whitespace-nowrap transition-all
               <?= $filter == $cat['id']
                    ? 'bg-[#4B5694] text-white border-[#4B5694]'
                    : 'bg-white text-[#7288AE] border-[#7288AE]/20 hover:bg-[#EAE0CF]/40' ?>">

                <?= $cat['nama_kategori']; ?>

            </a>

        <?php endwhile; ?>

    </div>

    <!-- Menu -->
    <div class="px-4 sm:px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">

        <?php if(mysqli_num_rows($result_menu) > 0): ?>

            <?php while($menu = mysqli_fetch_assoc($result_menu)): ?>

                <div class="bg-white p-3 sm:p-4 rounded-3xl shadow-sm border border-[#7288AE]/15 flex flex-col justify-between hover:shadow-md transition-all hover:-translate-y-1">

                    <div>

                        <!-- Gambar -->
                        <img src="images/<?= $menu['gambar'] ? $menu['gambar'] : 'default_food.jpg'; ?>" 

                             class="w-full aspect-square object-cover rounded-[1.5rem] mb-3 border border-[#7288AE]/10"

                             alt="<?= $menu['nama_produk']; ?>">

                        <!-- Nama -->
                        <h3 class="font-bold text-[#111844] leading-tight">

                            <?= $menu['nama_produk']; ?>

                        </h3>

                        <!-- Deskripsi -->
                        <p class="text-xs text-[#7288AE] mt-1">

                            <?= substr($menu['deskripsi'], 0, 40); ?>...

                        </p>

                    </div>

                    <!-- Footer -->
                    <div class="mt-4 flex justify-between items-center">

                        <p class="font-black text-[#4B5694]">

                            Rp <?= number_format($menu['harga'], 0, ',', '.'); ?>

                        </p>

                        <a href="add_to_cart.php?id=<?= $menu['id']; ?>"

                           class="bg-[#4B5694] text-white p-2 rounded-xl flex items-center hover:bg-[#111844] transition-all">

                            <span class="material-symbols-outlined text-sm">
                                add
                            </span>

                        </a>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <p class="col-span-full text-center text-[#7288AE] py-10">

                Maaf, menu belum tersedia.

            </p>

        <?php endif; ?>

    </div>

    <!-- Bottom Navbar -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-[#7288AE]/10 p-4 flex justify-around items-center rounded-t-[2rem] shadow-[0_-10px_20px_rgba(0,0,0,0.05)]">

        <!-- Home -->
        <a href="homepage.php"
           class="text-[#111844] flex flex-col items-center">

            <span class="material-symbols-outlined">
                home
            </span>

            <span class="text-[10px] font-bold">
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