<?php
    include 'koneksi.php';
 
    $sql_read = "SELECT t.*, p.nama_pelanggan, p.nomor_hp_pelanggan, k.nama_kasir, c.nama_ps, c.tipe
                 FROM transaksi t
                 JOIN pelanggan p ON p.id_pelanggan = t.pelanggan_id
                 JOIN konsol c ON c.id_ps = t.ps_id
                 JOIN kasir k ON k.id_kasir = t.kasir_id
                 ORDER BY t.tanggal DESC, t.jam_mulai DESC";
    $result = mysqli_query($koneksi, $sql_read);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat pelanggan</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <nav class="navbar">
        <div class="navbar-logo">
            Kasir Rental PS Cihuyy
        </div>
        
        <ul class="navbar-menu">
            <li><a href="home.php"><i class="bi bi-house-door-fill"></i> Beranda</a></li>
            <li><a href="pelanggan.php"><i class="bi bi-people-fill"></i> Data Pelanggan</a></li>
            <li><a href="riwayat.php"><i class="bi bi-clock-history"></i> Riwayat</a></li>
        </ul>

    </nav>

    <div class="container-riwayat">
        <table>
            <tr>
                <th>Nama Kasir</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Nomor HP</th>
                <th>Nomor PS</th>
                <th>Durasi Main</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Total Biaya</th>
                <th>Aksi</th>
            </tr>
       

  <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['nama_kasir']); ?></td>
                <td><?php echo date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                <td><?php echo htmlspecialchars($row['nomor_hp_pelanggan']); ?></td>
                <td><?php echo $row['ps_id'] . ' - ' . htmlspecialchars($row['nama_ps']) . ' (' . htmlspecialchars($row['tipe']) . ')'; ?></td>
                <td><?php echo (int) $row['durasi_jam']; ?> jam</td>
                <td><?php echo substr($row['jam_mulai'], 0, 5); ?></td>
                <td><?php echo substr($row['jam_selesai'], 0, 5); ?></td>
                <td>Rp <?php echo number_format($row['total_biaya'], 0, ',', '.'); ?></td>
                <td>
                    <a href="edit.php?id=<?php echo $row['id_transaksi']; ?>">Edit</a> |
                    <a href="hapus.php?id=<?php echo $row['id_transaksi']; ?>" onclick="return confirm('Yakin hapus transaksi ini?')">Hapus</a>
                </td>
            </tr>
            <?php } ?>

            <?php if (mysqli_num_rows($result) === 0) { ?>
            <tr>
                <td colspan="10" style="text-align:center;">Belum ada transaksi.</td>
            </tr>
            <?php } ?>
        </table>
    </div>

    <script src="script.js"></script>
</body>
</html>