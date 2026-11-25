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

function hitung_transaksi_ruangan($id_ruangan) {
    global $koneksi;
    $stmt = $koneksi->prepare("SELECT COUNT(*) FROM transaksi WHERE id_ruangan = ?");
    $stmt->execute([$id_ruangan]);
    return $stmt->fetchColumn();
}

function ubah_format_waktu($waktu_input) {
    return date('Y-m-d H:i:s', strtotime($waktu_input));
}

function hitung_waktu_selesai($waktu_mulai, $durasi_jam) {
    return date('Y-m-d H:i:s', strtotime($waktu_mulai . ' +' . $durasi_jam . ' hours'));
}

function cek_bentrok($id_ruangan, $waktu_mulai, $waktu_selesai, $id_abaikan) {
    global $koneksi;
    $stmt = $koneksi->prepare("SELECT COUNT(*) FROM transaksi
        WHERE id_ruangan = ? AND status <> 'batal' AND id_transaksi <> ?
          AND ? < waktu_selesai AND ? > waktu_mulai");
    $stmt->execute([$id_ruangan, $id_abaikan, $waktu_mulai, $waktu_selesai]);
    return $stmt->fetchColumn() > 0;
}

function ambil_semua_transaksi() {
    global $koneksi;
    $stmt = $koneksi->query("SELECT transaksi.*, ruangan_ps.nama_ruangan
        FROM transaksi JOIN ruangan_ps ON transaksi.id_ruangan = ruangan_ps.id_ruangan
        ORDER BY transaksi.waktu_mulai DESC");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function ambil_transaksi_pengguna($id_pengguna) {
    global $koneksi;
    $stmt = $koneksi->prepare("SELECT transaksi.*, ruangan_ps.nama_ruangan
        FROM transaksi JOIN ruangan_ps ON transaksi.id_ruangan = ruangan_ps.id_ruangan
        WHERE transaksi.id_pengguna = ?
        ORDER BY transaksi.waktu_mulai DESC");
    $stmt->execute([$id_pengguna]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function cari_transaksi($id_transaksi) {
    global $koneksi;
    $stmt = $koneksi->prepare("SELECT transaksi.*, ruangan_ps.nama_ruangan
        FROM transaksi JOIN ruangan_ps ON transaksi.id_ruangan = ruangan_ps.id_ruangan
        WHERE transaksi.id_transaksi = ?");
    $stmt->execute([$id_transaksi]);
    return $stmt->fetch(PDO::FETCH_ASSOC);   // false kalau tidak ada
}

function simpan_transaksi($id_ruangan, $id_pengguna, $nama_pelanggan, $nomor_hp, $sumber,
                          $waktu_mulai, $waktu_selesai, $durasi_jam, $total_biaya) {
    global $koneksi;
    $stmt = $koneksi->prepare("INSERT INTO transaksi
        (id_ruangan, id_pengguna, nama_pelanggan, nomor_hp, sumber, waktu_mulai, waktu_selesai, durasi_jam, total_biaya)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([$id_ruangan, $id_pengguna, $nama_pelanggan, $nomor_hp, $sumber,
                    $waktu_mulai, $waktu_selesai, $durasi_jam, $total_biaya]);
}

function ubah_transaksi($id_transaksi, $nama_pelanggan, $nomor_hp,
                        $waktu_mulai, $waktu_selesai, $durasi_jam, $total_biaya) {
    global $koneksi;
    $stmt = $koneksi->prepare("UPDATE transaksi SET nama_pelanggan = ?, nomor_hp = ?, waktu_mulai = ?,
        waktu_selesai = ?, durasi_jam = ?, total_biaya = ? WHERE id_transaksi = ?");
    $stmt->execute([$nama_pelanggan, $nomor_hp, $waktu_mulai,
                    $waktu_selesai, $durasi_jam, $total_biaya, $id_transaksi]);
}

function ubah_status_transaksi($id_transaksi, $status) {
    global $koneksi;
    $stmt = $koneksi->prepare("UPDATE transaksi SET status = ? WHERE id_transaksi = ?");
    $stmt->execute([$status, $id_transaksi]);
}

function hapus_transaksi($id_transaksi) {
    global $koneksi;
    $stmt = $koneksi->prepare("DELETE FROM transaksi WHERE id_transaksi = ?");
    $stmt->execute([$id_transaksi]);
}

function perbarui_status_ruangan($id_ruangan) {
    global $koneksi;
    $stmt = $koneksi->prepare("SELECT COUNT(*) FROM transaksi WHERE id_ruangan = ? AND status = 'dipesan'");
    $stmt->execute([$id_ruangan]);

    if ($stmt->fetchColumn() > 0) {
        $status_baru = 'tidak tersedia';
    } else {
        $status_baru = 'tersedia';
    }

    $stmt = $koneksi->prepare("UPDATE ruangan_ps SET status = ? WHERE id_ruangan = ?");
    $stmt->execute([$status_baru, $id_ruangan]);
}

