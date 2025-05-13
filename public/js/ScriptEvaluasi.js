// Inisialisasi variabel
const semuaSoal = document.querySelectorAll('.soal');
const menuNomor = document.getElementById('nomor-soal').querySelectorAll('a');
let soalSaatIni = 1;
let namaSiswa = '';

// Fungsi untuk memulai evaluasi setelah input nama
function mulaiEvaluasi() {
    const inputNama = document.getElementById('nama-siswa');
    if (inputNama.value.trim() === '') {
        alert('Silakan masukkan nama Anda terlebih dahulu!');
        return;
    }
    
    namaSiswa = inputNama.value.trim();

    //tampilkan nama
    document.getElementById('nama-tampil').textContent = `Nama: ${namaSiswa}`;

    // Sembunyikan form input nama, tampilkan soal
    document.getElementById('form-nama').classList.add('hidden');
    document.getElementById('evaluasi-form').classList.remove('hidden');

    // Masukkan nama ke input hidden agar bisa dikirim
    document.getElementById('nama-hidden').value = namaSiswa;
    
    updateStatusJawaban();
}

// Fungsi untuk menampilkan soal tertentu
function tampilkanSoal(nomor) {
    semuaSoal.forEach(soal => soal.style.display = 'none');
    document.getElementById(`soal${nomor}`).style.display = 'block';

    menuNomor.forEach(link => link.classList.remove('active'));
    menuNomor[nomor - 1].classList.add('active');

    soalSaatIni = nomor;
    updateTombolNavigasi();
}

// Fungsi untuk pindah ke soal berikutnya
function selanjutnya(nomorSaatIni) {
    if (nomorSaatIni < semuaSoal.length) {
        tampilkanSoal(nomorSaatIni + 1);
    }
}

// Fungsi untuk pindah ke soal sebelumnya
function sebelumnya(nomorSaatIni) {
    if (nomorSaatIni > 1) {
        tampilkanSoal(nomorSaatIni - 1);
    }
}

// Fungsi untuk langsung ke soal tertentu
function gotoSoal(nomor) {
    tampilkanSoal(nomor);
}

// Fungsi untuk update tombol navigasi
function updateTombolNavigasi() {
    semuaSoal.forEach((soal, index) => {
        const nomor = index + 1;
        const tombolKembali = document.getElementById(`kembali${nomor}`);
        const tombolLanjut = document.getElementById(`lanjut${nomor}`);

        if (tombolKembali) {
            tombolKembali.disabled = soalSaatIni === 1;
        }
        if (tombolLanjut) {
            tombolLanjut.style.display = soalSaatIni === semuaSoal.length ? 'none' : 'inline-block';
        }
    });
}

// Fungsi untuk update status jawaban di menu nomor soal
function updateStatusJawaban() {
    menuNomor.forEach((link, index) => {
        const nomorSoal = index + 1;
        const jawaban = document.querySelector(`input[name="jawaban${nomorSoal}"]:checked`);
        
        if (jawaban) {
            link.classList.add('answered');
        } else {
            link.classList.remove('answered');
        }
    });
}

// Event listener untuk setiap pilihan jawaban
document.querySelectorAll('input[type="radio"]').forEach(radio => {
    radio.addEventListener('change', function() {
        updateStatusJawaban();
    });
});

// Fungsi untuk validasi form sebelum dikirim
function validasiForm() {
    let semuaTerjawab = true;
    
    for (let i = 1; i <= 20; i++) {
        const jawaban = document.querySelector(`input[name="jawaban${i}"]:checked`);
        if (!jawaban) {
            semuaTerjawab = false;
            tampilkanSoal(i);
            alert(`Soal nomor ${i} belum dijawab. Silakan pilih jawaban terlebih dahulu.`);
            break;
        }
    }
    
    if (semuaTerjawab) {
        document.getElementById('confirm-modal').style.display = 'block';
    }
}

// Fungsi untuk menutup modal
function tutupModal() {
    document.getElementById('confirm-modal').style.display = 'none';
}

// Fungsi untuk mengirim jawaban
function kirimJawaban() {
    tutupModal();
    document.getElementById('evaluasi-form').submit();
}

// Inisialisasi awal
document.addEventListener('DOMContentLoaded', function() {
    updateTombolNavigasi();
    tampilkanSoal(1);
});