<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Halaman Guru</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link href="{{ asset('CSS/stylesHalamanGuru.css?v=1.2') }}" rel="stylesheet" />
    <style>
        .content-section { display: none; }
        .content-section.active { display: block; }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">Halaman Guru</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#" data-target="nilai-siswa">Nilai Siswa</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#" data-target="buat-token">Buat Token</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{ route('beranda') }}" onclick="return confirmBack()">Kembali Ke Beranda</a>
            </div>
        </div>

        <!-- Page content -->
        <div id="page-content-wrapper">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="sidebarToggle">Toggle Menu</button>
                </div>
            </nav>

            <div class="container-fluid mt-4">

                <!-- Nilai Siswa Section -->
                <div id="nilai-siswa" class="content-section active">
                    <h2>Nilai Siswa</h2>

                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <div class="card text-white bg-primary">
                                <div class="card-body">
                                    <h5 class="card-title">Total Siswa</h5>
                                    <p class="card-text fs-4 fw-bold">{{ $totalSiswa }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-success">
                                <div class="card-body">
                                    <h5 class="card-title">Total Pengerjaan</h5>
                                    <p class="card-text fs-4 fw-bold">{{ $totalEvaluasi }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-white bg-info">
                                <div class="card-body">
                                    <h5 class="card-title">Rata-rata Skor</h5>
                                    <p class="card-text fs-4 fw-bold">{{ number_format($rataRataNilai, 1) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <a href="{{ route('guru.export.pdf', ['search' => request('search'), 'kelas_id' => request('kelas_id')]) }}" class="btn btn-danger">Export PDF</a>
                        
                        <a href="{{ route('guru.export.excel', ['search' => request('search'), 'kelas_id' => request('kelas_id')]) }}" class="btn btn-success">Export Excel</a>
                    </div>

                   
                    <div class="d-flex justify-content-between align-items-center mb-3">
                    <form action="{{ route('guru.index') }}" method="GET" class="d-flex" style="gap: 10px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama..." value="{{ request('search') }}">
                        
                        {{-- Ini adalah input tersembunyi untuk menyimpan filter kelas saat mencari nama --}}
                        @if(request('kelas_id'))
                            <input type="hidden" name="kelas_id" value="{{ request('kelas_id') }}">
                        @endif

                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>

                    <form action="{{ route('guru.index') }}" method="GET">
                        <select name="kelas_id" class="form-select" onchange="this.form.submit()">
                            <option value="">Semua Kelas</option>
                            @foreach($kelas as $k)
                                <option value="{{ $k->id }}" {{ request('kelas_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kelas }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>

                    @if(request('search'))
                        <p>Hasil pencarian untuk: <strong>{{ request('search') }}</strong></p>
                    @endif

                    <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>Level</th>
                            <th>Skor</th>
                            <th>Waktu Pengerjaan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($siswas as $siswa)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $siswa->nama }}</td>
                            <td>{{ $siswa->kelas->nama_kelas ?? '-' }}</td>
                            
                            {{-- Kolom Level --}}
                            <td>
                                @if($siswa->level)
                                    <span class="badge rounded-pill bg-dark">Level {{ $siswa->level }}</span>
                                @else
                                    -
                                @endif
                            </td>
                            
                            {{-- Kolom Skor --}}
                            <td>
                                @php
                                    $nilaiAngka = $siswa->nilai->nilai ?? null;
                                    $badgeClass = 'bg-secondary';
                                    if ($nilaiAngka >= 80) $badgeClass = 'bg-success';
                                    elseif ($nilaiAngka >= 60) $badgeClass = 'bg-warning text-dark';
                                    elseif ($nilaiAngka !== null) $badgeClass = 'bg-danger';
                                @endphp
                                <span class="badge {{ $badgeClass }}">{{ $nilaiAngka ?? '-' }}</span>
                            </td>

                            {{-- Kolom Waktu Pengerjaan (Pastikan ada pengecekan $siswa->nilai) --}}
                            <td>
                                {{ $siswa->nilai ? $siswa->nilai->created_at->format('d M Y, H:i') : '-' }}
                            </td>
                            
                            {{-- Kolom Aksi --}}
                            <td>
                                <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data siswa ini beserta semua riwayat nilainya?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Tidak ada data siswa untuk ditampilkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
                </div>

                 <div id="buat-token" class="content-section">
                    <h2>Buat Token Baru Per Kelas</h2>

                    @if(session('token_success'))
                        <div class="alert alert-success">{{ session('token_success') }}</div>
                    @endif

                    <form action="{{ route('token.store') }}" method="POST" class="row g-3 align-items-center">
                        @csrf
                        <div class="col-auto">
                            <label for="kelas_id" class="col-form-label">Pilih Kelas:</label>
                        </div>
                        <div class="col-auto">
                            <select name="kelas_id" id="kelas_id" class="form-select" required>
                                <option value="" disabled selected>-- Pilih Kelas --</option>
                                @foreach($kelas as $k)
                                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-success">Generate Token</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if(session('token_generated'))
    <script>
        alert("Token baru berhasil dibuat:\n\n{{ session('token_generated') }}");
    </script>
    @endif

    <!-- Bootstrap & Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        function confirmBack() {
            return confirm('Yakin ingin kembali ke beranda?');
        }

        document.getElementById("sidebarToggle").addEventListener("click", function () {
            document.getElementById("wrapper").classList.toggle("toggled");
        });

        document.querySelectorAll('[data-target]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('data-target');

                document.querySelectorAll('.content-section').forEach(section => {
                    section.classList.remove('active');
                });

                document.getElementById(targetId).classList.add('active');

                document.querySelectorAll('.list-group a').forEach(a => a.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>
</html>
