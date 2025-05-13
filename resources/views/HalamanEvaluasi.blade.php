<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluasi Bilangan Bulat</title>
    <link rel="stylesheet" href="{{ asset('css/StyleEvaluasi.css') }}">
</head>
<body>
    <div class="container">
        <div class="soal-area">
            <h1>Evaluasi Bilangan Bulat</h1>
            
            <!-- Form input nama siswa -->
            <div class="form-nama" id="form-nama">
                <label for="nama-siswa">Masukkan Nama Anda:</label>
                <input type="text" id="nama-siswa" required placeholder="Nama Lengkap">
                <button type="button" onclick="mulaiEvaluasi()">Mulai Evaluasi</button>
            </div>
            
            <!-- Form evaluasi (awalnya disembunyikan) -->
            <form id="evaluasi-form" class="hidden" action="{{ route('submit.evaluasi') }}" method="POST">
                @csrf
                <input type="hidden" name="nama" id="nama-hidden">
                <div id="nama-tampil" style="font-weight: bold; margin-bottom: 15px;"></div>
                
                <!-- Daftar soal-soal -->
                @foreach($soal as $id => $s)
                <div class="soal" id="soal{{$id}}">
                    <h3>Soal {{ $loop->iteration }}</h3>
                    <p>{{ $s['pertanyaan'] }}</p>
                    
                    @foreach(['a','b','c','d'] as $option)
                    <div class="pilihan">
                        <input type="radio" id="soal{{$id}}_{{$option}}" 
                               name="jawaban{{$id}}" value="{{$option}}" required>
                        <label for="soal{{$id}}_{{$option}}">
                            {{ strtoupper($option) }}. {{ $s['pilihan'][$option] }}
                        </label>
                    </div>
                    @endforeach
                    
                    <div class="navigation">
                        @if($loop->first)
                            <button type="button" id="lanjut{{$id}}" onclick="selanjutnya({{$id}})">Lanjut</button>
                        @elseif($loop->last)
                            <button type="button" id="kembali{{$id}}" onclick="sebelumnya({{$id}})">Kembali</button>
                            <button type="button" onclick="validasiForm()">Kirim Jawaban</button>
                        @else
                            <button type="button" id="kembali{{$id}}" onclick="sebelumnya({{$id}})">Kembali</button>
                            <button type="button" id="lanjut{{$id}}" onclick="selanjutnya({{$id}})">Lanjut</button>
                        @endif
                    </div>
                </div>
                @endforeach
            </form>
        </div>
        
        <div class="menu-soal">
            <h3>Nomor Soal</h3>
            <ul id="nomor-soal">
                @foreach($soal as $id => $s)
                <li><a href="#soal{{$id}}" data-nomor="{{$id}}" onclick="gotoSoal({{$id}})" class="{{ $loop->first ? 'active' : '' }}">{{ $loop->iteration }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>

    <!-- Modal Konfirmasi -->
    <div id="confirm-modal" class="modal">
        <div class="modal-content">
            <h3>Konfirmasi Pengiriman</h3>
            <p>Apakah Anda yakin ingin mengirim jawaban? Pastikan semua soal telah dijawab.</p>
            <div class="modal-buttons">
                <button class="confirm-btn" onclick="kirimJawaban()">Ya, Kirim</button>
                <button class="cancel-btn" onclick="tutupModal()">Batal</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/ScriptEvaluasi.js') }}"></script>
</body>
</html>