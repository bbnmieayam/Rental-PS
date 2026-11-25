<div class="kartu_form">
    <h2>Login</h2>
    <p class="keterangan_form">Masuk untuk booking ruangan PS.</p>

    <form method="POST" action="index.php?halaman=login">
        <div class="kelompok_input">
            <label for="nama_pengguna">Nama pengguna</label>
            <input type="text" id="nama_pengguna" name="nama_pengguna"
                   value="<?= htmlspecialchars($nama_pengguna_lama) ?>"
                   autocomplete="username" required autofocus>
        </div>

        <div class="kelompok_input">
            <label for="kata_sandi">Kata sandi</label>
            <input type="password" id="kata_sandi" name="kata_sandi"
                   autocomplete="current-password" required>
        </div>

        <button type="submit" class="tombol tombol_utama tombol_penuh">Login</button>
    </form>

    <p class="tautan_bawah">Belum punya akun? <a href="index.php?halaman=daftar">Daftar</a></p>
</div>