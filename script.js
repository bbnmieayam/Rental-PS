const tanggal = document.getElementById('tanggal');
const durasi = document.getElementById('durasi_jam');
const jamMulai = document.getElementById('jam_mulai');
const jamSelesai = document.getElementById('jam_selesai');

function hitungJamSelesai() {
    if (!tanggal.value || !jamMulai.value || !durasi.value) {
        jamSelesai.value = '';
        return;
    }

    const lama = Number(durasi.value);

    if (!Number.isInteger(lama) || lama < 1 || lama > 24) {
        jamSelesai.value = '';
        return;
    }

    const mulai = new Date(
        `${tanggal.value}T${jamMulai.value}:00`
    );

    mulai.setHours(mulai.getHours() + lama);

    jamSelesai.value =
        String(mulai.getHours()).padStart(2, '0') + ':' +
        String(mulai.getMinutes()).padStart(2, '0');
}

if (tanggal && durasi && jamMulai && jamSelesai) {
    tanggal.addEventListener('change', hitungJamSelesai);
    durasi.addEventListener('input', hitungJamSelesai);
    jamMulai.addEventListener('input', hitungJamSelesai);

    jamMulai.value = new Date().toTimeString().slice(0, 5);
    hitungJamSelesai();
}

document.addEventListener('DOMContentLoaded', function () {
    var ps     = document.getElementById('ps_id');
    var durasi = document.getElementById('durasi_jam');
    var total  = document.getElementById('total');

    function hitung() {
        var harga = ps.options[ps.selectedIndex].getAttribute('data-harga') || 0;
        var jam   = durasi.value || 0;
        total.value = 'Rp ' + (harga * jam).toLocaleString('id-ID');
    }

    ps.addEventListener('change', hitung);
    durasi.addEventListener('input', hitung);

    hitung();
});

document.addEventListener('DOMContentLoaded', function () {
    var ps = document.getElementById('ps_id');

    document.querySelectorAll('.ruangan').forEach(function (kartu) {
        kartu.addEventListener('click', function () {
            var id = parseInt(kartu.querySelector('h3').textContent.replace('PS', ''), 10);
            ps.value = id;
            ps.dispatchEvent(new Event('change'));
        });
    });
});