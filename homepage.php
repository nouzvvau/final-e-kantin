<?php
session_start();
include "koneksi.php";

// Proteksi halaman: Hanya user yang sudah login yang bisa masuk
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: login.php");
    exit;
}

// Ambil data user terbaru (terutama saldo) dari database
$user_id = $_SESSION['user_id'];
$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE id = $user_id");
$user_data = mysqli_fetch_assoc($query_user);

// Ambil data kategori untuk filter (Main Course, Drinks, dll)
$query_cat = mysqli_query($koneksi, "SELECT * FROM categories");

// Logika Filter: Jika user klik kategori tertentu
$filter = isset($_GET['category']) ? $_GET['category'] : '';
if ($filter) {
    $query_menu = "SELECT * FROM products WHERE category_id = '$filter' AND status_produk = 'tersedia'";
} else {
    $query_menu = "SELECT * FROM products WHERE status_produk = 'tersedia'";
}
$result_menu = mysqli_query($koneksi, $query_menu);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>CanteenJoy - Beranda</title>
</head>
<body class="bg-gray-50 pb-24"> <!-- pb-24 agar tidak tertutup navbar bawah -->

    <!-- Header Profil (Sesuai source 1 & 2) -->
    <div class="p-6 bg-white rounded-b-[2.5rem] shadow-sm">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-gray-400 text-sm">Selamat Datang,</h2>
                <p class="text-xl font-bold text-gray-800"><?= $user_data['nama']; ?></p>
            </div>
            <div class="text-right">
                <p class="text-xs text-gray-400">Saldo Wallet</p>
                <p class="text-lg font-black text-red-600">Rp <?= number_format($user_data['saldo'], 0, ',', '.'); ?></p>
            </div>
        </div>
    </div>

    <!-- Filter Kategori (Dinamis dari database) -->
    <div class="flex gap-4 p-6 overflow-x-auto no-scrollbar">
        <a href="homepage.php" class="px-6 py-2 rounded-full border <?= !$filter ? 'bg-red-600 text-white border-red-600' : 'bg-white text-gray-600' ?> whitespace-nowrap">
            Semua
        </a>
        <?php while($cat = mysqli_fetch_assoc($query_cat)): ?>
            <a href="homepage.php?category=<?= $cat['id']; ?>" 
               class="px-6 py-2 rounded-full border <?= $filter == $cat['id'] ? 'bg-red-600 text-white border-red-600' : 'bg-white text-gray-600' ?> whitespace-nowrap">
                <?= $cat['nama_kategori']; ?>
            </a>
        <?php endwhile; ?>
    </div>

    <!-- Daftar Menu (Dinamis dari database produk) -->
    <div class="px-6 grid grid-cols-2 gap-4">
        <?php if(mysqli_num_rows($result_menu) > 0): ?>
            <?php while($menu = mysqli_fetch_assoc($result_menu)): ?>
                <div class="bg-white p-4 rounded-[2rem] shadow-sm border border-gray-100 flex flex-col justify-between">
                    <div>
                        <!-- Pastikan nama file gambar sesuai dengan yang ada di folder images kamu -->
                        <img src="images/<?= $menu['gambar'] ? $menu['gambar'] : 'default_food.jpg'; ?>" 
                             class="w-full h-32 object-cover rounded-[1.5rem] mb-3" alt="<?= $menu['nama_produk']; ?>">
                        <h3 class="font-bold text-gray-800 leading-tight"><?= $menu['nama_produk']; ?></h3>
                        <p class="text-xs text-gray-400 mt-1"><?= substr($menu['deskripsi'], 0, 40); ?>...</p>
                    </div>
                    <div class="mt-4 flex justify-between items-center">
                        <p class="font-black text-red-600">Rp <?= number_format($menu['harga'], 0, ',', '.'); ?></p>
                        <a href="add_to_cart.php?id=<?= $menu['id']; ?>" class="bg-red-600 text-white p-2 rounded-xl flex items-center">
                            <span class="material-symbols-outlined text-sm">add</span>
                        </a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p class="col-span-2 text-center text-gray-400 py-10">Maaf, menu belum tersedia.</p>
        <?php endif; ?>
    </div>

    <!-- Navbar Bawah (Sesuai source 4) -->
    <div class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-100 p-4 flex justify-around items-center rounded-t-[2rem] shadow-[0_-10px_20px_rgba(0,0,0,0.05)]">
        <a href="homepage.php" class="text-red-600 flex flex-col items-center">
            <span class="material-symbols-outlined">home</span>
            <span class="text-[10px] font-bold">Home</span>
        </a>
        <a href="orders.php" class="text-gray-400 flex flex-col items-center">
            <span class="material-symbols-outlined">receipt_long</span>
            <span class="text-[10px]">Pesanan</span>
        </a>
        <a href="akun_user.php" class="text-gray-400 flex flex-col items-center">
            <span class="material-symbols-outlined">person</span>
            <span class="text-[10px]">Profil</span>
        </a>
    </div>

</body>
</html>