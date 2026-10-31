<?php
    include 'koneksi.php';

    if (isset($_POST['simpan'])) {
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

        $stmt = mysqli_prepare($koneksi, "INSERT INTO transaksi (pelanggan_id, ps_id, kasir_id, tanggal, durasi_jam, jam_mulai, jam_selesai, total_biaya) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "iiisissd", $pelanggan_id, $ps_id, $kasir_id, $tanggal, $durasi, $jam_mulai, $jam_selesai, $total);
        mysqli_stmt_execute($stmt);

        header("Location: home.php");
        exit;
    }

    $kasir_list = mysqli_query($koneksi, "SELECT id_kasir, nama_kasir FROM kasir ORDER BY nama_kasir");
    $ps_list    = mysqli_query($koneksi, "SELECT id_ps, nama_ps, tipe, harga_per_jam FROM konsol ORDER BY id_ps");

    $sql_read = "SELECT t.*, p.nama_pelanggan, p.nomor_hp_pelanggan, k.nama_kasir, c.nama_ps, c.tipe
                 FROM transaksi t
                 JOIN pelanggan p ON p.id_pelanggan = t.pelanggan_id
                 JOIN konsol c ON c.id_ps = t.ps_id
                 JOIN kasir k ON k.id_kasir = t.kasir_id
                 ORDER BY t.tanggal DESC";
    $result = mysqli_query($koneksi, $sql_read);
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
            Rental PS Cihuyy
        </div>

        <div class="navbar-clock">
            <div id="jam-digital">00:00:00</div>
            <div id="tanggal-digital">Memuat tanggal...</div>
        </div>
        
        <ul class="navbar-menu">
            <li><a href="home.php"><span>🏠</span> Beranda</a></li>
            <li><a href="pelanggan.php"><span>♙</span> Data Pelanggan</a></li>
            <li><a href="riwayat.php"><span>◷</span> Riwayat</a></li>

        </ul>
    </nav>
    
<div class="container">
    

    <form class="form-card" method="POST">
        <label style="color:  #16a34a;">Nama kasir</label> <br>
        <select name="kasir_id" required>
            <option value="">-- Pilih Kasir --</option>
            <?php while ($k = mysqli_fetch_assoc($kasir_list)) { ?>
                <option value="<?php echo $k['id_kasir']; ?>"><?php echo htmlspecialchars($k['nama_kasir']); ?></option>
            <?php } ?>
        </select> <br>

        Tanggal <br>
        <input type="date" name="tanggal" id="tanggal" value="<?php echo date('Y-m-d'); ?>" required>
        <br>

        Nama pelanggan <br>
        <input type="text" name="nama_pelanggan" placeholder="nama pelanggan" required><br>
        Nomor HP<br>
        <input type="text" name="nomor_hp_pelanggan" placeholder="nomor HP" required><br>
        <label style="color:  #16a34a;">Nomor PS</label><br> 
        <select name="ps_id" id="ps_id" required>
            <option value="">-- Pilih PS --</option>
            <?php while ($p = mysqli_fetch_assoc($ps_list)) { ?>
                <option value="<?php echo $p['id_ps']; ?>" data-harga="<?php echo (float) $p['harga_per_jam']; ?>">
                    <?php echo $p['id_ps'] . ' - ' . htmlspecialchars($p['nama_ps']) . ' (' . htmlspecialchars($p['tipe']) . ') - Rp' . number_format((float) $p['harga_per_jam'], 0, ',', '.') . '/jam'; ?>
                </option>
            <?php } ?>
        </select> <br> <br>

        Masukan Durasi Main <br>
        <input type="number" name="durasi_jam" id="durasi_jam" min="1" max="24" step="1" value="1" required> <br>
    
         Main Jam Berapa <br>

        mulai <br>
        <input type="time" name="jam_mulai" id="jam_mulai" required><br>
        selesai <br>
        <input type="time" name="jam_selesai" id="jam_selesai" readonly required><br>
        <br>
        
        Total biaya <br>
        <input type="text" id="total" readonly><br>

        <input type="submit" name="simpan" value="Simpan">
    </form>

    <div class="card-right">
        <h2>Daftar Ruangan PS</h2>
    <p class="subtitle">Pilih ruangan PlayStation</p>

    <div class="ruangan-container">

        <div class="ruangan">
            <h3>PS01</h3>
            <p>PS4</p>
            <p>Rp8.000 / jam</p>
            <span class="status tersedia">Tersedia</span>
        </div>

        <div class="ruangan">
            <h3>PS02</h3>
            <p>PS4</p>
            <p>Rp8.000 / jam</p>
            <span class="status tersedia">Tersedia</span>
        </div>

        <div class="ruangan">
            <h3>PS03</h3>
            <p>PS4</p>
            <p>Rp8.000 / jam</p>
            <span class="status tersedia">Tersedia</span>
        </div>

        <div class="ruangan">
            <h3>PS04</h3>
            <p>PS4</p>
            <p>Rp8.000 / jam</p>
            <span class="status tersedia">Tersedia</span>
        </div>

        <div class="ruangan">
            <h3>PS05</h3>
            <p>PS4</p>
            <p>Rp8.000 / jam</p>
            <span class="status tersedia">Tersedia</span>
        </div>

        <div class="ruangan">
            <h3>PS06</h3>
            <p>PS5</p>
            <p>Rp12.000 / jam</p>
            <span class="status tersedia">Tersedia</span>
        </div>

        <div class="ruangan">
            <h3>PS07</h3>
            <p>PS5</p>
            <p>Rp12.000 / jam</p>
            <span class="status tersedia">Tersedia</span>
        </div>

        <div class="ruangan">
            <h3>PS08</h3>
            <p>PS5</p>
            <p>Rp12.000 / jam</p>
            <span class="status tersedia">Tersedia</span>
        </div>

    </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>