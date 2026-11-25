<?php
require_once 'models/Pengguna.php';

function login() {
    if (sudah_login()) {
        if ($_SESSION['peran'] == 'admin') {
            pindah('dashboard');
        } else {
            pindah('beranda');
        }
    }

    $nama_pengguna_lama = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_pengguna_lama = trim($_POST['nama_pengguna']);
        $kata_sandi         = $_POST['kata_sandi'];

        $akun = cari_pengguna($nama_pengguna_lama);

        if ($akun && password_verify($kata_sandi, $akun['kata_sandi'])) {
            session_regenerate_id(true);
            $_SESSION['id_pengguna']   = $akun['id_pengguna'];
            $_SESSION['nama_lengkap']  = $akun['nama_lengkap'];
            $_SESSION['nama_pengguna'] = $akun['nama_pengguna'];
            $_SESSION['peran']         = $akun['peran'];

            atur_pesan('sukses', 'Selamat datang, ' . $akun['nama_lengkap'] . '!');

            if ($akun['peran'] == 'admin') {
                pindah('dashboard');
            } else {
                pindah('beranda');
            }
        } else {
            atur_pesan('gagal', 'Nama pengguna atau kata sandi salah.');
        }
    }

    utama(true, $nama_pengguna_lama);
}

function daftar() {
    if (sudah_login()) {
        pindah('beranda');
    }

    $nama_lengkap_lama  = '';
    $nama_pengguna_lama = '';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nama_lengkap_lama  = trim($_POST['nama_lengkap']);
        $nama_pengguna_lama = trim($_POST['nama_pengguna']);
        $kata_sandi         = $_POST['kata_sandi'];
        $konfirmasi_sandi   = $_POST['konfirmasi_sandi'];

        $error = '';

        if ($nama_lengkap_lama == '') {
            $error = 'Nama lengkap wajib diisi.';
        } elseif (!preg_match('/^[A-Za-z0-9_]{4,30}$/', $nama_pengguna_lama)) {
            $error = 'Nama pengguna harus 4-30 karakter: huruf, angka, atau garis bawah.';
        } elseif (strlen($kata_sandi) < 6) {
            $error = 'Kata sandi minimal 6 karakter.';
        } elseif ($kata_sandi != $konfirmasi_sandi) {
            $error = 'Konfirmasi kata sandi tidak cocok.';
        } elseif (cari_pengguna($nama_pengguna_lama)) {
            $error = 'Nama pengguna sudah dipakai.';
        }

        if ($error == '') {
            daftar_pengguna($nama_lengkap_lama, $nama_pengguna_lama, $kata_sandi);
            atur_pesan('sukses', 'Akun berhasil dibuat. Silakan login.');
            pindah('login');
        } else {
            atur_pesan('gagal', $error);
        }
    }

    utama(false, $nama_pengguna_lama, true, $nama_lengkap_lama);
}

function logout() {
    session_destroy();
    session_start();
    atur_pesan('sukses', 'Anda sudah logout.');
    pindah('login');
}