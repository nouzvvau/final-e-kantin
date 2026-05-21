<?php
session_start();

// Cek apakah sudah login DAN apakah rolenya admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include "koneksi.php";
$query_produk = "SELECT p.*, c.nama_kategori FROM products p LEFT JOIN categories c ON p.category_id = c.id";
$result_produk = mysqli_query($koneksi, $query_produk);

$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE role = 'user' ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>Admin - Manage Menu</title>
</head>

<body class="bg-gray-50 p-4 md:p-8">

    <!-- MANAJEMEN MENU KANTIN -->

    <div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-sm p-5 md:p-6 border border-gray-100">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-gray-800">Manajemen Menu Kantin</h1>
                <p class="text-sm text-gray-400 mt-1">Kelola seluruh menu makanan dan minuman</p>
            </div>

            <!-- Button -->
            <div class="flex flex-wrap items-center gap-3">

                <a href="admin_add.php"
                   class="bg-amber-500 hover:bg-amber-600
                   text-white px-4 py-3 rounded-2xl
                   flex items-center gap-2
                   transition-all duration-300
                   shadow-sm">
                    <span class="material-symbols-outlined">add</span>
                    Tambah Menu
                </a>

                <a href="logout.php"
                   class="bg-red-600 hover:bg-red-700
                   text-white px-4 py-3 rounded-2xl
                   flex items-center gap-2
                   transition-all duration-300
                   shadow-sm">
                    <span class="material-symbols-outlined">logout</span>
                    Logout
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-2xl">
            <table class="w-full min-w-[700px] text-left border-collapse">
                <!-- Head -->
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400 uppercase text-xs tracking-wider">
                        <th class="py-4 px-3">Produk</th>
                        <th class="py-4 px-3">Kategori</th>
                        <th class="py-4 px-3">Harga</th>
                        <th class="py-4 px-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody>
                    <?php while($row = mysqli_fetch_assoc($result_produk)): ?>
                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all">
                        <!-- Produk -->
                        <td class="py-4 px-3">
                            <p class="font-bold text-gray-800"><?= $row['nama_produk']; ?></p>
                            <p class="text-xs text-gray-400 italic mt-1"><?= substr($row['deskripsi'], 0, 50); ?>...</p>
                        </td>

                        <!-- Kategori -->
                        <td class="py-4 px-3 text-gray-600 font-medium"> <?= $row['nama_kategori']; ?> </td>

                        <!-- Harga -->
                        <td class="py-4 px-3"> <p class="text-orange-500 font-black">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></p> </td>

                        <!-- Aksi -->
                        <td class="py-4 px-3">

                            <div class="flex justify-center gap-2">

                                <!-- Edit -->
                                <a href="admin_edit.php?id=<?= $row['id']; ?>"
                                   class="text-amber-500 hover:bg-amber-50
                                   p-2 rounded-xl transition-all">
                                    <span class="material-symbols-outlined">edit</span>
                                </a>

                                <!-- Delete -->
                                <a href="admin_delete.php?id=<?= $row['id']; ?>"
                                   onclick="return confirm('Hapus menu ini?')"
                                   class="text-red-500 hover:bg-red-50
                                   p-2 rounded-xl transition-all">
                                    <span class="material-symbols-outlined">delete</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Spacing -->
    <div class="h-6"></div>

    <!-- MANAJEMEN SISWA -->
    <div class="max-w-6xl mx-auto bg-white rounded-3xl shadow-sm p-5 md:p-6 border border-gray-100 mb-10">

        <!-- Header -->
        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-black text-gray-800">Manajemen Siswa</h1>
                <p class="text-sm text-gray-400 mt-1">Kelola akun dan saldo siswa</p>
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto rounded-2xl">

            <table class="w-full min-w-[700px] text-left border-collapse">

                <!-- Head -->
                <thead>
                    <tr class="border-b border-gray-100 text-gray-400 uppercase text-xs tracking-wider">
                        <th class="py-4 px-3">Nama & NISN</th>
                        <th class="py-4 px-3">Username</th>
                        <th class="py-4 px-3">Saldo Wallet</th>
                        <th class="py-4 px-3 text-center">Aksi</th>
                    </tr>
                </thead>

                <!-- Body -->
                <tbody>

                    <?php while($user = mysqli_fetch_assoc($query_user)): ?>

                    <tr class="border-b border-gray-100 hover:bg-gray-50 transition-all">

                        <!-- Nama -->
                        <td class="py-4 px-3">
                            <p class="font-bold text-gray-800">
                                <?= $user['nama']; ?>
                            </p>
                            <p class="text-xs text-gray-400 mt-1">
                                <?= $user['nisn']; ?>
                            </p>
                        </td>

                        <!-- Username -->
                        <td class="py-4 px-3 text-gray-600 text-sm">
                            <?= $user['username']; ?>
                        </td>

                        <!-- Saldo -->
                        <td class="py-4 px-3">
                            <p class="text-orange-500 font-black">
                                Rp <?= number_format($user['saldo'], 0, ',', '.'); ?>
                            </p>
                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-3">
                            <div class="flex justify-center gap-2">
                                <!-- Edit -->
                                <a href="user_edit.php?id=<?= $user['id']; ?>"
                                   class="text-amber-500 hover:bg-amber-50
                                   p-2 rounded-xl transition-all">
                                    <span class="material-symbols-outlined">
                                        edit_square
                                    </span>
                                </a>

                                <!-- Delete -->
                                <a href="user_delete.php?id=<?= $user['id']; ?>"
                                   onclick="return confirm('Hapus akun <?= $user['nama']; ?>?')"
                                   class="text-red-500 hover:bg-red-50
                                   p-2 rounded-xl transition-all">
                                    <span class="material-symbols-outlined">
                                        delete
                                    </span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>