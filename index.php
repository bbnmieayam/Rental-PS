<?php
require_once 'config/database.php';
require_once 'helpers/sesi.php';
require_once 'controllers/AutentikasiController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/RuanganController.php';
require_once 'controllers/BerandaController.php';
require_once 'controllers/BookingController.php'; 
require_once 'controllers/TransaksiController.php';
require_once 'controllers/UtamaController.php';

if (isset($_GET['halaman'])) {
    $halaman = $_GET['halaman'];
} else {
    $halaman = 'utama';
}

if (isset($_GET['halaman'])) {
    $halaman = $_GET['halaman'];
} else {
    $halaman = 'utama';
}

switch ($halaman) {
    case 'utama':
        utama();
        break;
    case 'login':
        login();
        break;
    case 'daftar':
        daftar();
        break;
    case 'logout':
        logout();
        break;

    // ---- khusus admin ----
    case 'dashboard':
        cek_admin();
        dashboard();
        break;
    case 'ruangan':
        cek_admin();
        ruangan_daftar();
        break;
    case 'ruangan_tambah':
        cek_admin();
        ruangan_tambah();
        break;
    case 'ruangan_edit':
        cek_admin();
        ruangan_edit();
        break;
    case 'ruangan_hapus':
        cek_admin();
        ruangan_hapus();
        break;

     case 'transaksi':
        cek_admin();
        transaksi_daftar();
        break;
    case 'transaksi_tambah':
        cek_admin();
        transaksi_tambah();
        break;
    case 'transaksi_edit':
        cek_admin();
        transaksi_edit();
        break;
    case 'transaksi_bayar':
        cek_admin();
        transaksi_bayar();
        break;
    case 'transaksi_batal':
        cek_admin();
        transaksi_batal();
        break;
    case 'transaksi_hapus':
        cek_admin();
        transaksi_hapus();
        break;


   case 'beranda':
        cek_login();
        beranda();
        break;
    case 'booking':
        cek_login();
        booking();
        break;
    case 'riwayat':
        cek_login();
        riwayat();
        break;
    case 'riwayat_batal':
        cek_login();
        riwayat_batal();
        break;

    default:
        echo 'Halaman tidak ditemukan.';
}