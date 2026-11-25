<div class="isi_halaman">
    <h2>Kelola Ruangan</h2>
    <a href="index.php?halaman=ruangan_tambah" class="tombol tombol_utama">+ Tambah Ruangan</a>

    <table class="tabel">
        <tr>
            <th>No</th>
            <th>Nama Ruangan</th>
            <th>Konsol</th>
            <th>Harga / Jam</th>
            <th>Status</th>
            <th>Aksi</th>
        </tr>
        <?php $no = 1; ?>
        <?php foreach ($daftar_ruangan as $r) { ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= htmlspecialchars($r['nama_ruangan']) ?></td>
            <td><?= htmlspecialchars($r['jenis_konsol']) ?></td>
            <td>Rp <?= number_format($r['harga_per_jam'], 0, ',', '.') ?></td>
            <td><?= htmlspecialchars($r['status']) ?></td>
            <td>
                <a href="index.php?halaman=ruangan_edit&id=<?= $r['id_ruangan'] ?>" class="tombol">Edit</a>
                <form method="POST" action="index.php?halaman=ruangan_hapus" style="display:inline"
                      onsubmit="return confirm('Yakin hapus ruangan ini?')">
                    <input type="hidden" name="id_ruangan" value="<?= $r['id_ruangan'] ?>">
                    <button type="submit" class="tombol tombol_bahaya">Hapus</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</div>