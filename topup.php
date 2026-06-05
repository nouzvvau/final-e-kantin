<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'user') {
    header("Location: login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['proses_topup'])) {
    $nominal_topup = intval($_POST['nominal']);

    if ($nominal_topup < 5000) {
        $error = "Minimal pengisian saldo adalah Rp 5.000";
    } else {
        $query_user = mysqli_query($koneksi, "SELECT saldo FROM users WHERE id = $user_id");
        $user_data = mysqli_fetch_assoc($query_user);
        $saldo_lama = $user_data['saldo'];

        $saldo_baru = $saldo_lama + $nominal_topup;

        $update_saldo = mysqli_query($koneksi, "UPDATE users SET saldo = $saldo_baru WHERE id = $user_id");

        if ($update_saldo) {
            echo "<script>
                    alert('Top Up Berhasil! Saldo kamu telah bertambah sebesar Rp " . number_format($nominal_topup, 0, ',', '.') . "');
                    window.location='homepage.php';
                  </script>";
            exit;
        } else {
            $error = "Terjadi kesalahan sistem, silakan coba lagi.";
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

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>

    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />

    <title>Top Up Saldo - CanteenJoy</title>

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-[#EAE0CF] flex items-center justify-center min-h-screen p-5">

    <div class="bg-white p-6 sm:p-8 rounded-[2.5rem] shadow-xl w-full max-w-md border border-[#7288AE]/20">
        
        <!-- Header -->
        <div class="flex items-center gap-3 mb-6">

            <a href="homepage.php"
               class="text-[#7288AE] hover:text-[#111844] p-2 hover:bg-[#EAE0CF] rounded-full transition-all">

                <span class="material-symbols-outlined flex items-center">
                    arrow_back
                </span>

            </a>

            <div>

                <h2 class="text-xl font-bold text-[#111844]">
                    Isi Saldo Wallet
                </h2>

                <p class="text-xs text-[#7288AE]">
                    Tambah amunisi dana jajarmu
                </p>

            </div>

        </div>

        <!-- Error -->
        <?php if(isset($error)): ?>

            <div class="bg-red-100 text-red-600 p-3.5 rounded-2xl mb-4 text-xs text-center border border-red-200">

                <?= $error; ?>

            </div>

        <?php endif; ?>

        <!-- Form -->
        <form method="POST" class="space-y-6">
            
            <!-- Input Nominal -->
            <div>

                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-2">
                    Masukkan Nominal
                </label>

                <div class="relative">

                    <span class="absolute left-5 top-4 font-black text-[#7288AE] text-base">
                        Rp
                    </span>

                    <input type="number"
                           name="nominal"
                           id="input-nominal"
                           placeholder="0"
                           min="5000"

                           class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-4 pl-12 text-base font-black text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all"

                           required>

                </div>

                <p class="text-[10px] text-[#7288AE] mt-1.5 ml-2">
                    *Minimal pengisian Rp 5.000
                </p>

            </div>

            <!-- Shortcut -->
            <div>

                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-2">
                    Pilihan Instan
                </label>

                <div class="grid grid-cols-3 gap-3">

                    <button type="button"
                            onclick="setNominal(10000)"

                            class="bg-[#EAE0CF]/40 hover:bg-[#4B5694] hover:text-white border border-[#7288AE]/20 rounded-xl py-3 text-xs font-bold text-[#4B5694] transition-all">

                        +10.000

                    </button>

                    <button type="button"
                            onclick="setNominal(20000)"

                            class="bg-[#EAE0CF]/40 hover:bg-[#4B5694] hover:text-white border border-[#7288AE]/20 rounded-xl py-3 text-xs font-bold text-[#4B5694] transition-all">

                        +20.000

                    </button>

                    <button type="button"
                            onclick="setNominal(50000)"

                            class="bg-[#EAE0CF]/40 hover:bg-[#4B5694] hover:text-white border border-[#7288AE]/20 rounded-xl py-3 text-xs font-bold text-[#4B5694] transition-all">

                        +50.000

                    </button>

                </div>

            </div>

            <!-- Button -->
            <div class="pt-2">

                <button type="submit"
                        name="proses_topup"

                        class="w-full bg-[#4B5694] text-white py-4 rounded-2xl font-bold shadow-lg hover:bg-[#111844] active:scale-95 transition-all text-sm">

                    Konfirmasi Isi Saldo

                </button>

            </div>

        </form>

    </div>

    <script>

        function setNominal(nilai) {

            const inputField = document.getElementById('input-nominal');

            let nilaiSekarang = parseInt(inputField.value) || 0;

            inputField.value = nilaiSekarang + nilai;

        }

    </script>

</body>
</html>