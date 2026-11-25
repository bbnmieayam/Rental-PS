<?php
function ambil_semua_ruangan() {
    global $koneksi;
    $stmt = $koneksi->query("SELECT * FROM ruangan_ps ORDER BY id_ruangan");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cari_ruangan($id) {
    global $koneksi;
    $stmt = $koneksi->prepare("SELECT * FROM ruangan_ps WHERE id_ruangan = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);   // false kalau tidak ada
}

function tambah_ruangan($nama, $jenis, $harga, $status) {
    global $koneksi;
    $stmt = $koneksi->prepare("INSERT INTO ruangan_ps (nama_ruangan, jenis_konsol, harga_per_jam, status) VALUES (?, ?, ?, ?)");
    $stmt->execute([$nama, $jenis, $harga, $status]);
}

function ubah_ruangan($id, $nama, $jenis, $harga, $status) {
    global $koneksi;
    $stmt = $koneksi->prepare("UPDATE ruangan_ps SET nama_ruangan = ?, jenis_konsol = ?, harga_per_jam = ?, status = ? WHERE id_ruangan = ?");
    $stmt->execute([$nama, $jenis, $harga, $status, $id]);
}

function hapus_ruangan($id) {
    global $koneksi;
    $stmt = $koneksi->prepare("DELETE FROM ruangan_ps WHERE id_ruangan = ?");
    $stmt->execute([$id]);
}

function hitung_total_ruangan() {
    global $koneksi;
    return $koneksi->query("SELECT COUNT(*) FROM ruangan_ps")->fetchColumn();
}

function hitung_ruangan_tersedia() {
    global $koneksi;
    return $koneksi->query("SELECT COUNT(*) FROM ruangan_ps WHERE status = 'tersedia'")->fetchColumn();
}