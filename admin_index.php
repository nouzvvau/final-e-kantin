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
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>Admin - Manage Menu</title>
</head>
<body class="bg-gray-50 p-8">
    <!-- Manajemen Menu Kantin -->
    <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-sm p-6">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Manajemen Menu Kantin</h1>
            <!-- Tambahkan container dengan gap yang ditentukan -->
            <div class="flex items-center gap-[10px]">
                <a href="admin_add.php" class="bg-blue-600 text-white px-4 py-2 rounded-xl flex items-center gap-2 hover:bg-blue-700">
                    <span class="material-symbols-outlined">add</span> Tambah Menu
                </a>
                
                <a href="logout.php" class="bg-red-600 text-white px-4 py-2 rounded-xl flex items-center gap-2 hover:bg-red-700">
                    <span class="material-symbols-outlined">logout</span> Logout
                </a>
            </div>
        </div>
        

        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b text-gray-400 uppercase text-sm">
                    <th class="py-4 px-2">Produk</th>
                    <th class="py-4 px-2">Kategori</th>
                    <th class="py-4 px-2">Harga</th>
                    <th class="py-4 px-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result_produk)): ?>
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-4 px-2">
                        <p class="font-semibold text-gray-800"><?= $row['nama_produk']; ?></p>
                        <p class="text-[10px] text-gray-400 italic"><?= substr($row['deskripsi'], 0, 50); ?>...</p> <!-- Menampilkan 50 karakter pertama -->
                    </td>
                    <td class="py-4 px-2 text-gray-600"><?= $row['nama_kategori']; ?></td>
                    <td class="py-4 px-2 text-blue-600 font-bold">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td class="py-4 px-2 flex justify-center gap-3">
                        <a href="admin_edit.php?id=<?= $row['id']; ?>" class="text-amber-500 hover:bg-amber-50 p-2 rounded-lg">
                            <span class="material-symbols-outlined">edit</span>
                        </a>
                        <a href="admin_delete.php?id=<?= $row['id']; ?>" onclick="return confirm('Hapus menu ini?')" class="text-red-500 hover:bg-red-50 p-2 rounded-lg">
                            <span class="material-symbols-outlined">delete</span>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <br>

    <!-- Manajemen User/Siswa -->
    <div class="max-w-5xl mx-auto bg-white rounded-3xl shadow-sm p-6 mb-12">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Manajemen Siswa</h1>
                <p class="text-sm text-gray-400">Kelola data akun dan saldo siswa</p>
            </div>
            <a href="user_add.php" class="bg-green-600 text-white px-4 py-2 rounded-xl flex items-center gap-2 hover:bg-green-700 transition-all text-sm font-bold">
                <span class="material-symbols-outlined text-sm">person_add</span> Tambah Siswa
            </a>
        </div>
        
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b text-gray-400 uppercase text-[10px] tracking-widest">
                    <th class="py-4 px-2">Nama & NISN</th>
                    <th class="py-4 px-2">Username</th>
                    <th class="py-4 px-2">Saldo Wallet</th>
                    <th class="py-4 px-2 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php while($user = mysqli_fetch_assoc($query_user)): ?>
                    <tr class="border-b hover:bg-gray-50 transition-colors">
                        <td class="py-4 px-2">
                            <p class="font-bold text-gray-800"><?= $user['nama']; ?></p>
                            <p class="text-xs text-gray-400"><?= $user['nisn']; ?></p>
                        </td>
                        <td class="py-4 px-2 text-gray-600 text-sm"><?= $user['username']; ?></td>
                        <td class="py-4 px-2">
                            <p class="text-green-600 font-black">Rp <?= number_format($user['saldo'], 0, ',', '.'); ?></p>
                        </td>
                        <td class="py-4 px-2">
                            <div class="flex justify-center gap-2">
                                <a href="user_edit.php?id=<?= $user['id']; ?>" class="text-amber-500 hover:bg-amber-50 p-2 rounded-xl transition-all">
                                    <span class="material-symbols-outlined text-xl">edit_square</span>
                                </a>
                                <a href="user_delete.php?id=<?= $user['id']; ?>" onclick="return confirm('Hapus akun <?= $user['nama']; ?>?')" class="text-red-500 hover:bg-red-50 p-2 rounded-xl transition-all">
                                    <span class="material-symbols-outlined text-xl">delete</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </body>
</html>