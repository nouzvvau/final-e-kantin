<?php
session_start();
include "koneksi.php";

// 1. Proteksi Admin: Hanya admin yang boleh mengedit user
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}

// 2. Ambil ID User dari URL
if (!isset($_GET['id'])) {
    header("Location: admin_index.php");
    exit;
}
$id = $_GET['id'];

// 3. Ambil data lama user untuk ditampilkan di form
$query = mysqli_query($koneksi, "SELECT * FROM users WHERE id = $id");
$user = mysqli_fetch_assoc($query);

// Jika user tidak ditemukan
if (!$user) {
    echo "<script>alert('User tidak ditemukan!'); window.location='admin_index.php';</script>";
    exit;
}

// 4. Logika Update Data
if (isset($_POST['update'])) {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $nisn     = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $saldo    = $_POST['saldo'];

    $sql = "UPDATE users SET 
            nama     = '$nama', 
            username = '$username', 
            nisn     = '$nisn', 
            saldo    = '$saldo' 
            WHERE id = $id";

    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Data siswa berhasil diperbarui!'); window.location='admin_index.php';</script>";
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <title>Edit Siswa - Admin Panel</title>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-6">

    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl w-full max-w-md border border-gray-100">
        <!-- Header -->
        <div class="flex items-center gap-3 mb-8">
            <a href="admin_index.php" class="text-gray-400 hover:text-gray-600 transition-colors">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h2 class="text-2xl font-bold text-gray-800">Edit Data Siswa</h2>
        </div>

        <?php if(isset($error)): ?>
            <div class="bg-red-50 text-red-500 p-3 rounded-xl mb-4 text-xs text-center">
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
            <!-- Nama Lengkap -->
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase ml-2 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="<?= $user['nama']; ?>" 
                       class="w-full border-gray-100 border bg-gray-50 rounded-2xl p-3 outline-none focus:ring-2 focus:ring-blue-500 transition-all" required>
            </div>

            <!-- NISN -->
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase ml-2 mb-1">NISN</label>
                <input type="number" name="nisn" value="<?= $user['nisn']; ?>" 
                       class="w-full border-gray-100 border bg-gray-50 rounded-2xl p-3 outline-none focus:ring-2 focus:ring-blue-500 transition-all" required>
            </div>

            <!-- Username -->
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase ml-2 mb-1">Username</label>
                <input type="text" name="username" value="<?= $user['username']; ?>" 
                       class="w-full border-gray-100 border bg-gray-50 rounded-2xl p-3 outline-none focus:ring-2 focus:ring-blue-500 transition-all" required>
            </div>

            <!-- Saldo (Fitur Top Up Admin) -->
            <div>
                <label class="block text-xs font-bold text-blue-600 uppercase ml-2 mb-1">Saldo Wallet (Rp)</label>
                <div class="relative">
                    <span class="absolute left-4 top-3 text-gray-400">Rp</span>
                    <input type="number" name="saldo" value="<?= $user['saldo']; ?>" 
                           class="w-full border-blue-100 border bg-blue-50 rounded-2xl p-3 pl-10 outline-none focus:ring-2 focus:ring-blue-500 font-bold text-blue-700 transition-all" required>
                </div>
                <p class="text-[10px] text-gray-400 mt-1 ml-2">*Ubah angka ini untuk menambah/mengurangi saldo siswa secara manual[cite: 2].</p>
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-4 flex flex-col gap-3">
                <button type="submit" name="update" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 active:scale-95 transition-all">
                    Simpan Perubahan
                </button>
                <a href="admin_index.php" class="text-center text-gray-400 text-sm font-medium hover:text-gray-600">
                    Batalkan
                </a>
            </div>
        </form>
    </div>

</body>
</html>