<?php
require_once 'models/RuanganPs.php';
require_once 'models/Transaksi.php';


if ($halaman == 'riwayat') {

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $aksi == 'batal') {
        $id_transaksi = $_POST['id_transaksi'];
        $transaksi    = ambilTransaksi($koneksi, $id_transaksi);

        if ($transaksi && $transaksi['id_pengguna'] == $_SESSION['id_pengguna'] && $transaksi['status'] == 'dipesan') {
            ubahStatusTransaksi($koneksi, $id_transaksi, 'batal');
            perbaruiStatusRuangan($koneksi, $transaksi['id_ruangan']);
            atur_pesan('sukses', 'Booking berhasil dibatalkan.');
        } else {
            atur_pesan('gagal', 'Booking ini tidak bisa dibatalkan.');
        }
        header('Location: index.php?halaman=riwayat');
        exit;
    }

    $daftar_transaksi = ambilTransaksiPengguna($koneksi, $_SESSION['id_pengguna']);

    require 'views/layout/header.php';
    require 'views/user/riwayat.php';
    require 'views/layout/footer.php';
    exit;
}

if ($halaman == 'booking') {
    $daftar_ruangan = ambilSemuaRuangan($koneksi);

    // Nilai awal form (id_ruangan bisa datang dari tombol Booking di card)
    $id_ruangan_lama     = '';
    if (isset($_GET['id_ruangan'])) {
        $id_ruangan_lama = $_GET['id_ruangan'];
    }
    $nama_pelanggan_lama = $_SESSION['nama_lengkap'];
    $nomor_hp_lama       = '';
    $waktu_mulai_lama    = '';
    $durasi_jam_lama     = 1;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_ruangan_lama     = $_POST['id_ruangan'];
        $nama_pelanggan_lama = trim($_POST['nama_pelanggan']);
        $nomor_hp_lama       = trim($_POST['nomor_hp']);
        $waktu_mulai_lama    = $_POST['waktu_mulai'];
        $durasi_jam_lama     = (int) $_POST['durasi_jam'];

        $ruangan       = ambilRuangan($koneksi, $id_ruangan_lama);
        $waktu_mulai   = ubahFormatWaktu($waktu_mulai_lama);
        $waktu_selesai = hitungWaktuSelesai($waktu_mulai, $durasi_jam_lama);

        if (!$ruangan) {
            atur_pesan('gagal', 'Silakan pilih ruangan.');
        } elseif ($nama_pelanggan_lama == '' || $nomor_hp_lama == '' || $waktu_mulai_lama == '') {
            atur_pesan('gagal', 'Semua kolom wajib diisi.');
        } elseif ($durasi_jam_lama < 1 || $durasi_jam_lama > 12) {
            atur_pesan('gagal', 'Durasi harus antara 1 sampai 12 jam.');
        } elseif (strtotime($waktu_mulai) < time() - 300) {
            atur_pesan('gagal', 'Waktu mulai tidak boleh sudah lewat.');
        } elseif (cekBentrok($koneksi, $id_ruangan_lama, $waktu_mulai, $waktu_selesai, 0)) {
            atur_pesan('gagal', 'Maaf, jam tersebut sudah dipakai. Silakan pilih jam lain.');
        } else {
            $total_biaya = $durasi_jam_lama * $ruangan['harga_per_jam'];

            simpanTransaksi($koneksi, $id_ruangan_lama, $_SESSION['id_pengguna'],
                            $nama_pelanggan_lama, $nomor_hp_lama, 'booking',
                            $waktu_mulai, $waktu_selesai, $durasi_jam_lama, $total_biaya);
            perbaruiStatusRuangan($koneksi, $id_ruangan_lama);

            atur_pesan('sukses', 'Booking berhasil. Total biaya Rp ' . number_format($total_biaya, 0, ',', '.'));
            header('Location: index.php?halaman=riwayat');
            exit;
        }
    }

    require 'views/layout/header.php';
    require 'views/user/booking.php';
    require 'views/layout/footer.php';
    exit;
}