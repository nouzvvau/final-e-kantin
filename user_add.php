<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $nama     = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nisn     = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; 
    $saldo    = $_POST['saldo'];

    $check_user = mysqli_query($koneksi, "SELECT * FROM users WHERE nisn = '$nisn' OR username = '$username'");
    
    if (mysqli_num_rows($check_user) > 0) {
        $error = "Gagal! NISN atau Username sudah digunakan oleh siswa lain.";
    } else {
        $sql = "INSERT INTO users (nama, nisn, username, password, role, saldo) 
                VALUES ('$nama', '$nisn', '$username', '$password', 'user', '$saldo')";
        
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('Siswa baru berhasil ditambahkan!'); window.location='admin_siswa.php';</script>";
            exit;
        } else {
            $error = "Gagal menambahkan data: " . mysqli_error($koneksi);
        }
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
    
    <title>Tambah Siswa Baru - Admin Panel</title>
</head>

<body class="bg-[#EAE0CF] flex items-center justify-center min-h-screen p-6">

    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl w-full max-w-md border border-[#7288AE]/20">

        <!-- Header -->
        <div class="flex items-center gap-3 mb-8">

            <a href="admin_index.php"
               class="text-[#7288AE] hover:text-[#111844] transition-colors">

                <span class="material-symbols-outlined">
                    arrow_back
                </span>

            </a>

            <h2 class="text-2xl font-bold text-[#111844]">
                Tambah Siswa Baru
            </h2>

        </div>

        <!-- Error -->
        <?php if(isset($error)): ?>

            <div class="bg-red-100 text-red-600 p-3 rounded-xl mb-4 text-xs text-center border border-red-200">
                <?= $error; ?>
            </div>

        <?php endif; ?>

        <!-- Form -->
        <form method="POST" class="space-y-5">

            <!-- Nama -->
            <div>

                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-1">
                    Nama Lengkap
                </label>

                <input type="text"
                       name="nama"
                       placeholder="Masukkan nama lengkap siswa"

                       class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3 text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all"

                       required>

            </div>

            <!-- NISN -->
            <div>

                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-1">
                    NISN
                </label>

                <input type="number"
                       name="nisn"
                       placeholder="Masukkan 12 digit NISN"

                       class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3 text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all"

                       required>

            </div>

            <!-- Username -->
            <div>

                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-1">
                    Username
                </label>

                <input type="text"
                       name="username"
                       placeholder="Buat username untuk login"

                       class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3 text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all"

                       required>

            </div>

            <!-- Password -->
            <div>

                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-1">
                    Password
                </label>

                <input type="password"
                       name="password"
                       placeholder="Buat password akun"

                       class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3 text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all"

                       required>

            </div>

            <!-- Saldo -->
            <div>

                <label class="block text-xs font-bold text-[#4B5694] uppercase ml-2 mb-1">
                    Saldo Awal Wallet (Rp)
                </label>

                <div class="relative">

                    <span class="absolute left-4 top-3 text-[#7288AE]">
                        Rp
                    </span>

                    <input type="number"
                           name="saldo"
                           value="0"
                           min="0"

                           class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3 pl-10 text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white font-bold transition-all"

                           required>

                </div>

                <p class="text-[10px] text-[#7288AE] mt-1 ml-2">
                    *Bisa diisi jika siswa langsung menyetor uang tunai saat pendaftaran.
                </p>

            </div>

            <!-- Tombol -->
            <div class="pt-4 flex flex-col gap-3">

                <button type="submit"
                        name="submit"

                        class="w-full bg-[#4B5694] text-white py-4 rounded-2xl font-bold shadow-lg hover:bg-[#111844] active:scale-95 transition-all">

                    Tambahkan Akun

                </button>

                <a href="admin_index.php"
                   class="text-center text-[#7288AE] text-sm font-medium hover:text-[#111844] transition">

                    Batalkan

                </a>

            </div>

        </form>

    </div>

</body>
</html>