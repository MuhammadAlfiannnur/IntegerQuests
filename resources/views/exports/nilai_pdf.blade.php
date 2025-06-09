<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Data Nilai Siswa</title>
    <style>
        /* Semua gaya CSS diletakkan di sini */
        body { 
            font-family: DejaVu Sans, sans-serif; /* Font yang mendukung banyak karakter, termasuk simbol */
            font-size: 12px;
            margin: 0;
            padding: 0;
        }
        .container {
            padding: 0 40px;
        }
        .table {
            width: 100%;
            border-collapse: collapse; /* Menghilangkan jarak antar border */
            margin-top: 20px;
        }
        .table th, .table td {
            border: 1px solid #ccc; /* Border abu-abu yang lebih lembut */
            padding: 8px;
            text-align: left;
        }
        .table th {
            background-color: #f2f2f2; /* Warna latar header tabel */
            font-weight: bold;
        }
        .header {
            text-align: center;
            margin-bottom: 25px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 11px;
            color: #555;
        }
        .text-center {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Laporan Hasil Evaluasi Siswa</h2>
            <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d F Y, H:i') }}</p>
        </div>

        <table class="table">
            <thead>
                <tr>
                    <th style="width: 5%;" class="text-center">No</th>
                    <th>Nama Siswa</th>
                    <th style="width: 15%;">Kelas</th>
                    <th style="width: 15%;">Level</th>
                    <th style="width: 15%;" class="text-center">Skor</th>
                    <th style="width: 25%;">Waktu Pengerjaan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($nilais as $nilai)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>{{ $nilai->siswa->nama ?? 'Siswa Telah Dihapus' }}</td>
                    <td>{{ $nilai->siswa->kelas->nama_kelas ?? '-' }}</td>
                    <td class="text-center">{{ $nilai->siswa->level ?? '-' }}</td>
                    <td class="text-center">{{ number_format($nilai->nilai, 2) }}</td>
                    <td>{{ $nilai->created_at->format('d M Y, H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data untuk ditampilkan.</td>
                </tr>
                
                @endforelse
            </tbody>
        </table>

    </div>
</body>
</html>