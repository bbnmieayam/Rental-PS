<?php
require_once 'models/RuanganPs.php';

function utama($buka_login = false, $nama_pengguna_lama = '', $buka_daftar = false, $nama_lengkap_lama = '') {
    if (sudah_login()) {
        if ($_SESSION['peran'] == 'admin') {
            pindah('dashboard');
        } else {
            pindah('beranda');
        }
    }

    $daftar_ruangan = ambil_semua_ruangan();

    require 'views/utama/utama.php';
}