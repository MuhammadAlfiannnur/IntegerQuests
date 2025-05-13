<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Beranda</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('/') }}CSS/StyleBeranda.css">
</head>
<body>
    <div class="image_container">
        <img src="{{ asset('/') }}Gambar/halaman guru.png" alt="Menuju Halaman Guru" id="HalGur">
    </div>
    <h1>Media Pembelajaran <br> Matematika Bilangan Bulat <br> Kelas VII SMP/Mts</h1>  
    <div class="image_row">
        <img src="{{ asset('/') }}Gambar/cp.png" alt="Capaian Pelajaran" id="CP">
        <img src="{{ asset('/') }}Gambar/mulai.png" alt="Memulai Media" id="Mulai">
        <img src="{{ asset('/') }}Gambar/informasi.png" alt="Informasi Media" id="Informasi">
    </div>

    <!-- POP UP   -->
    <div class="popup" id="Popup_CP">
        <div class="popup-content">
            <h2>Capaian Pembelajaran</h2>
            <h3 align="justify">&nbsp; Peserta didik dapat membaca, menulis, dan membandingkan bilangan bulat, bilangan rasional dan irasional. Mereka dapat
                menerapkan operasi aritmatika pada bilangan real dan memberikan estimasi/perkiraan dalam menyelesaikan masalah (termasuk berkaitan 
                dengan literasi finansial). <br>&nbsp; Peserta didik dapat menggunakan faktorisasi prima dan pengertian rasio (skala, proporsi, dan laju
                perubahan) dalam menyelesaikan masalah.
            </h3>
            <button class="close-btn" id="tutup-popup1">Tutup</button>
        </div>
    </div>
    <div class="popup" id="Popup_Informasi">
        <div class="popup-content">
            <h2>Informasi Media</h2>
            <h3 align="justify">media Pembelajaran ini dibuat untuk memenuhi persyaratan dalam menyelesaikan Program Strata -1 Pendidikan Komputer dengan Judul</h3>
            <h3 align="center">"Pengembangan Media Pembelajaran Interaktik Topik Bilangan Bulat Kelas VII Dengan Metode Game Based Learning"</h3>
            <h3 align="left">
                Tentang Author
                Nama                : Muhammad Alfiannur<br>
                Dosen Pembimbing 1  : Dra. R. Ati Sukmawati, M.Kom<br>
                Dosen Pembimbing 2  : Novan Alkaf Bahraini Saputra, S.Kom, M.T<br>
                Program Studi       : Pendidkan Komputer<br>
                Email               : alfitaki021@gmail.com
            </h3>
            <button class="close-btn" id="tutup-popup2">Tutup</button>
        </div>
    </div>
    <div class="popup" id="Popup-Login">
        <div class="bg-white p-8 rounded-lg shadow-lg w-80">
            <h3 class="text-2xl font-bold text-center text-gray-800 mb-6">Login Guru</h3>
            <form>
                <div class="mb-4">
                    <label class="block text-gray-800 text-lg font-semibold mb-2" for="username">Username :</label>
                    <input class="w-full px-3 py-2 border border-gray-800 rounded" type="text" id="username" name="username">
                </div>
                <div class="mb-6">
                    <label class="block text-gray-800 text-lg font-semibold mb-2" for="password">Password :</label>
                    <input class="w-full px-3 py-2 border border-gray-800 rounded" type="password" id="password" name="password">
                </div>
                <div class="flex justify-center">
                    <button class="login-btn" id="login">Login</button>
                    <button class="close-btn" id="tutup-popup3">Tutup</button>
                </div>
            </form>
        </div>
    </div>

    <!-- JAVASCRIPT -->
    <script>
        const gambarCP = document.getElementById('CP');
        const gambarInfo = document.getElementById('Informasi');
        const gambarHalGur = document.getElementById('HalGur');
        const popupCp = document.getElementById('Popup_CP');
        const popupInformasi = document.getElementById('Popup_Informasi');
        const popuphalgur = document.getElementById('Popup-Login');
        const tutupPopup1 = document.getElementById('tutup-popup1');
        const tutupPopup2 = document.getElementById('tutup-popup2');
        const tutupPopup3 = document.getElementById('tutup-popup3');

        gambarCP.addEventListener('click', () => {
            popupCp.style.display = 'flex';
        });
        gambarInfo.addEventListener('click', () => {
            popupInformasi.style.display = 'flex';
        });
        gambarHalGur.addEventListener('click', () => {
        popuphalgur.style.display = 'flex'; 
        });

        tutupPopup1.addEventListener('click', () => {
            popupCp.style.display = 'none';
        });
        tutupPopup2.addEventListener('click', () => {
            popupInformasi.style.display = 'none';
        });
        tutupPopup3.addEventListener('click', () => {
            popuphalgur.style.display = 'none';
        });
    </script>
</body>
</html>