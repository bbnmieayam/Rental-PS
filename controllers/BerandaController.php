<?php
require_once 'models/RuanganPs.php';

function beranda() {
    $daftar_ruangan = ambil_semua_ruangan();

    require 'views/layout/header.php';
    require 'views/user/beranda.php';
    require 'views/layout/footer.php';
}

