<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "rentalps_db";

$koneksi = mysqli_connect($host, $user, $password, $database);
if (!$koneksi) { 
    die("Koneksi gagal: " . mysqli_connect_error());
}

mysqli_set_charset($koneksi, "utf8mb4");

function cari_atau_buat_pelanggan($koneksi, $nama, $hp)
{
    $stmt = mysqli_prepare($koneksi, "SELECT id_pelanggan FROM pelanggan WHERE nama_pelanggan = ? AND nomor_hp_pelanggan = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "ss", $nama, $hp);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($row = mysqli_fetch_assoc($res)) {
        return (int) $row['id_pelanggan'];
    }

    $stmt = mysqli_prepare($koneksi, "INSERT INTO pelanggan (nama_pelanggan, nomor_hp_pelanggan) VALUES (?, ?)");
    mysqli_stmt_bind_param($stmt, "ss", $nama, $hp);
    mysqli_stmt_execute($stmt);
    return (int) mysqli_insert_id($koneksi);
}

function hitung_total($koneksi, $ps_id, $durasi)
{
    $stmt = mysqli_prepare($koneksi, "SELECT harga_per_jam FROM konsol WHERE id_ps = ?");
    mysqli_stmt_bind_param($stmt, "i", $ps_id);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    $harga = $row ? (float) $row['harga_per_jam'] : 0;
    return $harga * (int) $durasi;
}
?>

