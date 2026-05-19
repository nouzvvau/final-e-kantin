<?php
include "koneksi.php";
session_start();

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    // Query mencari user berdasarkan username (Sesuai tabel users)
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($koneksi, $query);

    if (mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        
        // Verifikasi password (disarankan pakai password_hash di produksi)
        if ($password === $row['password']) {
            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['role'] = $row['role'];

            // Redirect berdasarkan role
            if ($row['role'] === 'admin') {
                header("Location: admin_index.php");
            } else {
                header("Location: homepage.php");
            }
            exit;
        }
    }
    $error = true;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Login - CanteenJoy</title>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-[2rem] shadow-xl w-full max-w-sm border border-red-50">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-red-600">CanteenJoy</h1>
            <p class="text-gray-500 text-sm">Masuk untuk mulai memesan</p>
        </div>

        <?php if(isset($error)): ?>
            <p class="text-red-500 text-xs italic mb-4 text-center">Username atau Password salah!</p>
        <?php endif; ?>

        <form action="" method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" class="w-full border-gray-200 border rounded-2xl p-3 outline-none focus:ring-2 focus:ring-red-500" required>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" class="w-full border-gray-200 border rounded-2xl p-3 outline-none focus:ring-2 focus:ring-red-500" required>
            </div>
            <button type="submit" name="login" class="w-full bg-red-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-red-100 hover:bg-red-700 active:scale-95 transition-all mt-4">
                Masuk Sekarang
            </button>
        </form>
        <div class="text-center mt-6">
            <p class="text-gray-400 text-sm">Belum punya akun? 
                <a href="signup.php" class="text-red-600 font-bold hover:underline">Buat Sekarang!</a>
            </p>
        </div>
    </div>
</body>
</html>