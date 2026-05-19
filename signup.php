<?php
include "koneksi.php";

if (isset($_POST['register'])) {
    // Mengambil data dari form dan mengamankannya dari SQL Injection
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nisn = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password']; // Disarankan menggunakan password_hash() untuk keamanan lebih

    // Cek apakah NISN atau Username sudah terdaftar sebelumnya
    $check_user = mysqli_query($koneksi, "SELECT * FROM users WHERE nisn = '$nisn' OR username = '$username'");
    
    if (mysqli_num_rows($check_user) > 0) {
        $error_msg = "NISN atau Username sudah digunakan!";
    } else {
        // Query untuk memasukkan user baru (Role otomatis sebagai 'user' dan saldo awal 0)
        $sql = "INSERT INTO users (nama, nisn, username, password, role, saldo) 
                VALUES ('$nama', '$nisn', '$username', '$password', 'user', 0)";
        
        if (mysqli_query($koneksi, $sql)) {
            echo "<script>alert('Pendaftaran Berhasil! Silakan Login.'); window.location='login.php';</script>";
        } else {
            $error_msg = "Gagal mendaftar: " . mysqli_error($koneksi);
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
    <title>Sign Up - CanteenJoy</title>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-6">

    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl w-full max-w-sm border border-gray-100">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-red-600">CanteenJoy</h1>
            <p class="text-gray-400 text-sm mt-1">Buat akun untuk mulai jajan</p>
        </div>

        <?php if(isset($error_msg)): ?>
            <div class="bg-red-50 text-red-500 text-xs p-3 rounded-xl mb-4 text-center">
                <?= $error_msg; ?>
            </div>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <!-- Input Nama -->
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase ml-2 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full border-gray-100 border bg-gray-50 rounded-2xl p-3 outline-none focus:ring-2 focus:ring-red-500 transition-all" placeholder="Masukkan nama" required>
            </div>

            <!-- Input NISN -->
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase ml-2 mb-1">NISN</label>
                <input type="number" name="nisn" class="w-full border-gray-100 border bg-gray-50 rounded-2xl p-3 outline-none focus:ring-2 focus:ring-red-500 transition-all" placeholder="12 digit angka" required>
            </div>

            <!-- Input Username -->
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase ml-2 mb-1">Username</label>
                <input type="text" name="username" class="w-full border-gray-100 border bg-gray-50 rounded-2xl p-3 outline-none focus:ring-2 focus:ring-red-500 transition-all" placeholder="Buat username" required>
            </div>

            <!-- Input Password -->
            <div>
                <label class="block text-xs font-bold text-gray-400 uppercase ml-2 mb-1">Password</label>
                <input type="password" name="password" class="w-full border-gray-100 border bg-gray-50 rounded-2xl p-3 outline-none focus:ring-2 focus:ring-red-500 transition-all" placeholder="Minimal 6 karakter" required>
            </div>

            <button type="submit" name="register" class="w-full bg-red-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-red-100 hover:bg-red-700 active:scale-95 transition-all mt-4">
                Daftar Akun
            </button>
        </form>

        <div class="text-center mt-6">
            <p class="text-gray-400 text-sm">Sudah punya akun? 
                <a href="login.php" class="text-red-600 font-bold hover:underline">Masuk</a>
            </p>
        </div>
    </div>

</body>
</html>