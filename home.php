<?php
    include 'koneksi.php';

    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    if (isset($_POST['update'])) {
        $kasir_id    = (int) $_POST['kasir_id'];
        $ps_id       = (int) $_POST['ps_id'];
        $tanggal     = str_replace('T', ' ', $_POST['tanggal']);
        if (strlen($tanggal) === 16) {
            $tanggal .= ':00';
        }
        $nama_pelanggan = trim($_POST['nama_pelanggan']);
        $nomor_hp_pelanggan = trim($_POST['nomor_hp_pelanggan']);
        $durasi      = (int) $_POST['durasi_jam'];
        $jam_mulai   = $_POST['jam_mulai'];
        $jam_selesai = $_POST['jam_selesai'];
        $total       = hitung_total($koneksi, $ps_id, $durasi);

        $pelanggan_id = cari_atau_buat_pelanggan($koneksi, $nama_pelanggan, $nomor_hp_pelanggan);

        $stmt = mysqli_prepare($koneksi , "UPDATE transaksi SET pelanggan_id=?, ps_id=?, kasir_id=?, tanggal=?, durasi_jam=?, jam_mulai=?, jam_selesai=?, total_biaya=? WHERE id_transaksi=?");
        mysqli_stmt_bind_param($stmt, "iiisissdi", $pelanggan_id, $ps_id, $kasir_id, $tanggal, $durasi, $jam_mulai, $jam_selesai, $total, $id);
        mysqli_stmt_execute($stmt);

        header("Location: index.php");
        exit;
    }

    $stmt = mysqli_prepare($koneksi, "SELECT t.*, p.nama_pelanggan, p.nomor_hp_pelanggan
                                   FROM transaksi t
                                   JOIN pelanggan p ON p.id_pelanggan = t.pelanggan_id
                                   WHERE t.id_transaksi = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$row) {
        header("Location: index.php");
        exit;
    }

    $kasir_list = mysqli_query($koneksi, "SELECT id_kasir, nama_kasir FROM kasir ORDER BY nama_kasir");
    $ps_list    = mysqli_query($koneksi, "SELECT id_ps, nama_ps, tipe, harga_per_jam FROM konsol ORDER BY id_ps");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental PS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <nav class="navbar">
        <div class="navbar-logo">
            Rental PS Cihuyy
        </div>

        <ul class="navbar-menu">
            <li><a href="#home">Beranda</a></li>
            <li><a href="#pelanggan">Data Pelanggan</a></li>
            <li><a href="#riwayat">Riwayat</a></li>

        </ul>
    </nav>
<div class="container">
    

    <div class="form-card">
        <label for="pilihan" style="color:  #16a34a;">Nama kasir</label> <br>
        <select name="pilihan" id="id_kasir">
            <option value="Agus">Agus</option>
            <option value="Budi">Budi</option>
            <option value="Cinta">Cinta</option>
        </select> <br>

        Tanggal <br>
        <input type="date" name="tanggal" placeholder="tanggal" required>
        <br>

        Nama pelanggan <br>
        <input type="text" name="nama_pelanggan" placeholder="nama pelanggan" required><br>
        Nomor HP<br>
        <input type="number" name="nomor_hp_pelanggan" placeholder="nomor HP" required><br>
        <label for="pilihan" style="color:  #16a34a;">Nomor PS</label><br> 
        <select name="pilihan" id="id_ps"> 
            <option value="PS01">PS01 - PS4 - Rp8000/jam</option>
            <option value="PS02">PS02 - PS4 - Rp8000/jam</option>
            <option value="PS03">PS03 - PS4 - Rp8000/jam</option>
            <option value="PS04">PS04 - PS4 - Rp8000/jam</option>
            <option value="PS05">PS05 - PS4 - Rp8000/jam</option>
            <option value="PS06">PS05 - PS5 - Rp12000/jam</option>
            <option value="PS07">PS05 - PS5 - Rp12000/jam</option>
            <option value="PS08">PS05 - PS5 - Rp12000/jam</option>
        </select> <br> <br>
    
         Main Jam Berapa <br>

        mulai <br>
        <input type="time" name="jam_mulai" placeholder="Masukkan jam mulai" required><br>
        selesai <br>
        <input type="time" name="jam_selesai" placeholder="Masukkan jam selesai" required><br>
        <br>
        <input type="submit" name="simpan" required>
    </div>

    <div class="card-right">
        <h3>Informasi Rental</h3>
        <p>Selamat datang di Rental PS!</p>
        <p>Silakan isi form untuk menyewa PlayStation.</p>
    </div>
</div>

</body>
</html>