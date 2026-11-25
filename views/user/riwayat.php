<h2>Riwayat Booking</h2>

<?php if (count($daftar_transaksi) == 0) { ?>
    <p>Belum ada booking. <a href="index.php?halaman=beranda">Pilih ruangan</a></p>
<?php } else { ?>
    <div class="bungkus_tabel">
    <table class="tabel">
        <tr>
            <th>Ruangan</th>
            <th>Mulai</th>
            <th>Selesai</th>
            <th>Durasi</th>
            <th>Total</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php foreach ($daftar_transaksi as $baris) { ?>
        <tr>
            <td><?= htmlspecialchars($baris['nama_ruangan']) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($baris['waktu_mulai'])) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($baris['waktu_selesai'])) ?></td>
            <td><?= $baris['durasi_jam'] ?> jam</td>
            <td>Rp <?= number_format($baris['total_biaya'], 0, ',', '.') ?></td>
            <td><span class="status <?= $baris['status'] ?>"><?= $baris['status'] ?></span></td>
            <td>
                <?php if ($baris['status'] == 'dipesan') { ?>
                    <form method="POST" action="index.php?halaman=riwayat_batal"
                          onsubmit="return confirm('Batalkan booking ini?')">
                        <input type="hidden" name="id_transaksi" value="<?= $baris['id_transaksi'] ?>">
                        <button type="submit" class="tombol tombol_kecil tombol_bahaya">Batalkan</button>
                    </form>
                <?php } ?>
            </td>
        </tr>
        <?php } ?>
    </table>
    </div>
<?php } ?>