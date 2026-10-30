<?php
    include 'koneksi.php';

    $kembali = 'riwayat.php';

    if (isset($_GET['id'])) {
        $id = (int) $_GET['id'];

        $stmt = mysqli_prepare($koneksi, "DELETE FROM transaksi WHERE id_transaksi = ?");
        mysqli_stmt_bind_param($stmt, "i", $id);
        mysqli_stmt_execute($stmt);
    }

    header("Location: $kembali");
    exit;