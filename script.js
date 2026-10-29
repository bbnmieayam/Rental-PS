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

function updateJamDigital() {
    const sekarang = new Date();

    const jam = document.getElementById('jam-digital');
    const tanggalDigital = document.getElementById('tanggal-digital');

    if (!jam || !tanggalDigital) return;

    jam.textContent = sekarang.toLocaleTimeString('id-ID', {
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: false
    });

    tanggalDigital.textContent = sekarang.toLocaleDateString('id-ID', {
        weekday: 'long',
        day: '2-digit',
        month: 'long',
        year: 'numeric'
    });
}

updateJamDigital();
setInterval(updateJamDigital, 1000);
