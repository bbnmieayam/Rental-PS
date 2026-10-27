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

        <ul class="navbar-menu">
            <li><a href="#home">Beranda</a></li>
            <li><a href="#pelanggan">Data Pelanggan</a></li>
            <li><a href="#riwayat">Riwayat</a></li>

        </ul>
    </nav>
<div class="container">
    

    <div class="form-card">
        <label for="pilihan" style="color:  #16a34a;">Nama kasir</label> <br>
        <select name="pilihan" id="id_kasir">
            <option value="Agus">Agus</option>
            <option value="Budi">Budi</option>
            <option value="Cinta">Cinta</option>
        </select> <br>

        Tanggal <br>
        <input type="date" name="tanggal" placeholder="tanggal" required>
        <br>

        Nama pelanggan <br>
        <input type="text" name="nama_pelanggan" placeholder="nama pelanggan" required><br>
        Nomor HP<br>
        <input type="number" name="nomor_hp_pelanggan" placeholder="nomor HP" required><br>
        <label for="pilihan" style="color:  #16a34a;">Nomor PS</label><br> 
        <select name="pilihan" id="PS"> 
            <option value="PS01">PS01 - PS4 - Rp8000/jam</option>
            <option value="PS02">PS02 - PS4 - Rp8000/jam</option>
            <option value="PS03">PS03 - PS4 - Rp8000/jam</option>
            <option value="PS04">PS04 - PS4 - Rp8000/jam</option>
            <option value="PS05">PS05 - PS4 - Rp8000/jam</option>
            <option value="PS06">PS05 - PS5 - Rp12000/jam</option>
            <option value="PS07">PS05 - PS5 - Rp12000/jam</option>
            <option value="PS08">PS05 - PS5 - Rp12000/jam</option>
        </select> <br> <br>
    
         Main Jam Berapa <br>

        mulai <br>
        <input type="time" name="jam_mulai" placeholder="Masukkan jam mulai" required><br>
        selesai <br>
        <input type="time" name="jam_selesai" placeholder="Masukkan jam selesai" required><br>
        <br>
        <input type="submit" name="simpan" required>
    </div>

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

</body>
</html>