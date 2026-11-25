<div class="kepala_halaman">
    <h2>Daftar Transaksi</h2>
    <a href="index.php?halaman=transaksi&aksi=tambah" class="tombol tombol_utama">+ Tambah Transaksi</a>
</div>

<?php if (count($daftar_transaksi) == 0) { ?>
    <p>Belum ada transaksi.</p>
<?php } else { ?>
    <div class="bungkus_tabel">
    <table class="tabel">
        <tr>
            <th>No</th>
            <th>Pelanggan</th>
            <th>Ruangan</th>
            <th>Waktu</th>
            <th>Total</th>
            <th>Sumber</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php $nomor = 1; foreach ($daftar_transaksi as $baris) { ?>
        <tr>
            <td><?= $nomor++ ?></td>
            <td>
                <?= htmlspecialchars($baris['nama_pelanggan']) ?><br>
                <small><?= htmlspecialchars($baris['nomor_hp']) ?></small>
            </td>
            <td><?= htmlspecialchars($baris['nama_ruangan']) ?></td>
            <td>
                <?= date('d/m/Y H:i', strtotime($baris['waktu_mulai'])) ?><br>
                <small>s.d. <?= date('d/m/Y H:i', strtotime($baris['waktu_selesai'])) ?></small>
            </td>
            <td>Rp <?= number_format($baris['total_biaya'], 0, ',', '.') ?></td>
            <td><?= $baris['sumber'] ?></td>
            <td><span class="status <?= $baris['status'] ?>"><?= $baris['status'] ?></span></td>
            <td>
                <div class="baris_aksi">
                <?php if ($baris['status'] == 'dipesan') { ?>
                    <a href="index.php?halaman=transaksi&aksi=edit&id=<?= $baris['id_transaksi'] ?>"
                       class="tombol tombol_kecil tombol_utama">Edit</a>

                    <form method="POST" action="index.php?halaman=transaksi&aksi=bayar">
                        <input type="hidden" name="id_transaksi" value="<?= $baris['id_transaksi'] ?>">
                        <button type="submit" class="tombol tombol_kecil tombol_sukses">Bayar</button>
                    </form>

                    <form method="POST" action="index.php?halaman=transaksi&aksi=batal"
                          onsubmit="return confirm('Batalkan transaksi ini?')">
                        <input type="hidden" name="id_transaksi" value="<?= $baris['id_transaksi'] ?>">
                        <button type="submit" class="tombol tombol_kecil tombol_netral">Batal</button>
                    </form>
                <?php } ?>

                    <form method="POST" action="index.php?halaman=transaksi&aksi=hapus"
                          onsubmit="return confirm('Hapus transaksi ini?')">
                        <input type="hidden" name="id_transaksi" value="<?= $baris['id_transaksi'] ?>">
                        <button type="submit" class="tombol tombol_kecil tombol_bahaya">Hapus</button>
                    </form>
                </div>
            </td>
        </tr>
        <?php } ?>
    </table>
    </div>
<?php } ?>