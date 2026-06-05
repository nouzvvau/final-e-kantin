<?php
session_start();
include "koneksi.php";

if (isset($_POST['register'])) {

    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $nisn = mysqli_real_escape_string($koneksi, $_POST['nisn']);
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    if (strpos($username, ' ') !== false) {

        $error_msg = "Username tidak boleh mengandung spasi!";

    } else {

        $check_user = mysqli_query($koneksi,
        "SELECT * FROM users 
         WHERE nisn='$nisn' 
         OR username='$username'");

        if (mysqli_num_rows($check_user) > 0) {

            $error_msg = "NISN atau Username sudah digunakan!";

        } else {

            $sql = "INSERT INTO users
            (nama, nisn, username, password, role, saldo)

            VALUES
            ('$nama', '$nisn', '$username', '$password', 'user', 0)";

            if (mysqli_query($koneksi, $sql)) {

                echo "<script>
                alert('Pendaftaran berhasil!');
                window.location='login.php';
                </script>";

            } else {

                die(mysqli_error($koneksi));
            }
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

<body class="bg-[#EAE0CF] flex items-center justify-center min-h-screen p-6">

    <div class="bg-white p-8 rounded-[2.5rem] shadow-xl w-full max-w-sm border border-[#7288AE]/20">

        <!-- Header -->
        <div class="text-center mb-8">

            <h1 class="text-3xl font-black text-[#111844]">
                CanteenJoy
            </h1>

            <p class="text-[#7288AE] text-sm mt-1">
                Buat akun untuk mulai jajan
            </p>

        </div>

        <!-- Error Message -->
        <?php if(isset($error_msg)): ?>

            <div class="bg-red-100 text-red-600 text-xs p-3 rounded-xl mb-4 text-center border border-red-200">

                <?= $error_msg; ?>

            </div>

        <?php endif; ?>

        <!-- Form -->
        <form action="" method="POST" class="space-y-4">

            <!-- Nama -->
            <div>

                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-1">
                    Nama Lengkap
                </label>

                <input type="text"
                       name="nama"

                       class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3 text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all"

                       placeholder="Masukkan nama"

                       required>

            </div>

            <!-- NISN -->
            <div>

                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-1">
                    NISN
                </label>

                <input type="number"
                       name="nisn"

                       class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3 text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all"

                       placeholder="12 digit angka"

                       required>

            </div>

            <!-- Username -->
            <div>

                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-1">
                    Username
                </label>

                <input type="text"
                       name="username"

                       class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3 text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all"

                       placeholder="Buat username"

                       required>

            </div>

            <!-- Password -->
            <div>

                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-1">
                    Password
                </label>

                <input type="password"
                       name="password"

                       class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3 text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all"
                       required>

            </div>

            <!-- Button -->
            <button type="submit"
                    name="register"

                    class="w-full bg-[#4B5694] text-white py-4 rounded-2xl font-bold shadow-lg hover:bg-[#111844] active:scale-95 transition-all mt-4">

                Daftar Akun

            </button>

        </form>

        <!-- Footer -->
        <div class="text-center mt-6">

            <p class="text-[#7288AE] text-sm">

                Sudah punya akun?

                <a href="login.php"
                   class="text-[#4B5694] font-bold hover:text-[#111844] hover:underline transition">

                    Masuk

                </a>

            </p>

        </div>

    </div>

</body>
</html>