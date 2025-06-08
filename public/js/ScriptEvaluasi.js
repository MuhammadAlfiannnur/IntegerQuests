// FILE: ScriptEvaluasi.js (Versi Final Lengkap)

document.addEventListener("DOMContentLoaded", function() {
    // Event listener ini akan berjalan setelah semua elemen halaman dimuat.
    // Kita pasang listener untuk semua pilihan jawaban.
    semuaPilihanJawaban.forEach(radio => {
        radio.addEventListener('change', updateStatusJawaban);
    });
});

// --- Inisialisasi Variabel Global ---
const semuaSoal = document.querySelectorAll('.soal'); // Mengambil semua div soal
const semuaNomorNav = document.querySelectorAll('.menu-soal a'); // Mengambil semua link nomor
const semuaPilihanJawaban = document.querySelectorAll('input[type="radio"]'); // Mengambil semua radio button
const formEvaluasi = document.getElementById('evaluasi-form');
const formNama = document.getElementById('form-nama');
const modalKonfirmasi = document.getElementById('confirm-modal');

let currentIndex = 0; // Penanda soal yang sedang aktif (dimulai dari 0)
let timerInterval; // Variabel untuk menyimpan timer

// --- Fungsi Utama ---

/**
 * Fungsi untuk memulai evaluasi, dipanggil oleh tombol "Mulai Evaluasi".
 */
function mulaiEvaluasi() {
    // const namaSiswaInput = document.getElementById('nama-siswa');
    // if (namaSiswaInput.value.trim() === '') {
    //     alert('Nama tidak boleh kosong!');
    //     return;
    // }

    // const namaSiswa = namaSiswaInput.value.trim();
    // document.getElementById('nama-hidden').value = namaSiswa;
    // document.getElementById('nama-tampil').innerText = 'Nama: ' + namaSiswa;

    // formNama.classList.add('hidden');
    // formEvaluasi.classList.remove('hidden');

    // // Tampilkan soal pertama (indeks 0) setelah evaluasi dimulai
    // showSoal(0);

    // // Jalankan timer 30 menit
    // const tigaPuluhMenit = 60 * 30;
    // startTimer(tigaPuluhMenit);

    const namaSiswaInput = document.getElementById('nama-siswa');
    const namaSiswa = namaSiswaInput.value.trim();

    if (namaSiswa === '') {
        alert('Nama tidak boleh kosong!');
        return;
    }

    // Ambil CSRF token dari meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Kirim data nama ke server untuk divalidasi
    fetch(CekNamaSiswaUrl, { // <-- Gunakan variabel global, bukan string manual
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ nama: namaSiswa })
    })
    .then(response => response.json())
    .then(data => {
        if (data.exists) {
            // JIKA NAMA ADA, LANJUTKAN EVALUASI
            document.getElementById('nama-hidden').value = namaSiswa;
            document.getElementById('siswa-id-hidden').value = data.siswa_id; // Simpan ID siswa
            document.getElementById('nama-tampil').innerText = 'Nama: ' + namaSiswa;

            formNama.classList.add('hidden');
            formEvaluasi.classList.remove('hidden');

            showSoal(0);
            const tigaPuluhMenit = 60 * 30;
            startTimer(tigaPuluhMenit);

        } else {
            // JIKA NAMA TIDAK ADA, TAMPILKAN ALERT
            alert('Nama tidak ditemukan. Silakan selesaikan level sebelumnya terlebih dahulu!');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat memeriksa nama. Silakan coba lagi.');
    });
}

/**
 * Fungsi inti untuk menampilkan soal berdasarkan urutan tampilannya (indeks 0-19).
 * @param {number} index - Urutan soal yang ingin ditampilkan.
 */
function showSoal(index) {
    // Pastikan indeks berada dalam rentang yang valid
    if (index < 0 || index >= semuaSoal.length) {
        return;
    }

    // Sembunyikan semua div soal
    semuaSoal.forEach(soal => soal.style.display = 'none');

    // Hapus status 'active' dari semua nomor di navigasi
    semuaNomorNav.forEach(nomor => nomor.classList.remove('active'));

    // Tampilkan div soal yang sesuai dengan indeks
    semuaSoal[index].style.display = 'block';

    // Beri status 'active' pada nomor navigasi yang sesuai
    semuaNomorNav[index].classList.add('active');

    // Perbarui indeks saat ini
    currentIndex = index;

    // Logika untuk menampilkan tombol submit
    const submitWrapper = document.getElementById('submit-wrapper');
    if (index === semuaSoal.length - 1) { 
        submitWrapper.style.display = 'block';
    } else {
        submitWrapper.style.display = 'none';
    }
}

// --- Fungsi Navigasi ---

function gotoSoal(index) {
    showSoal(index);
}

function selanjutnya() {
    if (currentIndex < semuaSoal.length - 1) {
        showSoal(currentIndex + 1);
    }
}

function sebelumnya() {
    if (currentIndex > 0) {
        showSoal(currentIndex - 1);
    }
}

// --- Fungsi Timer ---

/**
 * Fungsi untuk memulai countdown timer.
 * @param {number} durationInSeconds - Durasi timer dalam detik.
 */
function startTimer(durationInSeconds) {
    let timer = durationInSeconds;
    const display = document.getElementById('timer-display');

    timerInterval = setInterval(function () {
        let minutes = parseInt(timer / 60, 10);
        let seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        display.textContent = "Waktu Tersisa: " + minutes + ":" + seconds;

        if (--timer < 0) {
            clearInterval(timerInterval);
            alert("Waktu habis! Jawaban Anda akan dikirim secara otomatis.");
            kirimJawaban(); // Kirim form secara otomatis
        }
    }, 1000);
}

// --- Fungsi Tambahan & Validasi ---

function updateStatusJawaban() {
    semuaSoal.forEach((soalDiv, index) => {
        const soalId = soalDiv.id.replace('soal', '');
        const jawabanTerpilih = document.querySelector(`input[name="jawaban${soalId}"]:checked`);

        if (jawabanTerpilih) {
            semuaNomorNav[index].classList.add('answered');
        } else {
            semuaNomorNav[index].classList.remove('answered');
        }
    });
}

function validasiForm() {
    for (let i = 0; i < semuaSoal.length; i++) {
        const soalDiv = semuaSoal[i];
        const soalId = soalDiv.id.replace('soal', '');
        const jawaban = document.querySelector(`input[name="jawaban${soalId}"]:checked`);

        if (!jawaban) {
            alert(`Soal nomor ${i + 1} belum dijawab.`);
            showSoal(i);
            return;
        }
    }
    modalKonfirmasi.style.display = 'flex';
}

function tutupModal() {
    modalKonfirmasi.style.display = 'none';
}

function kirimJawaban() {
    formEvaluasi.submit();
}