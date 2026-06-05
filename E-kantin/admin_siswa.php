<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

$query_user = mysqli_query($koneksi, "SELECT * FROM users WHERE status_user='aktif' AND role = 'user' ORDER BY nama ASC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <title>Manajemen Siswa - CanteenJoy</title>

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
                        Manajemen Siswa
                    </h1>

                    <p class="text-sm text-[#7288AE]">
                        Kelola akun & top up siswa
                    </p>

                </div>

            </div>

            <!-- Tombol Tambah -->
            <a href="user_add.php"

               class="bg-[#4B5694] text-white px-4 py-2 rounded-xl flex items-center gap-2 hover:bg-[#111844] transition-all text-sm font-bold">

                <span class="material-symbols-outlined text-sm">
                    person_add
                </span>

                Tambah Siswa

            </a>

        </div>

        <!-- Table -->
        <div class="overflow-x-auto">

            <table class="w-full text-left border-collapse min-w-[700px]">

                <thead>

                    <tr class="border-b border-[#7288AE]/20 text-[#7288AE] uppercase text-[10px] tracking-widest">

                        <th class="py-4 px-2">
                            Nama & NISN
                        </th>

                        <th class="py-4 px-2">
                            Username
                        </th>

                        <th class="py-4 px-2">
                            Saldo Wallet
                        </th>

                        <th class="py-4 px-2 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    <?php while($user = mysqli_fetch_assoc($query_user)): ?>

                    <tr class="border-b border-[#7288AE]/10 hover:bg-[#EAE0CF]/20 transition-colors">

                        <!-- Nama -->
                        <td class="py-4 px-2">

                            <p class="font-bold text-[#111844]">
                                <?= $user['nama']; ?>
                            </p>

                            <p class="text-xs text-[#7288AE]">
                                <?= $user['nisn']; ?>
                            </p>

                        </td>

                        <!-- Username -->
                        <td class="py-4 px-2 text-[#4B5694] text-sm font-medium">

                            <?= $user['username']; ?>

                        </td>

                        <!-- Saldo -->
                        <td class="py-4 px-2">

                            <p class="text-[#111844] font-black">

                                Rp <?= number_format($user['saldo'], 0, ',', '.'); ?>

                            </p>

                        </td>

                        <!-- Aksi -->
                        <td class="py-4 px-2">

                            <div class="flex justify-center gap-2">

                                <!-- Edit -->
                                <a href="user_edit.php?id=<?= $user['id']; ?>"

                                   class="text-[#4B5694] hover:bg-[#EAE0CF]/50 p-2 rounded-xl transition-all">

                                    <span class="material-symbols-outlined text-xl">
                                        edit_square
                                    </span>

                                </a>

                                <!-- Delete -->
                                <a href="user_delete.php?id=<?= $user['id']; ?>"

                                   onclick="return confirm('Hapus akun <?= $user['nama']; ?>?')"

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