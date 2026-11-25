<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental PS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<?php if (sudah_login()) { ?>
<nav class="navbar">
    <span class="logo">Rental PS</span>
    <div class="menu">
        <?php if ($_SESSION['peran'] == 'admin') { ?>
            <a href="index.php?halaman=dashboard" class="<?= kelas_menu('dashboard') ?>">Dashboard</a>
            <a href="index.php?halaman=ruangan" class="<?= kelas_menu('ruangan') ?>">Ruangan</a>
            <a href="index.php?halaman=transaksi" class="<?= kelas_menu('transaksi') ?>">Transaksi</a>
        <?php } else { ?>
            <a href="index.php?halaman=beranda" class="<?= kelas_menu('beranda') ?>">Beranda</a>
            <a href="index.php?halaman=booking" class="<?= kelas_menu('booking') ?>">Booking</a>
            <a href="index.php?halaman=riwayat" class="<?= kelas_menu('riwayat') ?>">Riwayat</a>
        <?php } ?>
        <a href="index.php?halaman=logout">Logout (<?= htmlspecialchars($_SESSION['nama_pengguna']) ?>)</a>
    </div>
</nav>
<?php } ?>

<?php tampilkan_pesan(); ?>