<?php
require_once 'models/RuanganPs.php';
require_once 'models/Transaksi.php';

function dashboard() {
    $total_ruangan    = hitung_total_ruangan();
    $ruangan_tersedia = hitung_ruangan_tersedia();
    $total_transaksi  = hitung_semua_transaksi();
    $jumlah_dipesan   = hitung_transaksi_status('dipesan');
    $pendapatan       = hitung_pendapatan();

    require 'views/layout/header.php';
    require 'views/admin/dashboard.php';
    require 'views/layout/footer.php';
}