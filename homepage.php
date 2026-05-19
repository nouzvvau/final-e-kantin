<?php
session_start();
include "koneksi.php";

// Proteksi halaman: Hanya user yang sudah login yang bisa masuk
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

// Ambil data user terbaru
$user_id = $_SESSION['user_id'];
$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id = $user_id");
$user_data = mysqli_fetch_assoc($query_user);

// Ambil data kategori
$query_cat = mysqli_query($koneksi, "SELECT * FROM categories");

// Filter kategori
$filter = isset($_GET['category']) ? $_GET['category'] : '';

if ($filter) {
    $query_menu = "SELECT * FROM products 
                   WHERE category_id = '$filter' 
                   AND status_produk = 'tersedia'";
} else {
    $query_menu = "SELECT * FROM products 
                   WHERE status_produk = 'tersedia'";
}

$result_menu = mysqli_query($koneksi, $query_menu);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Icon -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <title>CanteenJoy - Beranda</title>
</head>

<body class="bg-gray-50 pb-28">

    <!-- HEADER -->
    <div class="bg-white rounded-b-[2rem] shadow-sm px-4 md:px-6 py-5">
        
        <div class="flex justify-between items-center gap-4">

            <!-- Kiri -->
            <div class="min-w-0">
                <h2 class="text-gray-400 text-sm">
                    Selamat Datang,
                </h2>

                <p class="text-lg md:text-2xl font-bold text-gray-800 truncate">
                    <?= $user_data['nama']; ?>
                </p>
            </div>

            <!-- Kanan -->
            <div class="text-right shrink-0">
                <p class="text-xs text-gray-400">
                    Saldo Wallet
                </p>

                <p class="text-base md:text-xl font-black text-red-600">
                    Rp <?= number_format($user_data['saldo'], 0, ',', '.'); ?>
                </p>
            </div>

        </div>
    </div>

    <!-- FILTER KATEGORI -->
    <div class="flex gap-3 px-4 md:px-6 py-5 overflow-x-auto whitespace-nowrap">

        <!-- Semua -->
        <a href="homepage.php"
           class="px-5 py-2 rounded-full border text-sm transition duration-200
           <?= !$filter
                ? 'bg-red-600 text-white border-red-600'
                : 'bg-white text-gray-600 border-gray-200 hover:bg-red-50'; ?>">
            Semua
        </a>

        <!-- Kategori -->
        <?php while($cat = mysqli_fetch_assoc($query_cat)): ?>

            <a href="homepage.php?category=<?= $cat['id']; ?>"
               class="px-5 py-2 rounded-full border text-sm transition duration-200
               <?= $filter == $cat['id']
                    ? 'bg-red-600 text-white border-red-600'
                    : 'bg-white text-gray-600 border-gray-200 hover:bg-red-50'; ?>">

                <?= $cat['nama_kategori']; ?>

            </a>

        <?php endwhile; ?>

    </div>

    <!-- DAFTAR MENU -->
    <div class="px-4 md:px-6 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 md:gap-6">

        <?php if(mysqli_num_rows($result_menu) > 0): ?>

            <?php while($menu = mysqli_fetch_assoc($result_menu)): ?>

                <div class="bg-white rounded-[1.8rem] shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition duration-300 flex flex-col">

                    <!-- Gambar -->
                    <div class="p-3">

                        <img
                            src="images/<?= $menu['gambar'] ? $menu['gambar'] : 'default_food.jpg'; ?>"
                            alt="<?= $menu['nama_produk']; ?>"
                            class="w-full h-32 md:h-40 lg:h-48 object-cover rounded-[1.3rem]"
                        >

                    </div>

                    <!-- Isi -->
                    <div class="px-4 pb-4 flex flex-col flex-1">

                        <!-- Nama -->
                        <h3 class="font-bold text-gray-800 text-sm md:text-base leading-tight line-clamp-2">
                            <?= $menu['nama_produk']; ?>
                        </h3>

                        <!-- Deskripsi -->
                        <p class="text-xs md:text-sm text-gray-400 mt-2 line-clamp-2">
                            <?= substr($menu['deskripsi'], 0, 50); ?>...
                        </p>

                        <!-- Bawah -->
                        <div class="mt-auto pt-4 flex justify-between items-center gap-2">

                            <!-- Harga -->
                            <p class="font-black text-red-600 text-sm md:text-base">
                                Rp <?= number_format($menu['harga'], 0, ',', '.'); ?>
                            </p>

                            <!-- Tombol -->
                            <a href="add_to_cart.php?id=<?= $menu['id']; ?>"
                               class="bg-red-600 hover:bg-red-700 transition duration-200 text-white p-2.5 rounded-xl flex items-center justify-center shrink-0">

                                <span class="material-symbols-outlined text-base">
                                    add
                                </span>

                            </a>

                        </div>

                    </div>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="col-span-full text-center py-16">

                <p class="text-gray-400 text-sm md:text-base">
                    Maaf, menu belum tersedia.
                </p>

            </div>

        <?php endif; ?>

    </div>

    <!-- NAVBAR BAWAH -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 px-4 py-3 flex justify-around items-center rounded-t-[2rem] shadow-[0_-5px_20px_rgba(0,0,0,0.05)] z-50">

        <!-- Home -->
        <a href="homepage.php"
           class="text-red-600 flex flex-col items-center gap-1">

            <span class="material-symbols-outlined">
                home
            </span>

            <span class="text-[11px] font-bold">
                Home
            </span>

        </a>

        <!-- Pesanan -->
        <a href="orders.php"
           class="text-gray-400 hover:text-red-600 transition duration-200 flex flex-col items-center gap-1">

            <span class="material-symbols-outlined">
                receipt_long
            </span>

            <span class="text-[11px]">
                Pesanan
            </span>

        </a>

        <!-- Profil -->
        <a href="akun_user.php"
           class="text-gray-400 hover:text-red-600 transition duration-200 flex flex-col items-center gap-1">

            <span class="material-symbols-outlined">
                person
            </span>

            <span class="text-[11px]">
                Profil
            </span>

        </a>

    </div>

</body>
</html>