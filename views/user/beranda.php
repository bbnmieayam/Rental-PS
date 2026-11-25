<div class="isi_halaman">
    <h2>Daftar Ruangan</h2>
    <p>Pilih ruangan PS yang ingin kamu booking.</p>

    <div class="kotak_ruangan">
        <?php foreach ($daftar_ruangan as $r) { ?>
        <div class="kartu_ruangan">
            <h3><?= htmlspecialchars($r['nama_ruangan']) ?></h3>
            <p><?= htmlspecialchars($r['jenis_konsol']) ?></p>
            <p class="harga">Rp <?= number_format($r['harga_per_jam'], 0, ',', '.') ?> / jam</p>
            <p>Status: <?= htmlspecialchars($r['status']) ?></p>
        </div>
        <?php } ?>
    </div>
</div>