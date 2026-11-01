-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 27 Okt 2026 pada 10.27
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
-- Database: `rentalps_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `kasir`
--

CREATE TABLE `kasir` (
  `id_kasir` int(11) NOT NULL,
  `nama_kasir` varchar(100) NOT NULL,
  `jenis_kelamin` varchar(20) NOT NULL,
  `nomor_hp_kasir` varchar(20) NOT NULL,
  `alamat` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kasir`
--

INSERT INTO `kasir` (`id_kasir`, `nama_kasir`, `jenis_kelamin`, `nomor_hp_kasir`, `alamat`) VALUES
(1, 'Agus', 'Laki-laki', '081243042', 'Salatiga'),
(2, 'Budi', 'Laki-laki', '0812430423', 'Kabupaten Semarang'),
(3, 'Cinta', 'Perempuan', '0812430424', 'Bawen');

-- --------------------------------------------------------

--
-- Struktur dari tabel `konsol`
--

CREATE TABLE `konsol` (
  `id_ps` int(11) NOT NULL,
  `nama_ps` varchar(100) NOT NULL,
  `tipe` varchar(20) NOT NULL,
  `harga_per_jam` int(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `konsol`
--

INSERT INTO `konsol` (`id_ps`, `nama_ps`, `tipe`, `harga_per_jam`) VALUES
(1, 'PlayStation 4 Fat', 'PS4', 8000),
(2, 'PlayStation 4 Fat', 'PS4', 8000),
(3, 'PlayStation 4 Slim', 'PS4', 8000),
(4, 'PlayStation 4 Slim', 'PS4', 8000),
(5, 'PlayStation 4 Slim', 'PS4', 8000),
(6, 'PlayStation 5 Standard', 'PS5', 12000),
(7, 'PlayStation 5 Standard', 'PS5', 12000),
(8, 'PlayStation 5 Standard', 'PS5', 12000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `nomor_hp_pelanggan` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `nama_pelanggan`, `nomor_hp_pelanggan`) VALUES
(1, 'ROBBEN', '083232323'),
(2, 'mazza', '1111091');

-- --------------------------------------------------------

--
-- Struktur dari tabel `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int(11) NOT NULL,
  `pelanggan_id` int(11) NOT NULL,
  `ps_id` int(11) NOT NULL,
  `kasir_id` int(11) NOT NULL,
  `tanggal` datetime NOT NULL,
  `durasi_jam` int(11) NOT NULL,
  `jam_mulai` time NOT NULL,
  `jam_selesai` time NOT NULL,
  `total_biaya` decimal(20,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `pelanggan_id`, `ps_id`, `kasir_id`, `tanggal`, `durasi_jam`, `jam_mulai`, `jam_selesai`, `total_biaya`) VALUES
(1, 1, 1, 1, '2026-10-26 11:47:00', 3, '22:00:00', '00:00:00', 24000.00),
(3, 3, 7, 1, '2026-10-27 16:24:00', 3, '16:24:00', '19:24:00', 36000.00);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `kasir`
--
ALTER TABLE `kasir`
  ADD PRIMARY KEY (`id_kasir`);

--
-- Indeks untuk tabel `konsol`
--
ALTER TABLE `konsol`
  ADD PRIMARY KEY (`id_ps`);

--
-- Indeks untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indeks untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `pelanggan_id` (`pelanggan_id`),
  ADD KEY `ps_id` (`ps_id`),
  ADD KEY `kasir_id` (`kasir_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `kasir`
--
ALTER TABLE `kasir`
  MODIFY `id_kasir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `konsol`
--
ALTER TABLE `konsol`
  MODIFY `id_ps` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT untuk tabel `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id_pelanggan`),
  ADD CONSTRAINT `transaksi_ibfk_2` FOREIGN KEY (`ps_id`) REFERENCES `konsol` (`id_ps`),
  ADD CONSTRAINT `transaksi_ibfk_3` FOREIGN KEY (`kasir_id`) REFERENCES `kasir` (`id_kasir`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
