<?php
session_start();

// Cek apakah sudah login DAN apakah rolenya admin
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

// 1. Ambil ID dari URL
$id = $_GET['id'];

// 2. Ambil data lama produk berdasarkan ID untuk ditampilkan di form
$query_data = mysqli_query($koneksi, "SELECT * FROM products WHERE id = $id");
$data = mysqli_fetch_assoc($query_data);

// 3. Logika ketika tombol "Update" ditekan
if (isset($_POST['update'])) {
    $nama   = $_POST['nama_produk'];
    $harga  = $_POST['harga'];
    $cat_id = $_POST['category_id'];
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']); // Update deskripsi

    $filename = $_FILES['gambar']['name'];
    
    if ($filename != "") {
        // Jika ada gambar baru yang diupload
        $tmp_name = $_FILES['gambar']['tmp_name'];
        move_uploaded_file($tmp_name, "images/" . $filename);
        $gambar_sql = ", gambar = '$filename'";
    } else {
        // Jika tidak upload gambar baru, biarkan gambar lama
        $gambar_sql = "";
    }

    $sql = "UPDATE products SET 
            nama_produk = '$nama', 
            harga = '$harga', 
            category_id = '$cat_id',
            deskripsi = '$deskripsi' 
            $gambar_sql 
            WHERE id = $id";
            
    if (mysqli_query($koneksi, $sql)) {
        // Jika berhasil, kembali ke halaman utama admin
        header("Location: admin_index.php");
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
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
    <title>Edit Menu - CanteenJoy Admin</title>
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-8 rounded-[2rem] shadow-xl w-full max-w-md border border-gray-100">
        <div class="flex items-center gap-3 mb-6">
            <a href="admin_index.php" class="text-gray-400 hover:text-gray-600">
                <span class="material-symbols-outlined">arrow_back</span>
            </a>
            <h2 class="text-2xl font-bold text-gray-800">Edit Menu</h2>
        </div>

        <form method="POST" class="space-y-5">
            <!-- Nama Produk -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Nama Produk</label>
                <input type="text" name="nama_produk" 
                       value="<?= $data['nama_produk']; ?>" 
                       class="w-full border-gray-200 border rounded-2xl p-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all" 
                       required>
            </div>

            <!-- Deskripsi -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Deskripsi Menu</label>
                <textarea name="deskripsi" rows="3" class="w-full border-gray-200 border rounded-2xl p-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all" required><?= $data['deskripsi']; ?></textarea>
            </div>

            <!-- Harga -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Harga (Rp)</label>
                <input type="number" name="harga" 
                       value="<?= $data['harga']; ?>" 
                       class="w-full border-gray-200 border rounded-2xl p-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all" 
                       required>
            </div>

            <!-- Kategori -->
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-2">Kategori</label>
                <select name="category_id" class="w-full border-gray-200 border rounded-2xl p-3 focus:ring-2 focus:ring-blue-500 outline-none transition-all">
                    <?php
                    // Mengambil semua kategori untuk pilihan dropdown
                    $categories = mysqli_query($koneksi, "SELECT * FROM categories");
                    while($cat = mysqli_fetch_assoc($categories)) {
                        // Jika id kategori sama dengan yang ada di produk, beri tanda 'selected'
                        $selected = ($cat['id'] == $data['category_id']) ? "selected" : "";
                        echo "<option value='".$cat['id']."' $selected>".$cat['nama_kategori']."</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Gambar -->
            <div>
                <label class="block text-sm font-semibold mb-2">Foto Saat Ini</label>
                <img src="images/<?= $data['gambar']; ?>" class="w-20 h-20 object-cover rounded-xl mb-2">
                <input type="file" name="gambar" class="w-full border rounded-2xl p-2" accept="image/*">
                <p class="text-[10px] text-gray-400 mt-1">*Kosongkan jika tidak ingin mengganti gambar</p>
            </div>

            <!-- Tombol Aksi -->
            <div class="pt-4 flex flex-col gap-3">
                <button type="submit" name="update" class="w-full bg-blue-600 text-white py-4 rounded-2xl font-bold shadow-lg shadow-blue-100 hover:bg-blue-700 active:scale-95 transition-all">
                    Perbarui Menu
                </button>
                <a href="admin_index.php" class="text-center text-gray-500 font-medium py-2 hover:underline">
                    Batalkan
                </a>
            </div>
        </form>
    </div>

</body>
</html>