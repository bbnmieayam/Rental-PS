<div class="isi_halaman">
    <h2>Daftar Ruangan</h2>
    <p>Pilih ruangan PS yang ingin kamu booking.</p>

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

            <?php if ($ruangan['status'] != 'tersedia') { ?>
                <p class="catatan_card">Sedang ada booking. Kamu masih bisa memilih jam lain.</p>
            <?php } ?>

            <?php if ($_SESSION['peran'] == 'user') { ?>
                <a href="index.php?halaman=booking&id_ruangan=<?= $ruangan['id_ruangan'] ?>"
                   class="tombol tombol_utama">Booking</a>
            <?php } ?>
        </div>
        <?php } ?>
    </div>
</div>