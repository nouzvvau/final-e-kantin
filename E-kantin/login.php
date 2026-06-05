<?php
session_start();
include "koneksi.php";

if (isset($_POST['login'])) {

    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = $_POST['password'];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE username='$username' AND status_user='aktif'");

    if (mysqli_num_rows($query) == 1) {

        $row = mysqli_fetch_assoc($query);

        if ($password == $row['password']) {

            $_SESSION['login'] = true;
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['nama'] = $row['nama'];
            $_SESSION['role'] = $row['role'];

            if ($row['role'] == 'admin') {
                header("Location: admin_index.php");
                exit;
            } else {
                header("Location: homepage.php");
                exit;
            }

        } else {
            $error = "Password salah!";
        }

    } else {
        $error = "Username tidak ditemukan!";
    }
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

<body class="bg-[#EAE0CF] flex items-center justify-center min-h-screen px-4">

    <div class="bg-white p-6 sm:p-8 rounded-[2rem] shadow-xl w-full max-w-sm border border-[#7288AE]/20">

        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-[#111844]">
                CanteenJoy
            </h1>

            <p class="text-[#7288AE] text-sm mt-1">
                Masuk untuk mulai memesan
            </p>
        </div>

        <!-- Error -->
        <?php if(isset($error)): ?>
            <p class="text-red-500 text-xs italic mb-4 text-center">
                Username atau Password salah!
            </p>
        <?php endif; ?>

        <!-- Form -->
        <form action="" method="POST" class="space-y-4">

            <!-- Username -->
            <div>
                <label class="block text-sm font-medium text-[#111844] mb-1">
                    Username
                </label>

                <input 
                    type="text" 
                    name="username" 
                    class="w-full border border-[#7288AE]/30 rounded-2xl p-3 outline-none bg-[#EAE0C8]/20 text-[#111844] placeholder:text-[#7288AE] focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] transition"
                    required
                >
            </div>

            <!-- Password -->
            <div>
                <label class="block text-sm font-medium text-[#111844] mb-1">
                    Password
                </label>

                <input 
                    type="password" 
                    name="password" 
                    class="w-full border border-[#7288AE]/30 rounded-2xl p-3 outline-none bg-[#EAE0C8]/20 text-[#111844] placeholder:text-[#7288AE] focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] transition"
                    required
                >
            </div>

            <!-- Button -->
            <button 
                type="submit" 
                name="login" 
                class="w-full bg-[#4B5694] text-white py-4 rounded-2xl font-bold shadow-lg hover:bg-[#111844] active:scale-95 transition-all mt-4"
            >
                Masuk Sekarang
            </button>

        </form>

        <!-- Footer -->
        <div class="text-center mt-6">
            <p class="text-[#7288AE] text-sm">
                Belum punya akun? 

                <a 
                    href="signup.php" 
                    class="text-[#4B5694] font-bold hover:text-[#111844] hover:underline transition"
                >
                    Buat Sekarang!
                </a>
            </p>
        </div>

    </div>

</body>
</html>