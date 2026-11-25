<?php
function cari_pengguna($nama_pengguna) {
    global $koneksi;
    $stmt = $koneksi->prepare("SELECT * FROM pengguna WHERE nama_pengguna = ? LIMIT 1");
    $stmt->execute([$nama_pengguna]);
    $hasil = $stmt->fetch(PDO::FETCH_ASSOC);
    return $hasil;   // false kalau tidak ketemu
}

function daftar_pengguna($nama_lengkap, $nama_pengguna, $kata_sandi) {
    global $koneksi;
    $hash = password_hash($kata_sandi, PASSWORD_DEFAULT);
    $stmt = $koneksi->prepare("INSERT INTO pengguna (nama_lengkap, nama_pengguna, kata_sandi, peran) VALUES (?, ?, ?, 'user')");
    $stmt->execute([$nama_lengkap, $nama_pengguna, $hash]);
}