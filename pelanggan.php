<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pelanggan</title>
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

    <div class="container-pelanggan">
        <table>
            <tr>
                <th>Nama Pelanggan</th>
                <th>Nomor HP</th>
            </tr>

        </table>

    </div>

    <script src="script.js"></script>
</body>
</html>