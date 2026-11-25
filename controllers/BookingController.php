<?php
require_once 'models/RuanganPs.php';
require_once 'models/Transaksi.php';

function booking() {
    $daftar_ruangan = ambil_semua_ruangan();

    $id_ruangan_lama = '';
    if (isset($_GET['id_ruangan'])) {
        $id_ruangan_lama = (int) $_GET['id_ruangan'];
    }
    $nama_pelanggan_lama = $_SESSION['nama_lengkap'];
    $nomor_hp_lama       = '';
    $waktu_mulai_lama    = '';
    $durasi_jam_lama     = 1;

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $id_ruangan_lama     = (int) $_POST['id_ruangan'];
        $nama_pelanggan_lama = trim($_POST['nama_pelanggan']);
        $nomor_hp_lama       = trim($_POST['nomor_hp']);
        $waktu_mulai_lama    = $_POST['waktu_mulai'];
        $durasi_jam_lama     = (int) $_POST['durasi_jam'];

        $ruangan = cari_ruangan($id_ruangan_lama);
        $error   = cek_input_transaksi($ruangan, $nama_pelanggan_lama, $nomor_hp_lama,
                                       $waktu_mulai_lama, $durasi_jam_lama, 0, true);

        if ($error == '') {
            $waktu_mulai   = ubah_format_waktu($waktu_mulai_lama);
            $waktu_selesai = hitung_waktu_selesai($waktu_mulai, $durasi_jam_lama);
            $total_biaya   = $durasi_jam_lama * $ruangan['harga_per_jam'];

            simpan_transaksi($id_ruangan_lama, $_SESSION['id_pengguna'], $nama_pelanggan_lama,
                             $nomor_hp_lama, 'booking', $waktu_mulai, $waktu_selesai,
                             $durasi_jam_lama, $total_biaya);
            perbarui_status_ruangan($id_ruangan_lama);

            atur_pesan('sukses', 'Booking berhasil. Total biaya Rp ' . number_format($total_biaya, 0, ',', '.'));
            pindah('riwayat');
        } else {
            atur_pesan('gagal', $error);
        }
    }

    require 'views/layout/header.php';
    require 'views/user/booking.php';
    require 'views/layout/footer.php';
}

function riwayat() {
    $daftar_transaksi = ambil_transaksi_pengguna($_SESSION['id_pengguna']);

    require 'views/layout/header.php';
    require 'views/user/riwayat.php';
    require 'views/layout/footer.php';
}

// user hanya boleh membatalkan booking miliknya sendiri yang masih dipesan
function riwayat_batal() {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        pindah('riwayat');
    }

    $id_transaksi = (int) $_POST['id_transaksi'];
    $transaksi    = cari_transaksi($id_transaksi);

    if ($transaksi && $transaksi['id_pengguna'] == $_SESSION['id_pengguna'] && $transaksi['status'] == 'dipesan') {
        ubah_status_transaksi($id_transaksi, 'batal');
        perbarui_status_ruangan($transaksi['id_ruangan']);
        atur_pesan('sukses', 'Booking berhasil dibatalkan.');
    } else {
        atur_pesan('gagal', 'Booking ini tidak bisa dibatalkan.');
    }
    pindah('riwayat');
}