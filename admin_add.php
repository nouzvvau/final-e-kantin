<?php
session_start();

// Cek apakah sudah login DAN apakah rolenya admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include "koneksi.php";
if (isset($_POST['submit'])) {
    $nama = $_POST['nama_produk'];
    $harga = $_POST['harga'];
    $cat_id = $_POST['category_id'];
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']); // Ambil deskripsi
    
    // Logika Upload Gambar
    $filename = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    
    // Pindahkan file ke folder images
    move_uploaded_file($tmp_name, "images/" . $filename);
    
    $sql = "INSERT INTO products (nama_produk, harga, category_id, deskripsi, gambar) 
            VALUES ('$nama', '$harga', '$cat_id', '$deskripsi', '$filename')";
    
    if (mysqli_query($koneksi, $sql)) {
        header("Location: admin_index.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Tambah Menu - CanteenJoy</title>
    <style>
        *{font-family: 'Poppins', sans-serif;}

        ::-webkit-scrollbar{width: 6px;}

        ::-webkit-scrollbar-thumb{background: #d1d5db; border-radius: 999px;}
    </style>
</head>

<body class="bg-white min-h-screen flex items-center justify-center p-4 md:p-6 overflow-x-hidden">
    <!--Background-->
    <div class="fixed top-0 left-0 w-72 h-72 bg-[#fa8e3c]/20 rounded-full blur-3xl"></div>
    <div class="fixed bottom-0 right-0 w-72 h-72 bg-[#ee3535]/20 rounded-full blur-3xl"></div>

    <form 
        method="POST" 
        enctype="multipart/form-data"
        class="relative bg-white w-full max-w-md md:max-w-lg 
        p-6 md:p-8 rounded-[2.5rem] 
        shadow-[0_10px_40px_rgba(0,0,0,0.08)] 
        border border-orange-100">
        <!-- Header -->
        <div class="text-center mb-8">
            <!-- Logo Circle -->
            <div class="w-20 h-20 mx-auto rounded-[2rem] 
            bg-[#fa8e3c]
            flex items-center justify-center shadow-lg shadow-orange-100 mb-5">
                <span class="text-white text-4xl">
                    🍴
                </span>
            </div>

            <!-- Title -->
            <h1 class="text-3xl md:text-4xl font-black text-[#ee3535]">
                Tambah Menu
            </h1>

        </div>

        <!-- Form -->
        <div class="space-y-5">

            <!-- Nama Produk -->
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Nama Produk
                </label>

                <input 
                    type="text" 
                    name="nama_produk"
                    placeholder="Contoh: Nasi Goreng"
                    class="w-full bg-gray-50 border border-gray-200 
                    rounded-2xl p-4 text-sm md:text-base
                    outline-none
                    focus:ring-2 focus:ring-[#ee3535]
                    focus:border-[#ee3535]
                    focus:bg-white
                    transition-all duration-300"
                    required>
            </div>

            <!-- Harga -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Harga (Rp)
                </label>

                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 font-semibold">
                        Rp
                    </span>
                    <input 
                        type="number" 
                        name="harga"
                        placeholder="15000"
                        class="w-full bg-gray-50 border border-gray-200 
                        rounded-2xl pl-14 pr-4 py-4 text-sm md:text-base
                        outline-none
                        focus:ring-2 focus:ring-[#ee3535]
                        focus:border-[#ee3535]
                        focus:bg-white
                        transition-all duration-300"
                        required>
                </div>

            </div>

            <!-- Deskripsi -->
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Deskripsi Menu
                </label>

                <textarea 
                    name="deskripsi"
                    rows="4"
                    placeholder="Contoh: Pizza dengan topping pepperoni"
                    class="w-full bg-gray-50 border border-gray-200 
                    rounded-2xl p-4 text-sm md:text-base
                    resize-none outline-none
                    focus:ring-2 focus:ring-[#ee3535]
                    focus:border-[#ee3535]
                    focus:bg-white
                    transition-all duration-300"
                    required></textarea>
            </div>

            <!-- Kategori -->
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Kategori
                </label>

                <select 
                    name="category_id"
                    class="w-full bg-gray-50 border border-gray-200 
                    rounded-2xl p-4 text-sm md:text-base
                    outline-none
                    focus:ring-2 focus:ring-[#ee3535]
                    focus:border-[#ee3535]
                    focus:bg-white
                    transition-all duration-300"
                    required>

                    <option value="">Pilih Kategori</option>
                    <option value="1">Main Course</option>
                    <option value="2">Drinks</option>
                    <option value="3">Snacks</option>
                </select>
            </div>

            <!--Upload-->
            <div>

                <label class="block text-sm font-semibold text-gray-700 mb-2">
                    Foto Produk
                </label>

                <div class="border-2 border-dashed border-orange-200 
                bg-orange-50/50 rounded-[2rem] p-5
                hover:border-[#fa8e3c] transition-all duration-300">

                    <div class="text-center">
                        <div class="w-16 h-16 mx-auto rounded-2xl 
                        bg-[#fa8e3c]
                        flex items-center justify-center mb-4 shadow-md">
                            <span class="text-white text-3xl">
                                📸
                            </span>
                        </div>

                        <p class="font-bold text-gray-700">
                            Upload Foto Produk
                        </p>

                        <br>

                        <input 
                            type="file" 
                            name="gambar"
                            accept="image/*"
                            class="w-full text-sm text-gray-600
                            file:mr-4 file:py-3 file:px-5
                            file:rounded-2xl file:border-0
                            file:bg-[#fbb13c]
                            file:text-white
                            file:font-bold
                            hover:file:bg-[#d92d2d]
                            transition-all duration-300"
                            required>
                    </div>
                </div>
            </div>

            <!-- Button -->
            <button 
                type="submit" 
                name="submit"
                class="w-full bg-[#ee3535]
                text-white py-4 rounded-2xl font-bold text-sm md:text-base
                shadow-lg shadow-orange-100
                hover:scale-[1.02]
                active:scale-[0.98]
                transition-all duration-300 mt-2">
                Simpan Menu
            </button>
        </div>
    </form>
</body>
</html>