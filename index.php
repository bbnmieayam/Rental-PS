<?php
require_once 'config/database.php';
require_once 'helpers/sesi.php';
require_once 'controllers/AutentikasiController.php';

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

    default:
        echo 'Halaman tidak ditemukan.';
}