<?php
session_start();
include "koneksi.php";

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header("Location: login.php");
    exit;
}
include "koneksi.php";

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($id <= 0) {
    die("ID produk tidak valid!");
}

$query_data = mysqli_query($koneksi, "SELECT * FROM products WHERE id = $id");
$data = mysqli_fetch_assoc($query_data);

if (!$data) {
    die("Data produk tidak ditemukan!");
}

if (isset($_POST['update'])) {
    $nama   = $_POST['nama_produk'];
    $harga  = $_POST['harga'];
    $cat_id = $_POST['category_id'];
    $deskripsi = mysqli_real_escape_string($koneksi, $_POST['deskripsi']); // Update deskripsi

    $filename = $_FILES['gambar']['name'] ?? '';
    
    if ($filename != "") {
        $tmp_name = $_FILES['gambar']['tmp_name'];
        $filename = time() . '_' . $_FILES['gambar']['name'];
        $gambar_sql = ", gambar = '$filename'";
    } else {
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
        header("Location: admin_menu.php");
        exit;
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

<body class="bg-[#EAE0CF] flex items-center justify-center min-h-screen p-4">

    <div class="bg-white p-8 rounded-[2rem] shadow-xl w-full max-w-md border border-[#7288AE]/20">

        <!-- Header -->
        <div class="flex items-center gap-3 mb-6">

            <a href="admin_index.php"
               class="text-[#7288AE] hover:text-[#111844] transition">

                <span class="material-symbols-outlined">
                    arrow_back
                </span>

            </a>

            <h2 class="text-2xl font-bold text-[#111844]">
                Edit Menu
            </h2>

        </div>

        <!-- Form -->
        <form method="POST" enctype="multipart/form-data" class="space-y-5">

            <!-- Nama Produk -->
            <div>

                <label class="block text-sm font-semibold text-[#111844] mb-2">
                    Nama Produk
                </label>

                <input type="text"
                       name="nama_produk"
                       value="<?= $data['nama_produk']; ?>"

                       class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3 text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all"

                       required>

            </div>

            <!-- Deskripsi -->
            <div>

                <label class="block text-sm font-semibold text-[#111844] mb-2">
                    Deskripsi Menu
                </label>

                <textarea name="deskripsi"
                          rows="3"

                          class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3 text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all resize-none"

                          required><?= $data['deskripsi']; ?></textarea>

            </div>

            <!-- Harga -->
            <div>

                <label class="block text-sm font-semibold text-[#111844] mb-2">
                    Harga (Rp)
                </label>

                <input type="number"
                       name="harga"
                       value="<?= $data['harga']; ?>"

                       class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3 text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all"

                       required>

            </div>

            <!-- Kategori -->
            <div>

                <label class="block text-sm font-semibold text-[#111844] mb-2">
                    Kategori
                </label>

                <select name="category_id"

                        class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3 text-[#111844] outline-none focus:ring-2 focus:ring-[#4B5694] focus:border-[#4B5694] focus:bg-white transition-all">

                    <?php
                    $categories = mysqli_query($koneksi, "SELECT * FROM categories");

                    while($cat = mysqli_fetch_assoc($categories)) {

                        $selected = ($cat['id'] == $data['category_id']) ? "selected" : "";

                        echo "<option value='".$cat['id']."' $selected>".$cat['nama_kategori']."</option>";
                    }
                    ?>

                </select>

            </div>

            <!-- Gambar -->
            <div>

                <label class="block text-sm font-semibold text-[#111844] mb-2">
                    Foto Saat Ini
                </label>

                <img src="images/<?= $data['gambar']; ?>"
                     class="w-24 h-24 object-cover rounded-2xl border border-[#7288AE]/20 mb-3">

                <input type="file"
                       name="gambar"

                       class="w-full border border-[#7288AE]/20 bg-[#EAE0CF]/20 rounded-2xl p-3 text-sm text-[#111844] file:bg-[#4B5694] file:text-white file:border-0 file:px-4 file:py-2 file:rounded-xl file:mr-3 hover:file:bg-[#111844] transition-all"

                       accept="image/*">
            </div>

            <!-- Tombol -->
            <div class="pt-4 flex flex-col gap-3">

                <button type="submit"
                        name="update"

                        class="w-full bg-[#4B5694] text-white py-4 rounded-2xl font-bold shadow-lg hover:bg-[#111844] active:scale-95 transition-all">

                    Perbarui Menu

                </button>

                <a href="admin_index.php"
                   class="text-center text-[#7288AE] font-medium py-2 hover:text-[#111844] hover:underline transition">

                    Batalkan

                </a>

            </div>

        </form>

    </div>

</body>
</html>