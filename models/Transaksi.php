<?php
function hitung_semua_transaksi() {
    global $koneksi;
    return $koneksi->query("SELECT COUNT(*) FROM transaksi")->fetchColumn();
}

function hitung_transaksi_status($status) {
    global $koneksi;
    $stmt = $koneksi->prepare("SELECT COUNT(*) FROM transaksi WHERE status = ?");
    $stmt->execute([$status]);
    return $stmt->fetchColumn();
}

function hitung_pendapatan() {
    global $koneksi;
    return $koneksi->query("SELECT COALESCE(SUM(total_biaya), 0) FROM transaksi WHERE status = 'lunas'")->fetchColumn();
}

// dipakai supaya ruangan yang sudah punya transaksi tidak bisa dihapus
function hitung_transaksi_ruangan($id_ruangan) {
    global $koneksi;
    $stmt = $koneksi->prepare("SELECT COUNT(*) FROM transaksi WHERE id_ruangan = ?");
    $stmt->execute([$id_ruangan]);
    return $stmt->fetchColumn();
}