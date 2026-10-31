<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat pelanggan</title>
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

    <div class="container-riwayat">
        <table class="table-riwayat">
            <tr>
                <th>Nama Kasir</th>
                <th>Tanggal</th>
                <th>Nama Pelanggan</th>
                <th>Nomor HP</th>
                <th>Nomor PS</th>
                <th>Durasi Main</th>
                <th>Mulai</th>
                <th>Selesai</th>
                <th>Aksi</th>
            </tr>
        </table> 
    </div>

    <script src="script.js"></script>
</body>
</html>