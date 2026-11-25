<?php
require_once 'models/RuanganPs.php';
require_once 'models/Transaksi.php';

function ruangan_daftar() {
    $daftar_ruangan = ambil_semua_ruangan();

    require 'views/layout/header.php';
    require 'views/admin/ruangan/daftar.php';
    require 'views/layout/footer.php';
}

function ruangan_tambah() {
    $nama_ruangan  = '';
    $jenis_konsol  = 'PS4';
    $harga_per_jam = '';
    $status        = 'tersedia';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_ruangan  = trim($_POST['nama_ruangan']);
        $jenis_konsol  = trim($_POST['jenis_konsol']);
        $harga_per_jam = trim($_POST['harga_per_jam']);
        $status        = $_POST['status'];

        $error = cek_input_ruangan($nama_ruangan, $jenis_konsol, $harga_per_jam, $status);

        if ($error == '') {
            tambah_ruangan($nama_ruangan, $jenis_konsol, $harga_per_jam, $status);
            atur_pesan('sukses', 'Ruangan berhasil ditambahkan.');
            pindah('ruangan');
        } else {
            atur_pesan('gagal', $error);
        }
    }

    require 'views/layout/header.php';
    require 'views/admin/ruangan/tambah.php';
    require 'views/layout/footer.php';
}

function ruangan_edit() {
    $id_ruangan = (int) $_GET['id'];
    $ruangan = cari_ruangan($id_ruangan);

    if (!$ruangan) {
        atur_pesan('gagal', 'Ruangan tidak ditemukan.');
        pindah('ruangan');
    }

    $nama_ruangan  = $ruangan['nama_ruangan'];
    $jenis_konsol  = $ruangan['jenis_konsol'];
    $harga_per_jam = $ruangan['harga_per_jam'];
    $status        = $ruangan['status'];

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_ruangan  = trim($_POST['nama_ruangan']);
        $jenis_konsol  = trim($_POST['jenis_konsol']);
        $harga_per_jam = trim($_POST['harga_per_jam']);
        $status        = $_POST['status'];

        $error = cek_input_ruangan($nama_ruangan, $jenis_konsol, $harga_per_jam, $status);

        if ($error == '') {
            ubah_ruangan($id_ruangan, $nama_ruangan, $jenis_konsol, $harga_per_jam, $status);
            atur_pesan('sukses', 'Ruangan berhasil diubah.');
            pindah('ruangan');
        } else {
            atur_pesan('gagal', $error);
        }
    }

    require 'views/layout/header.php';
    require 'views/admin/ruangan/edit.php';
    require 'views/layout/footer.php';
}

function ruangan_hapus() {
    // hapus hanya lewat POST (dari tombol di tabel)
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        pindah('ruangan');
    }

    $id_ruangan = (int) $_POST['id_ruangan'];

    if (hitung_transaksi_ruangan($id_ruangan) > 0) {
        atur_pesan('gagal', 'Ruangan tidak bisa dihapus karena sudah punya transaksi. Ubah status menjadi "tidak tersedia" saja.');
    } else {
        hapus_ruangan($id_ruangan);
        atur_pesan('sukses', 'Ruangan berhasil dihapus.');
    }
    pindah('ruangan');
}

// validasi dipakai bersama oleh tambah dan edit
function cek_input_ruangan($nama, $jenis, $harga, $status) {
    if ($nama == '') {
        return 'Nama ruangan wajib diisi.';
    }
    if ($jenis == '') {
        return 'Jenis konsol wajib diisi.';
    }
    if (!is_numeric($harga) || $harga <= 0) {
        return 'Harga per jam harus berupa angka lebih dari 0.';
    }
    if ($status != 'tersedia' && $status != 'tidak tersedia') {
        return 'Status tidak valid.';
    }
    return '';
}