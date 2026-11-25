<div class="kartu_form">
    <h2>Tambah Transaksi</h2>
    <p class="keterangan_form">Input transaksi pelanggan yang datang langsung.</p>

    <form method="POST" action="index.php?halaman=transaksi_tambah">
        <div class="kelompok_input">
            <label for="id_ruangan">Ruangan</label>
            <select id="id_ruangan" name="id_ruangan" required>
                <option value="">-- Pilih ruangan --</option>
                <?php foreach ($daftar_ruangan as $ruangan) { ?>
                    <option value="<?= $ruangan['id_ruangan'] ?>"
                        <?php if ($ruangan['id_ruangan'] == $id_ruangan_lama) { echo 'selected'; } ?>>
                        <?= htmlspecialchars($ruangan['nama_ruangan']) ?> (<?= htmlspecialchars($ruangan['jenis_konsol']) ?>)
                        - Rp <?= number_format($ruangan['harga_per_jam'], 0, ',', '.') ?>/jam
                    </option>
                <?php } ?>
            </select>
        </div>

        <div class="kelompok_input">
            <label for="nama_pelanggan">Nama pelanggan</label>
            <input type="text" id="nama_pelanggan" name="nama_pelanggan"
                   value="<?= htmlspecialchars($nama_pelanggan_lama) ?>" required>
        </div>

        <div class="kelompok_input">
            <label for="nomor_hp">Nomor HP</label>
            <input type="text" id="nomor_hp" name="nomor_hp"
                   value="<?= htmlspecialchars($nomor_hp_lama) ?>" required>
        </div>

        <div class="kelompok_input">
            <label for="waktu_mulai">Waktu mulai</label>
            <input type="datetime-local" id="waktu_mulai" name="waktu_mulai"
                   value="<?= htmlspecialchars($waktu_mulai_lama) ?>" required>
        </div>

        <div class="kelompok_input">
            <label for="durasi_jam">Durasi (jam)</label>
            <input type="number" id="durasi_jam" name="durasi_jam" min="1" max="12"
                   value="<?= $durasi_jam_lama ?>" required>
        </div>

        <button type="submit" class="tombol tombol_utama tombol_penuh">Simpan</button>
    </form>

    <p class="tautan_bawah"><a href="index.php?halaman=transaksi">Kembali ke daftar</a></p>
</div>