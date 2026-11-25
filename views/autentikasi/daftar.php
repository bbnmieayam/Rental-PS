<div class="kartu_form">
    <h2>Daftar Akun</h2>
    <p class="keterangan_form">Buat akun untuk mulai booking.</p>

    <form method="POST" action="index.php?halaman=daftar">
        <div class="kelompok_input">
            <label for="nama_lengkap">Nama lengkap</label>
            <input type="text" id="nama_lengkap" name="nama_lengkap"
                   value="<?= htmlspecialchars($nama_lengkap_lama) ?>" required autofocus>
        </div>

        <div class="kelompok_input">
            <label for="nama_pengguna">Nama pengguna</label>
            <input type="text" id="nama_pengguna" name="nama_pengguna"
                   value="<?= htmlspecialchars($nama_pengguna_lama) ?>"
                   autocomplete="username" required>
            <small>4-30 karakter: huruf, angka, atau garis bawah.</small>
        </div>

        <div class="kelompok_input">
            <label for="kata_sandi">Kata sandi</label>
            <input type="password" id="kata_sandi" name="kata_sandi"
                   autocomplete="new-password" required>
            <small>Minimal 6 karakter.</small>
        </div>

        <div class="kelompok_input">
            <label for="konfirmasi_sandi">Konfirmasi kata sandi</label>
            <input type="password" id="konfirmasi_sandi" name="konfirmasi_sandi"
                   autocomplete="new-password" required>
        </div>

        <button type="submit" class="tombol tombol_utama tombol_penuh">Daftar</button>
    </form>

    <p class="tautan_bawah">Sudah punya akun? <a href="index.php?halaman=login">Login</a></p>
</div>