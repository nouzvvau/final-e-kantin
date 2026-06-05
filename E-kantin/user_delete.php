<?php
include "koneksi.php";
$id = $_GET['id'];
mysqli_query($koneksi, "UPDATE users SET status_user='nonaktif' WHERE id = $id");
header("Location: admin_siswa.php");
?>