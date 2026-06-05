<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {  
    header("Location: login.php");
    exit;
}

if (isset($_POST['submit'])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama_produk']);
    $harga = $_POST['harga'];
    $cat_id = $_POST['category_id'];
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']);

    $filename = $_FILES['gambar']['name'];
    $tmp_name = $_FILES['gambar']['tmp_name'];
    
    $unique_filename = time() . "_" . $filename;
    move_uploaded_file($tmp_name, "images/" . $unique_filename);

    $sql = "INSERT INTO products (nama_produk, harga, category_id, deskripsi, gambar) 
            VALUES ('$nama', '$harga', '$cat_id', '$deskripsi', '$unique_filename')";
            
    if (mysqli_query($koneksi, $sql)) {
        echo "<script>alert('Menu berhasil ditambahkan!'); window.location='admin_menu.php';</script>";
        exit;
    } else {
        $error = "Gagal menambahkan data: " . mysqli_error($koneksi);
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
    <title>Tambah Menu Baru - Admin Panel</title>
    <style>
        body {font-family: 'Plus Jakarta Sans', sans-serif;}
    </style>
</head>

<body class="bg-[#EAE0CF] flex items-center justify-center min-h-screen p-4 sm:p-6">

    <div class="bg-white p-6 sm:p-8 rounded-[2.5rem] shadow-xl w-full max-w-md border border-[#7288AE]/20 transition-all">

        <!-- Header -->
        <div class="flex items-center gap-3 mb-6">
            <a href="admin_index.php"
               class="text-[#7288AE] hover:text-[#111844] p-2 hover:bg-[#EAE0CF]/40 rounded-full transition-all">
                <span class="material-symbols-outlined flex items-center"> arrow_back </span>
            </a>

            <div>
                <h2 class="text-2xl font-bold text-[#111844]"> Tambah Menu </h2>
                <p class="text-xs text-[#7288AE]"> Masukkan item makanan atau minuman baru </p>
            </div>
        </div>

        <!-- Error -->
        <?php if(isset($error)): ?>
            <div class="bg-red-50 text-red-500 p-4 rounded-2xl mb-4 text-xs text-center border border-red-100 flex items-center gap-2 justify-center">
                <span class="material-symbols-outlined text-sm">error</span>
                <?= $error; ?>
            </div>
        <?php endif; ?>

        <!-- Form -->
        <form method="POST" enctype="multipart/form-data" class="space-y-5">
            <!-- Nama Produk -->
            <div>
                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-1.5"> Nama Produk </label>
                <input type="text" name="nama_produk" placeholder="Contoh: Salmon Mentai Rice"
                       class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3.5 text-sm text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all" required>
            </div>

            <!-- Harga -->
            <div>
                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-1.5"> Harga Produk </label>
                <div class="relative">
                    <span class="absolute left-4 top-3.5 text-sm font-semibold text-[#7288AE]"> Rp </span>
                    <input type="number" name="harga" placeholder="0" min="0"
                           class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3.5 pl-11 text-sm font-semibold text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all"
                           required>
                </div>
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-1.5"> Kategori </label>
                <select name="category_id" class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3.5 text-sm text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all" required>
                    <option value="" disabled selected> Pilih Kategori Menu </option>
                    <?php
                    $categories = mysqli_query($koneksi, "SELECT * FROM categories");
                    while($cat = mysqli_fetch_assoc($categories)) {
                        echo "<option value='".$cat['id']."'>".$cat['nama_kategori']."</option>";
                        }
                    ?>
                </select>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-1.5">Deskripsi Menu</label>
                <textarea name="deskripsi"
                          rows="3"
                          placeholder="Jelaskan detail menu (bahan, rasa, porsi)..."
                          class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3.5 text-sm text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all resize-none"
                          required></textarea>
            </div>

            <!-- Upload -->
            <div>
                <label class="block text-xs font-bold text-[#7288AE] uppercase ml-2 mb-1.5">Foto Menu</label>
                <div class="border-2 border-dashed border-[#7288AE]/30 bg-[#EAE0CF]/20 rounded-2xl p-4 text-center relative hover:bg-[#EAE0CF]/40 transition-colors">
                    <input type="file" name="gambar" id="gambar-input"
                           class="absolute inset-0 w-full h-full opacity-0 cursor-pointer"
                           accept="image/*"
                           required>

                    <div id="upload-placeholder" class="space-y-1">

                        <span class="material-symbols-outlined text-[#7288AE] text-3xl">
                            cloud_upload
                        </span>

                        <p class="text-xs font-medium text-[#111844]">
                            Pilih atau Seret Foto ke Sini
                        </p>

                        <p class="text-[10px] text-[#7288AE]">
                            Format: JPG, PNG (Maks. 2MB)
                        </p>

                    </div>

                    <p id="file-name"
                       class="text-xs text-[#4B5694] font-bold hidden truncate mt-1"></p>

                </div>

            </div>

            <!-- Button -->
            <div class="pt-2 flex flex-col gap-3">

                <button type="submit"
                        name="submit"

                        class="w-full bg-[#4B5694] text-white py-4 rounded-2xl font-bold shadow-lg hover:bg-[#111844] active:scale-95 transition-all">

                    Simpan Menu Baru

                </button>

                <a href="admin_index.php"
                   class="text-center text-[#7288AE] text-xs font-bold uppercase tracking-wider hover:text-[#111844] transition-colors py-1">

                    Batalkan

                </a>

            </div>

        </form>

    </div>

    <script>
        const fileInput = document.getElementById('gambar-input');
        const fileNameDisplay = document.getElementById('file-name');
        const uploadPlaceholder = document.getElementById('upload-placeholder');

        fileInput.addEventListener('change', function() {

            if (this.files && this.files.length > 0) {
                fileNameDisplay.textContent = "✓ " + this.files[0].name;
                fileNameDisplay.classList.remove('hidden');
                uploadPlaceholder.classList.add('opacity-40');
            } else {
                fileNameDisplay.classList.add('hidden');
                uploadPlaceholder.classList.remove('opacity-40');
            }

        });
    </script>

</body>
</html>