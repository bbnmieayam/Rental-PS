<?php
session_start();

function atur_pesan($jenis, $teks) {
    $_SESSION['pesan_jenis'] = $jenis;
    $_SESSION['pesan_teks']  = $teks;
}

function tampilkan_pesan() {
    if (isset($_SESSION['pesan_teks'])) {
        $jenis = htmlspecialchars($_SESSION['pesan_jenis']);
        $teks  = htmlspecialchars($_SESSION['pesan_teks']);
        echo "<div class='notifikasi notifikasi_$jenis'>$teks</div>";
        unset($_SESSION['pesan_jenis']);
        unset($_SESSION['pesan_teks']);
    }
}

function sudah_login() {
    return isset($_SESSION['id_pengguna']);
}

function pindah($tujuan) {
    header("Location: index.php?halaman=$tujuan");
    exit;
}

function cek_login() {
    if (!sudah_login()) {
        atur_pesan('gagal', 'Silakan login terlebih dahulu.');
        pindah('login');
    }
}

function cek_admin() {
    cek_login();
    if ($_SESSION['peran'] != 'admin') {
        atur_pesan('gagal', 'Anda tidak punya akses ke halaman itu.');
        pindah('beranda');
    }
}