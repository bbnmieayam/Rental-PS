<?php
$server        = "localhost";
$nama_database = "rentalps_db";
$nama_pengguna = "root";
$kata_sandi    = "";

try {
    $koneksi = new PDO("mysql:host=$server;dbname=$nama_database", $nama_pengguna, $kata_sandi);
    $koneksi->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $koneksi->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $kesalahan) {
    echo "Koneksi gagal: " . $kesalahan->getMessage();
}