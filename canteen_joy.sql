-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 29 Bulan Mei 2026 pada 12.17
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `canteen_joy`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `categories`
--

INSERT INTO `categories` (`id`, `nama_kategori`) VALUES
(1, 'Main Course'),
(2, 'Drinks'),
(3, 'Snacks');

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `total_bayar` decimal(12,2) NOT NULL,
  `metode_pembayaran` varchar(50) DEFAULT NULL,
  `status_pesanan` varchar(20) DEFAULT 'pending',
  `tanggal_pesan` timestamp NULL DEFAULT current_timestamp(),
  `status_data` enum('aktif','dihapus') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `total_bayar`, `metode_pembayaran`, `status_pesanan`, `tanggal_pesan`, `status_data`) VALUES
(3, 2, 25000.00, 'Campus Wallet', 'selesai', '2026-05-04 07:12:24', 'aktif'),
(4, 2, 25000.00, 'Campus Wallet', 'selesai', '2026-05-04 07:20:58', 'aktif'),
(5, 2, 25000.00, 'Campus Wallet', 'selesai', '2026-05-04 07:21:55', 'aktif'),
(6, 2, 10000.00, 'Campus Wallet', 'selesai', '2026-05-10 02:00:45', 'aktif'),
(7, 2, 10000.00, 'Campus Wallet', 'selesai', '2026-05-10 02:02:11', 'aktif'),
(8, 2, 35000.00, 'Campus Wallet', 'selesai', '2026-05-26 04:37:51', 'aktif'),
(9, 2, 25000.00, 'Campus Wallet', 'selesai', '2026-05-26 04:38:24', 'aktif'),
(10, 2, 20000.00, 'Campus Wallet', 'selesai', '2026-05-28 09:59:29', 'aktif'),
(11, 2, 20000.00, 'Campus Wallet', 'selesai', '2026-05-28 10:02:51', 'aktif'),
(12, 6, 20000.00, 'Campus Wallet', 'selesai', '2026-05-28 10:17:47', 'aktif'),
(13, 2, 15000.00, 'Campus Wallet', 'selesai', '2026-05-29 02:45:07', 'aktif'),
(14, 2, 6000.00, 'Campus Wallet', 'selesai', '2026-05-29 03:04:46', 'aktif'),
(15, 2, 7500.00, 'Campus Wallet', 'selesai', '2026-05-29 03:51:14', 'aktif'),
(16, 2, 12000.00, 'Campus Wallet', 'selesai', '2026-05-29 06:45:02', 'aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT 1,
  `subtotal` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `quantity`, `subtotal`) VALUES
(1, 15, 14, 1, 5000.00),
(2, 15, 15, 1, 2500.00),
(3, 16, 21, 1, 7000.00),
(4, 16, 24, 1, 5000.00);

-- --------------------------------------------------------

--
-- Struktur dari tabel `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `category_id` int(11) DEFAULT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(12,2) NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `status_produk` enum('tersedia','dihapus') DEFAULT 'tersedia'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `products`
--

INSERT INTO `products` (`id`, `category_id`, `nama_produk`, `deskripsi`, `harga`, `gambar`, `status_produk`) VALUES
(4, 1, 'Sambal Cabe', 'Semur Cabai Hijau, cocok untuk sambal', 10000.00, 'cabe.jpg', 'dihapus'),
(6, 1, 'Classic Pepperoni Pizza', 'Fresh dough, signature tomato sauce, and mozzarella.', 25000.00, 'pizza.jpg', 'dihapus'),
(7, 1, 'Pecel Lele', 'Pecel Lele', 15000.00, '1778917638_kangkung.png', 'dihapus'),
(8, 1, 'Nasi Kuning', 'Nasi Kuning Cap Mojokerto. Murah Harga nya, lengkap lauk nya, enak  rasanya.', 10000.00, '1779765348_kangkung.png', 'dihapus'),
(9, 3, 'Dimas Mentai', 'enak', 22000.00, '1779963084_airputih.jpg', 'dihapus'),
(10, 2, 'Es Jeruk', 'Es jeruk segar dengan jeruk asli', 3000.00, '1780013991_esjeruk.jpeg', 'tersedia'),
(11, 2, 'Es Teh', 'Es teh segar', 2000.00, '1780014034_esteh.jpeg', 'tersedia'),
(12, 2, 'Es Kopi', 'Es kopi enak segar', 3000.00, '1780014080_eskopi.jpeg', 'tersedia'),
(13, 1, 'Nasi Pecel', 'Nasi pecel enak', 7000.00, '1780014126_nasipecel.jpeg', 'tersedia'),
(14, 3, 'Dimsum Mentai', 'Dimsum dengan saus mentai', 5000.00, '1780014166_dimsummentai.jpeg', 'tersedia'),
(15, 3, 'Dimsum Goreng', 'Dimsum goreng isi keju', 2500.00, '1780014333_dimsumgoreng.jpeg', 'tersedia'),
(16, 1, 'Mi Goreng', 'Mi instan goreng', 5000.00, '1780014390_migoreng.jpeg', 'tersedia'),
(17, 1, 'Soto', 'Soto ayam enak', 8000.00, '1780014476_soto.jpeg', 'tersedia'),
(18, 2, 'Es Jomblo', 'Es rasa anggur', 5000.00, '1780014659_esungu.jpeg', 'tersedia'),
(19, 2, 'Es Gamon', 'Perpaduan es rasa matcha dan stroberi', 5000.00, '1780014732_esitali.jpeg', 'tersedia'),
(20, 2, 'Es TTM', 'Es rasa stroberi', 5000.00, '1780014775_esttm.jpeg', 'tersedia'),
(21, 1, 'Ayam Geprek', 'Ayam geprek enak', 7000.00, '1780014821_ayamgeprek.jpeg', 'tersedia'),
(22, 1, 'Mi Kuah', 'Mi kuah instan', 5000.00, '1780014860_mikuah.jpeg', 'tersedia'),
(23, 3, 'Tahu Walik', 'Tahu goreng walik', 3000.00, '1780014911_tahuwalik.jpeg', 'tersedia'),
(24, 2, 'Es Matcha', 'Es matcha segar', 5000.00, '1780014967_esmatcha.jpeg', 'tersedia'),
(25, 3, 'Gabin', 'Gabin enak', 2000.00, '1780015003_gabin.jpeg', 'tersedia'),
(26, 3, 'Donat', 'Donat dengan topping meses', 2500.00, '1780015054_donatmeses.jpeg', 'tersedia'),
(27, 3, 'Churros', 'Churros dengan saus coklat dan gula halus', 5000.00, '1780015098_churos.jpeg', 'tersedia'),
(28, 3, 'Pempek', 'Pempek enak', 2000.00, '1780015143_pempek.jpeg', 'tersedia'),
(29, 3, 'Basreng', 'Basreng pedas daun jeruk', 2000.00, '1780015185_basreng.jpeg', 'tersedia'),
(30, 2, 'Air Mineral', 'Air putih segar', 3000.00, '1780015263_airputih.jpg', 'tersedia'),
(31, 3, 'Jamur Krispi', 'Jamur goreng krispi', 3000.00, '1780015332_jamurkrispi.avif', 'tersedia'),
(32, 2, 'Pop Ice', 'Pop ice dengan berbagai varian rasa', 3000.00, '1780015368_popice.jpeg', 'tersedia'),
(33, 2, 'Drink Beng-Beng', 'Drink beng-beng segar', 3000.00, '1780015400_drinkbengbeng.jpeg', 'tersedia'),
(34, 2, 'Es Nutrisari', 'Es nutrisari dengan berbagai varian rasa', 3000.00, '1780015442_nutrisari.jpeg', 'tersedia'),
(35, 1, 'Nasi Ayam', 'Nasi ayam goreng ', 7000.00, '1780015517_nasiayam.jpeg', 'tersedia'),
(36, 1, 'Bakso', 'Bakso enak', 6000.00, '1780015559_bakso.jpeg', 'tersedia'),
(39, 1, 'Sean', 'CORTIS', 100000.00, '1780047112_𓏲ּ𝄢.jpg', 'dihapus');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nisn` varchar(20) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','user') DEFAULT 'user',
  `saldo` decimal(12,2) DEFAULT 0.00,
  `created_at` timestamp NULL DEFAULT current_timestamp(),
  `status_user` enum('aktif','nonaktif') DEFAULT 'aktif'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `nisn`, `username`, `password`, `role`, `saldo`, `created_at`, `status_user`) VALUES
(1, 'Admin', '123151613412', 'admin', 'admin123', 'admin', 154000.00, '2026-05-04 05:34:39', 'aktif'),
(2, 'Siti Maemunah', '123133561', 'siti', 'siti123', 'user', 238000.00, '2026-05-04 05:59:10', 'aktif'),
(6, 'Jamal Samsul', '12345678908', 'jamal', 'jamal123', 'user', 250000.00, '2026-05-28 10:06:56', 'aktif');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indeks untuk tabel `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nisn` (`nisn`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE SET NULL;

--
-- Ketidakleluasaan untuk tabel `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `products_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
