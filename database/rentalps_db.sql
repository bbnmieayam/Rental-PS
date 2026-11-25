-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Waktu pembuatan: 25 Nov 2026 pada 03.19
-- Versi server: 8.4.7
-- Versi PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Basis data: `rentalps_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengguna`
--

DROP TABLE IF EXISTS `pengguna`;
CREATE TABLE IF NOT EXISTS `pengguna` (
  `id_pengguna` int NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nama_pengguna` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kata_sandi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `peran` enum('admin','user') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user',
  PRIMARY KEY (`id_pengguna`),
  UNIQUE KEY `nama_pengguna` (`nama_pengguna`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `pengguna`
--

INSERT INTO `pengguna` (`id_pengguna`, `nama_lengkap`, `nama_pengguna`, `kata_sandi`, `peran`) VALUES
(1, 'Andi Subianto', 'Kasir Andi', '$2y$10$uuRX0sdiRk9EiYeqNmU3W.QFJDZD6dX.yT.lrc7VRjkB02kg77VMG', 'admin'),
(2, 'Siregar Budiono', 'Kasir Siregar', '$2y$10$wF/zoo8VbRy0ih/jR.jhPOu0M5ySrL9rpvYOP621ugE0POiQgzHlq', 'admin'),
(3, 'Yanto Bengkel', 'Kasir Yanto', '$2y$10$4nitoU2.piyTzN0z4qGnIOk9AZmOwv7AzFJ9BGlAzfiIj3FM5N1Su', 'admin');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ruangan_ps`
--

DROP TABLE IF EXISTS `ruangan_ps`;
CREATE TABLE IF NOT EXISTS `ruangan_ps` (
  `id_ruangan` int NOT NULL AUTO_INCREMENT,
  `nama_ruangan` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_konsol` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `harga_per_jam` int NOT NULL,
  `status` enum('tersedia','tidak tersedia') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'tersedia',
  PRIMARY KEY (`id_ruangan`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `ruangan_ps`
--

INSERT INTO `ruangan_ps` (`id_ruangan`, `nama_ruangan`, `jenis_konsol`, `harga_per_jam`, `status`) VALUES
(1, 'Ruangan Reguler 1', 'PS4', 8000, 'tersedia'),
(2, 'Ruangan Reguler 2', 'PS4', 8000, 'tersedia'),
(3, 'Ruangan Reguler 3', 'PS4', 8000, 'tersedia'),
(4, 'Ruangan Reguler 4', 'PS4', 8000, 'tersedia'),
(5, 'Ruangan Reguler 5', 'PS4', 8000, 'tersedia'),
(6, 'Ruangan VIP 1', 'PS5', 15000, 'tersedia'),
(7, 'Ruangan VIP 2', 'PS5', 15000, 'tersedia');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

DROP TABLE IF EXISTS `transaksi`;
CREATE TABLE IF NOT EXISTS `transaksi` (
  `id_transaksi` int NOT NULL AUTO_INCREMENT,
  `id_ruangan` int NOT NULL,
  `id_pengguna` int NOT NULL,
  `nama_pelanggan` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nomor_hp` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `sumber` enum('booking','kasir') COLLATE utf8mb4_unicode_ci NOT NULL,
  `waktu_mulai` datetime NOT NULL,
  `waktu_selesai` datetime NOT NULL,
  `durasi_jam` int NOT NULL,
  `total_biaya` int NOT NULL,
  `status` enum('dipesan','lunas','batal') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dipesan',
  PRIMARY KEY (`id_transaksi`),
  KEY `id_ruangan` (`id_ruangan`),
  KEY `id_pengguna` (`id_pengguna`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
