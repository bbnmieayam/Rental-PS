<?php
require_once 'config/database.php';
require_once 'helpers/sesi.php';
require_once 'controllers/AutentikasiController.php';
require_once 'controllers/DashboardController.php';
require_once 'controllers/RuanganController.php';
require_once 'controllers/BerandaController.php';

if (isset($_GET['halaman'])) {
    $halaman = $_GET['halaman'];
} else {
    $halaman = 'login';
}

switch ($halaman) {
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

    // ---- khusus user ----
    case 'beranda':
        cek_login();
        beranda();
        break;

    default:
        echo 'Halaman tidak ditemukan.';
}