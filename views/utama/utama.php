<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental PS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<nav class="navbar navbar_utama">
    <span class="logo">Rental PS</span>
    <div class="menu">
        <a href="#layanan">Layanan</a>
        <a href="#ruangan">Ruangan</a>
        <a href="index.php?halaman=login" class="tombol tombol_utama" data-buka-login>Login</a>
    </div>
</nav>

<?php if (!$buka_login && !$buka_daftar) { tampilkan_pesan(); } ?>

<header class="hero">
    <h1>Main PlayStation lebih nyaman di Rental PS Cihuyy</h1>
    <p>Sewa ruangan PS4 atau PS5 per jam. Lihat ruangan yang tersedia, booking secara online,
       dan total biaya dihitung otomatis.</p>
    <div class="hero_tombol">
        <a href="#ruangan" class="tombol tombol_utama">Lihat Ruangan</a>
        <a href="index.php?halaman=daftar" class="tombol tombol_garis" data-buka-daftar>Daftar Akun</a>
    </div>
</header>

<section class="isi_halaman" id="layanan">
    <h2>Layanan Kami</h2>
    <p>Yang bisa kamu dapatkan di Rental PS.</p>

    <div class="kotak_ruangan">
        <div class="kartu_ruangan">
           
        </div>
        <div class="kartu_ruangan">
           
        </div>
        <div class="kartu_ruangan">
           
        </div>
        <div class="kartu_ruangan">
           
    </div>
</section>

<section class="isi_halaman" id="ruangan">
    <h2>Ruangan Kami</h2>
    <p>Login terlebih dahulu untuk melakukan booking.</p>

    <?php if (count($daftar_ruangan) == 0) { ?>
        <p>Belum ada ruangan.</p>
    <?php } else { ?>
    <div class="kotak_ruangan">
        <?php foreach ($daftar_ruangan as $ruangan) {
            if ($ruangan['status'] == 'tersedia') {
                $kelas_status = 'tersedia';
            } else {
                $kelas_status = 'tidak_tersedia';
            }
        ?>
        <div class="kartu_ruangan">
            <h3><?= htmlspecialchars($ruangan['nama_ruangan']) ?></h3>
            <p><?= htmlspecialchars($ruangan['jenis_konsol']) ?></p>
            <p class="harga">Rp <?= number_format($ruangan['harga_per_jam'], 0, ',', '.') ?> / jam</p>
            <p><span class="status <?= $kelas_status ?>"><?= htmlspecialchars($ruangan['status']) ?></span></p>
            <a href="index.php?halaman=login" class="tombol tombol_utama" data-buka-login>Login untuk Booking</a>
        </div>
        <?php } ?>
    </div>
    <?php } ?>
</section>

<footer class="footer_utama">
    &copy; <?= date('Y') ?> Rental PS
</footer>


<div class="modal_latar <?php if ($buka_login || $buka_daftar) { echo 'terbuka'; } ?>" id="modal_auth"
     data-isi="<?php if ($buka_daftar) { echo 'daftar'; } else { echo 'login'; } ?>">
    <div class="modal_isi">
        <button type="button" class="modal_tutup" id="tutup_modal" aria-label="Tutup">&times;</button>
        <?php if ($buka_login || $buka_daftar) { tampilkan_pesan(); } ?>
        <?php if ($buka_daftar) { ?>
            <?php require 'views/autentikasi/daftar.php'; ?>
        <?php } else { ?>
            <?php require 'views/autentikasi/login.php'; ?>
        <?php } ?>
    </div>
</div>

<script src="assets/js/script.js"></script>
<script>
(function () {
    var modal = document.getElementById('modal_auth');
    var isi   = modal.getAttribute('data-isi');
    function buka() {
        modal.classList.add('terbuka');
        document.body.classList.add('modal_aktif');
        var kolom = modal.querySelector('input');
        if (kolom) { kolom.focus(); }
    }

    function tutup() {
        modal.classList.remove('terbuka');
        document.body.classList.remove('modal_aktif');
    }

    function pasang(pemilih, jenis) {
        var daftarTombol = document.querySelectorAll(pemilih);
        for (var i = 0; i < daftarTombol.length; i++) {
            daftarTombol[i].addEventListener('click', function (e) {
                if (isi === jenis) {
                    e.preventDefault();
                    buka();
                }
            });
        }
    }

    pasang('[data-buka-login]', 'login');
    pasang('[data-buka-daftar]', 'daftar');

    document.getElementById('tutup_modal').addEventListener('click', tutup);

    modal.addEventListener('click', function (e) {
        if (e.target === modal) { tutup(); }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { tutup(); }
    });

    if (modal.classList.contains('terbuka')) {
        document.body.classList.add('modal_aktif');
    }
})();
</script>
</body>
</html>