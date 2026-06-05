<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$query_produk = mysqli_query($koneksi, "SELECT p.*, c.nama_kategori FROM products p LEFT JOIN categories c ON p.category_id = c.id WHERE p.status_produk = 'tersedia'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <title>Manajemen Menu - CanteenJoy</title>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#EAE0CF] p-4 sm:p-6">

    <div class="max-w-4xl mx-auto bg-white rounded-[2.5rem] shadow-sm p-6 border border-[#7288AE]/20">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">

            <div class="flex items-center gap-3">

                <a href="admin_index.php"
                   class="text-[#7288AE] hover:text-[#111844] transition-colors">

                    <span class="material-symbols-outlined">
                        arrow_back
                    </span>

                </a>

                <div>

                    <h1 class="text-2xl font-bold text-[#111844]">
                        Manajemen Menu
                    </h1>

                    <p class="text-sm text-[#7288AE]">
                        Kelola hidangan kantin
                    </p>

                </div>

            </div>

            <a href="admin_add.php"

               class="bg-[#4B5694] text-white px-4 py-2 rounded-xl flex items-center gap-2 hover:bg-[#111844] transition-all text-sm font-bold">

                <span class="material-symbols-outlined text-sm">
                    add
                </span>

                Tambah Menu

            </a>

        </div>

        <!-- Table -->
        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse min-w-[700px]">

                <thead>

                    <tr class="border-b border-[#7288AE]/20 text-[#7288AE] uppercase text-[10px] tracking-widest">

                        <th class="py-4 px-2">
                            Menu
                        </th>

                        <th class="py-4 px-2">
                            Kategori
                        </th>

                        <th class="py-4 px-2">
                            Harga
                        </th>

                        <th class="py-4 px-2 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php while($row = mysqli_fetch_assoc($query_produk)): ?>

                    <tr class="border-b border-[#7288AE]/10 hover:bg-[#EAE0CF]/20 transition-colors">

                        <!-- Menu -->
                        <td class="py-4 px-2">

                            <p class="font-bold text-[#111844]">
                                <?= $row['nama_produk']; ?>
                            </p>

                            <p class="text-[10px] text-[#7288AE] italic">
                                <?= substr($row['deskripsi'], 0, 40); ?>...
                            </p>

                        </td>

                        <!-- Kategori -->
                        <td class="py-4 px-2 text-[#4B5694] text-sm font-medium">

                            <?= $row['nama_kategori']; ?>

                        </td>

                        <!-- Harga -->
                        <td class="py-4 px-2 text-[#111844] font-black">

                            Rp <?= number_format($row['harga'], 0, ',', '.'); ?>

                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-2">

                            <div class="flex justify-center gap-2">

                                <!-- Edit -->
                                <a href="admin_edit.php?id=<?= $row['id']; ?>"

                                   class="text-[#4B5694] hover:bg-[#EAE0CF]/50 p-2 rounded-xl transition-all">

                                    <span class="material-symbols-outlined text-xl">
                                        edit_square
                                    </span>

                                </a>

                                <!-- Delete -->
                                <a href="admin_delete.php?id=<?= $row['id']; ?>"

                                   onclick="return confirm('Hapus menu <?= $row['nama_produk']; ?>?')"

                                   class="text-red-500 hover:bg-red-50 p-2 rounded-xl transition-all">

                                    <span class="material-symbols-outlined text-xl">
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