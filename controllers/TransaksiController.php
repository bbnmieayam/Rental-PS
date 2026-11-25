<?php
require_once 'models/RuanganPs.php';
require_once 'models/Transaksi.php';

function transaksi_daftar() {
    $daftar_transaksi = ambil_semua_transaksi();

    require 'views/layout/header.php';
    require 'views/admin/transaksi/daftar.php';
    require 'views/layout/footer.php';
}

function transaksi_tambah() {
    $daftar_ruangan = ambil_semua_ruangan();

    $id_ruangan_lama     = '';
    $nama_pelanggan_lama = '';
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
                                       $waktu_mulai_lama, $durasi_jam_lama, 0, false);

        if ($error == '') {
            $waktu_mulai   = ubah_format_waktu($waktu_mulai_lama);
            $waktu_selesai = hitung_waktu_selesai($waktu_mulai, $durasi_jam_lama);
            $total_biaya   = $durasi_jam_lama * $ruangan['harga_per_jam'];

            simpan_transaksi($id_ruangan_lama, $_SESSION['id_pengguna'], $nama_pelanggan_lama,
                             $nomor_hp_lama, 'kasir', $waktu_mulai, $waktu_selesai,
                             $durasi_jam_lama, $total_biaya);
            perbarui_status_ruangan($id_ruangan_lama);

            atur_pesan('sukses', 'Transaksi berhasil ditambahkan.');
            pindah('transaksi');
        } else {
            atur_pesan('gagal', $error);
        }
    }

    require 'views/layout/header.php';
    require 'views/admin/transaksi/tambah.php';
    require 'views/layout/footer.php';
}

function transaksi_edit() {
    $id_transaksi = 0;
    if (isset($_GET['id'])) {
        $id_transaksi = (int) $_GET['id'];
    }
    $transaksi = cari_transaksi($id_transaksi);

    if (!$transaksi || $transaksi['status'] != 'dipesan') {
        atur_pesan('gagal', 'Transaksi tidak ditemukan atau sudah tidak bisa diubah.');
        pindah('transaksi');
    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_pelanggan = trim($_POST['nama_pelanggan']);
        $nomor_hp       = trim($_POST['nomor_hp']);
        $waktu_input    = $_POST['waktu_mulai'];
        $durasi_jam     = (int) $_POST['durasi_jam'];

        $ruangan = cari_ruangan($transaksi['id_ruangan']);
        $error   = cek_input_transaksi($ruangan, $nama_pelanggan, $nomor_hp,
                                       $waktu_input, $durasi_jam, $id_transaksi, false);

        if ($error == '') {
            $waktu_mulai   = ubah_format_waktu($waktu_input);
            $waktu_selesai = hitung_waktu_selesai($waktu_mulai, $durasi_jam);
            $total_biaya   = $durasi_jam * $ruangan['harga_per_jam'];

            ubah_transaksi($id_transaksi, $nama_pelanggan, $nomor_hp,
                           $waktu_mulai, $waktu_selesai, $durasi_jam, $total_biaya);
            atur_pesan('sukses', 'Transaksi berhasil diubah.');
            pindah('transaksi');
        } else {
            atur_pesan('gagal', $error);

            // isi ulang form dengan input terakhir
            $transaksi['nama_pelanggan'] = $nama_pelanggan;
            $transaksi['nomor_hp']       = $nomor_hp;
            $transaksi['durasi_jam']     = $durasi_jam;
            if ($waktu_input != '') {
                $transaksi['waktu_mulai'] = ubah_format_waktu($waktu_input);
            }
        }
    }

    require 'views/layout/header.php';
    require 'views/admin/transaksi/edit.php';
    require 'views/layout/footer.php';
}

function transaksi_bayar() {
    ubah_status_dari_form('lunas', 'Transaksi ditandai lunas.');
}

function transaksi_batal() {
    ubah_status_dari_form('batal', 'Transaksi dibatalkan.');
}

function transaksi_hapus() {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        pindah('transaksi');
    }

    $id_transaksi = (int) $_POST['id_transaksi'];
    $transaksi    = cari_transaksi($id_transaksi);

    if (!$transaksi) {
        atur_pesan('gagal', 'Transaksi tidak ditemukan.');
    } else {
        hapus_transaksi($id_transaksi);
        perbarui_status_ruangan($transaksi['id_ruangan']);
        atur_pesan('sukses', 'Transaksi berhasil dihapus.');
    }
    pindah('transaksi');
}

// dipakai bersama oleh bayar dan batal
function ubah_status_dari_form($status_baru, $pesan_sukses) {
    if ($_SERVER['REQUEST_METHOD'] != 'POST') {
        pindah('transaksi');
    }

    $id_transaksi = (int) $_POST['id_transaksi'];
    $transaksi    = cari_transaksi($id_transaksi);

    if (!$transaksi) {
        atur_pesan('gagal', 'Transaksi tidak ditemukan.');
    } elseif ($transaksi['status'] != 'dipesan') {
        atur_pesan('gagal', 'Hanya transaksi berstatus dipesan yang bisa diproses.');
    } else {
        ubah_status_transaksi($id_transaksi, $status_baru);
        perbarui_status_ruangan($transaksi['id_ruangan']);
        atur_pesan('sukses', $pesan_sukses);
    }
    pindah('transaksi');
}

// validasi dipakai bersama oleh booking, tambah, dan edit
// mengembalikan teks error, atau '' kalau semuanya benar
function cek_input_transaksi($ruangan, $nama, $nomor_hp, $waktu_input, $durasi_jam, $id_abaikan, $cek_waktu_lewat) {
    if (!$ruangan) {
        return 'Silakan pilih ruangan.';
    }
    if ($nama == '' || $nomor_hp == '' || $waktu_input == '') {
        return 'Semua kolom wajib diisi.';
    }
    if (!preg_match('/^[0-9+]{8,15}$/', $nomor_hp)) {
        return 'Nomor HP tidak valid (8-15 angka).';
    }
    if ($durasi_jam < 1 || $durasi_jam > 12) {
        return 'Durasi harus antara 1 sampai 12 jam.';
    }

    $waktu_mulai   = ubah_format_waktu($waktu_input);
    $waktu_selesai = hitung_waktu_selesai($waktu_mulai, $durasi_jam);

    if ($cek_waktu_lewat && strtotime($waktu_mulai) < time() - 300) {
        return 'Waktu mulai tidak boleh sudah lewat.';
    }
    if (cek_bentrok($ruangan['id_ruangan'], $waktu_mulai, $waktu_selesai, $id_abaikan)) {
        return 'Maaf, jam tersebut sudah dipakai. Silakan pilih jam lain.';
    }
    return '';
}