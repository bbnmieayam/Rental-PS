<?php
require_once 'models/RuanganPs.php';
require_once 'models/Transaksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && ($aksi == 'bayar' || $aksi == 'batal' || $aksi == 'hapus')) {
    $id_transaksi = $_POST['id_transaksi'];
    $transaksi    = ambilTransaksi($koneksi, $id_transaksi);

    if (!$transaksi) {
        atur_pesan('gagal', 'Transaksi tidak ditemukan.');
    } elseif ($aksi == 'hapus') {
        hapusTransaksi($koneksi, $id_transaksi);
        perbaruiStatusRuangan($koneksi, $transaksi['id_ruangan']);
        atur_pesan('sukses', 'Transaksi berhasil dihapus.');
    } elseif ($transaksi['status'] != 'dipesan') {
        atur_pesan('gagal', 'Hanya transaksi berstatus dipesan yang bisa diproses.');
    } elseif ($aksi == 'bayar') {
        ubahStatusTransaksi($koneksi, $id_transaksi, 'lunas');
        perbaruiStatusRuangan($koneksi, $transaksi['id_ruangan']);
        atur_pesan('sukses', 'Transaksi ditandai lunas.');
    } else {
        ubahStatusTransaksi($koneksi, $id_transaksi, 'batal');
        perbaruiStatusRuangan($koneksi, $transaksi['id_ruangan']);
        atur_pesan('sukses', 'Transaksi dibatalkan.');
    }

    header('Location: index.php?halaman=transaksi');
    exit;
}

if ($aksi == 'tambah') {
    $daftar_ruangan = ambilSemuaRuangan($koneksi);

    $id_ruangan_lama     = '';
    $nama_pelanggan_lama = '';
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
        } elseif (cekBentrok($koneksi, $id_ruangan_lama, $waktu_mulai, $waktu_selesai, 0)) {
            atur_pesan('gagal', 'Jam bentrok dengan transaksi lain di ruangan ini.');
        } else {
            $total_biaya = $durasi_jam_lama * $ruangan['harga_per_jam'];

            simpanTransaksi($koneksi, $id_ruangan_lama, $_SESSION['id_pengguna'],
                            $nama_pelanggan_lama, $nomor_hp_lama, 'kasir',
                            $waktu_mulai, $waktu_selesai, $durasi_jam_lama, $total_biaya);
            perbaruiStatusRuangan($koneksi, $id_ruangan_lama);

            atur_pesan('sukses', 'Transaksi berhasil ditambahkan.');
            header('Location: index.php?halaman=transaksi');
            exit;
        }
    }

    require 'views/layout/header.php';
    require 'views/admin/transaksi/tambah.php';
    require 'views/layout/footer.php';
    exit;
}

if ($aksi == 'edit') {
    $id_transaksi = 0;
    if (isset($_GET['id'])) {
        $id_transaksi = $_GET['id'];
    }
    $transaksi = ambilTransaksi($koneksi, $id_transaksi);

    if (!$transaksi || $transaksi['status'] != 'dipesan') {
        atur_pesan('gagal', 'Transaksi tidak ditemukan atau sudah tidak bisa diubah.');
        header('Location: index.php?halaman=transaksi');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_pelanggan = trim($_POST['nama_pelanggan']);
        $nomor_hp       = trim($_POST['nomor_hp']);
        $waktu_input    = $_POST['waktu_mulai'];
        $durasi_jam     = (int) $_POST['durasi_jam'];

        $ruangan       = ambilRuangan($koneksi, $transaksi['id_ruangan']);
        $waktu_mulai   = ubahFormatWaktu($waktu_input);
        $waktu_selesai = hitungWaktuSelesai($waktu_mulai, $durasi_jam);

        $transaksi['nama_pelanggan'] = $nama_pelanggan;
        $transaksi['nomor_hp']       = $nomor_hp;
        $transaksi['waktu_mulai']    = $waktu_mulai;
        $transaksi['durasi_jam']     = $durasi_jam;

        if ($nama_pelanggan == '' || $nomor_hp == '' || $waktu_input == '') {
            atur_pesan('gagal', 'Semua kolom wajib diisi.');
        } elseif ($durasi_jam < 1 || $durasi_jam > 12) {
            atur_pesan('gagal', 'Durasi harus antara 1 sampai 12 jam.');
        } elseif (cekBentrok($koneksi, $transaksi['id_ruangan'], $waktu_mulai, $waktu_selesai, $id_transaksi)) {
            atur_pesan('gagal', 'Jam bentrok dengan transaksi lain di ruangan ini.');
        } else {
            $total_biaya = $durasi_jam * $ruangan['harga_per_jam'];
            ubahTransaksi($koneksi, $id_transaksi, $nama_pelanggan, $nomor_hp,
                          $waktu_mulai, $waktu_selesai, $durasi_jam, $total_biaya);

            atur_pesan('sukses', 'Transaksi berhasil diubah.');
            header('Location: index.php?halaman=transaksi');
            exit;
        }
    }

    require 'views/layout/header.php';
    require 'views/admin/transaksi/edit.php';
    require 'views/layout/footer.php';
    exit;
}

$daftar_transaksi = ambilSemuaTransaksi($koneksi);

require 'views/layout/header.php';
require 'views/admin/transaksi/daftar.php';
require 'views/layout/footer.php';