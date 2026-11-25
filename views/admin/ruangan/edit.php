<div class="kartu_form">
    <h2>Edit Ruangan</h2>

    <form method="POST" action="index.php?halaman=ruangan_edit&id=<?= $id_ruangan ?>">
        <div class="kelompok_input">
            <label for="nama_ruangan">Nama ruangan</label>
            <input type="text" id="nama_ruangan" name="nama_ruangan"
                   value="<?= htmlspecialchars($nama_ruangan) ?>" required>
        </div>

        <div class="kelompok_input">
            <label for="jenis_konsol">Jenis konsol</label>
            <select id="jenis_konsol" name="jenis_konsol">
                <option value="PS4" <?php if ($jenis_konsol == 'PS4') echo 'selected'; ?>>PS4</option>
                <option value="PS5" <?php if ($jenis_konsol == 'PS5') echo 'selected'; ?>>PS5</option>
            </select>
        </div>

        <div class="kelompok_input">
            <label for="harga_per_jam">Harga per jam (Rp)</label>
            <input type="number" id="harga_per_jam" name="harga_per_jam" min="1"
                   value="<?= htmlspecialchars($harga_per_jam) ?>" required>
        </div>

        <div class="kelompok_input">
            <label for="status">Status</label>
            <select id="status" name="status">
                <option value="tersedia" <?php if ($status == 'tersedia') echo 'selected'; ?>>tersedia</option>
                <option value="tidak tersedia" <?php if ($status == 'tidak tersedia') echo 'selected'; ?>>tidak tersedia</option>
            </select>
        </div>

        <button type="submit" class="tombol tombol_utama tombol_penuh">Simpan Perubahan</button>
    </form>

    <p class="tautan_bawah"><a href="index.php?halaman=ruangan">Kembali</a></p>
</div>