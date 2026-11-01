<?php
    include 'koneksi.php';

    $kembali = 'riwayat.php';

    $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

    if (isset($_POST['update'])) {
        $kasir_id    = (int) $_POST['kasir_id'];
        $ps_id       = (int) $_POST['ps_id'];
        $nama_pelanggan     = trim($_POST['nama_pelanggan']);
        $nomor_hp_pelanggan = trim($_POST['nomor_hp_pelanggan']);
        $durasi      = (int) $_POST['durasi_jam'];
        $jam_mulai   = $_POST['jam_mulai'];
        $jam_selesai = $_POST['jam_selesai'];
        $tanggal     = $_POST['tanggal'] . ' ' . $jam_mulai . ':00';
        $total       = hitung_total($koneksi, $ps_id, $durasi);

        $pelanggan_id = cari_atau_buat_pelanggan($koneksi, $nama_pelanggan, $nomor_hp_pelanggan);

        $stmt = mysqli_prepare($koneksi, "UPDATE transaksi SET pelanggan_id=?, ps_id=?, kasir_id=?, tanggal=?, durasi_jam=?, jam_mulai=?, jam_selesai=?, total_biaya=? WHERE id_transaksi=?");
        mysqli_stmt_bind_param($stmt, "iiisissdi", $pelanggan_id, $ps_id, $kasir_id, $tanggal, $durasi, $jam_mulai, $jam_selesai, $total, $id);
        mysqli_stmt_execute($stmt);

        header("Location: $kembali");
        exit;
    }

    $stmt = mysqli_prepare($koneksi, "SELECT t.*, p.nama_pelanggan, p.nomor_hp_pelanggan
                                      FROM transaksi t
                                      JOIN pelanggan p ON p.id_pelanggan = t.pelanggan_id
                                      WHERE t.id_transaksi = ?");
    mysqli_stmt_bind_param($stmt, "i", $id);
    mysqli_stmt_execute($stmt);
    $row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

    if (!$row) {
        header("Location: $kembali");
        exit;
    }

    $kasir_list = mysqli_query($koneksi, "SELECT id_kasir, nama_kasir FROM kasir ORDER BY nama_kasir");
    $ps_list    = mysqli_query($koneksi, "SELECT id_ps, nama_ps, tipe, harga_per_jam FROM konsol ORDER BY id_ps");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rental PS</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-logo">
            Update Transaksi
            <img src="cihuyy.jpg">
        </div>
    </nav>
    
<div class="container">
    

    <form class="form-card" method="POST">
        <label>Nama kasir</label> <br>
        <select name="kasir_id" required>
            <option value="">-- Pilih Kasir --</option>
            <?php while ($k = mysqli_fetch_assoc($kasir_list)) { ?>
                <option value="<?php echo $k['id_kasir']; ?>"><?php echo htmlspecialchars($k['nama_kasir']); ?></option>
            <?php } ?>
        </select> <br>

        <label>Tanggal</label> <br>
        <input type="date" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>" required>
        <br>

        <label>Nama pelanggan</label> <br>
        <input type="text" name="nama_pelanggan" placeholder="nama pelanggan" required><br>
        <label>Nomor HP</label><br>
        <input type="text" name="nomor_hp_pelanggan" placeholder="nomor HP" required><br>
        <label>Nomor PS</label><br> 
        <select name="ps_id" id="ps_id" required>
            <option value="">-- Pilih PS --</option>
            <?php while ($p = mysqli_fetch_assoc($ps_list)) { ?>
                <option value="<?php echo $p['id_ps']; ?>" data-harga="<?php echo (float) $p['harga_per_jam']; ?>">
                    <?php echo $p['id_ps'] . ' - ' . htmlspecialchars($p['nama_ps']) . ' (' . htmlspecialchars($p['tipe']) . ') - Rp' . number_format((float) $p['harga_per_jam'], 0, ',', '.') . '/jam'; ?>
                </option>
            <?php } ?>
        </select> <br> <br>

        <label>Masukan Durasi Main</label> <br>
        <input type="number" name="durasi_jam" id="durasi_jam" min="1" max="24" step="1" value="1" required> <br>
    
        <label>Main Jam Berapa</label> <br>

        <label>mulai</label> <br>
        <input type="time" name="jam_mulai" id="jam_mulai" required><br>
        <label>selesai</label> <br>
        <input type="time" name="jam_selesai" id="jam_selesai" readonly required><br>
        <br>
        
        <label>Total biaya</label> <br>
        <input type="text" id="total" readonly><br>

        <input type="submit" name="update" value="update">
    </form>

    <div class="card-right">
        <h2>Daftar Ruangan PS</h2>
    <p class="subtitle">Pilih ruangan PlayStation</p>

    <div class="ruangan-container">

        <div class="ruangan">
            <h3>PS01</h3>
            <p>PS4</p>
            <p>Rp8.000 / jam</p>
            <span class="game">EA FC 26</span>
            <span class="game">MotoGP 23</span>
            <span class="game">UFC 23</span>
        </div>

        <div class="ruangan">
            <h3>PS02</h3>
            <p>PS4</p>
            <p>Rp8.000 / jam</p>
            <span class="game">Minecraft</span>
            <span class="game">Roblox</span>
            <span class="game">EA FC 26</span>
        </div>

        <div class="ruangan">
            <h3>PS03</h3>
            <p>PS4</p>
            <p>Rp8.000 / jam</p>
            <span class="game">God of War</span>
            <span class="game">Elden Ring</span>
            <span class="game">Dark Souls 3</span>
        </div>

        <div class="ruangan">
            <h3>PS04</h3>
            <p>PS4</p>
            <p>Rp8.000 / jam</p>
            <span class="game">Genshin Impact</span>
            <span class="game">Spider-Man</span>
            <span class="game">A Way Out</span>
        </div>

        <div class="ruangan">
            <h3>PS05</h3>
            <p>PS4</p>
            <p>Rp8.000 / jam</p>
            <span class="game">Tekken 8</span>
            <span class="game">Mortal Kombat</span>
            <span class="game">Battlefield 6</span>
        </div>

        <div class="ruangan">
            <h3>PS06</h3>
            <p>PS5</p>
            <p>Rp12.000 / jam</p>
            <span class="game">Grand Turismo 7</span>
            <span class="game">GTA 5</span>
            <span class="game">NFS Heat</span>
        </div>

        <div class="ruangan">
            <h3>PS07</h3>
            <p>PS5</p>
            <p>Rp12.000 / jam</p>
            <span class="game">Naruto x Boruto 5</span>
            <span class="game">Astrobot</span>
            <span class="game">Horizon</span>
        </div>

        <div class="ruangan">
            <h3>PS08</h3>
            <p>PS5</p>
            <p>Rp12.000 / jam</p>
            <span class="game">God of War</span>
            <span class="game">EA FC 26</span>
            <span class="game">E-Football</span>
        </div>

    </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>