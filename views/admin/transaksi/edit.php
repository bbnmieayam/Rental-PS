<div class="kartu_form kartu_lebar">
    <h2>Edit Transaksi</h2>
    <p class="keterangan_form">Ruangan: <b><?= htmlspecialchars($transaksi['nama_ruangan']) ?></b></p>

    <form method="POST" action="index.php?halaman=transaksi&aksi=edit&id=<?= $transaksi['id_transaksi'] ?>">
        <div class="kelompok_input">
            <label for="nama_pelanggan">Nama pelanggan</label>
            <input type="text" id="nama_pelanggan" name="nama_pelanggan"
                   value="<?= htmlspecialchars($transaksi['nama_pelanggan']) ?>" required>
        </div>

        <div class="kelompok_input">
            <label for="nomor_hp">Nomor HP</label>
            <input type="text" id="nomor_hp" name="nomor_hp"
                   value="<?= htmlspecialchars($transaksi['nomor_hp']) ?>" required>
        </div>

        <div class="kelompok_input">
            <label for="waktu_mulai">Waktu mulai</label>
            <input type="datetime-local" id="waktu_mulai" name="waktu_mulai"
                   value="<?= date('Y-m-d\TH:i', strtotime($transaksi['waktu_mulai'])) ?>" required>
        </div>

        <div class="kelompok_input">
            <label for="durasi_jam">Durasi (jam)</label>
            <input type="number" id="durasi_jam" name="durasi_jam" min="1" max="12"
                   value="<?= $transaksi['durasi_jam'] ?>" required>
        </div>

        <button type="submit" class="tombol tombol_utama tombol_penuh">Simpan Perubahan</button>
    </form>

    <p class="tautan_bawah"><a href="index.php?halaman=transaksi">Kembali ke daftar</a></p>
</div>