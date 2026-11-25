<div class="isi_halaman">
    <h2>Dashboard Admin</h2>
    <p>Halo, <?= htmlspecialchars($_SESSION['nama_lengkap']) ?>.</p>

    <div class="kotak_statistik">
        <div class="kartu_statistik">
            <span>Total Ruangan</span>
            <strong><?= $total_ruangan ?></strong>
        </div>
        <div class="kartu_statistik">
            <span>Ruangan Tersedia</span>
            <strong><?= $ruangan_tersedia ?></strong>
        </div>
        <div class="kartu_statistik">
            <span>Total Transaksi</span>
            <strong><?= $total_transaksi ?></strong>
        </div>
        <div class="kartu_statistik">
            <span>Menunggu (Dipesan)</span>
            <strong><?= $jumlah_dipesan ?></strong>
        </div>
        <div class="kartu_statistik">
            <span>Pendapatan (Lunas)</span>
            <strong>Rp <?= number_format($pendapatan, 0, ',', '.') ?></strong>
        </div>
    </div>
</div>