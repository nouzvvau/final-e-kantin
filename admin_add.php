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
<!-- Form HTML -->
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <form method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-3xl shadow-lg w-full max-w-md">
        <h2 class="text-xl font-bold mb-6">Tambah Menu Baru</h2>
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Nama Produk</label>
                <input type="text" name="nama_produk" class="w-full border rounded-xl p-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Harga (Rp)</label>
                <input type="number" name="harga" class="w-full border rounded-xl p-2" required>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1 text-gray-600">Deskripsi Menu</label>
                <textarea name="deskripsi" rows="3" class="w-full border rounded-2xl p-3 focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Contoh: Pizza dengan topping pepperoni sapi melimpah..." required></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Kategori</label>
                <select name="category_id" class="w-full border rounded-xl p-2">
                    <option value="1">Main Course</option>
                    <option value="2">Drinks</option>
                    <option value="3">Snacks</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Foto Produk</label>
                <input type="file" name="gambar" class="w-full border rounded-2xl p-2" accept="image/*" required>
            </div>
            <button type="submit" name="submit" class="w-full bg-blue-600 text-white py-3 rounded-xl font-bold">Simpan Menu</button>
        </div>
    </form>
</body>