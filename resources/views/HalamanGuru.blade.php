<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Halaman Guru</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}" />
    <link href="{{ asset('css/stylesHalamanGuru.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#" data-target="data-siswa">Data Siswa</a>
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

                    <div class="mb-3">
                        <a href="{{ route('guru.export.pdf') }}" class="btn btn-danger">Export PDF</a>
                    </div>

                    <!-- Form Pencarian -->
                    <form action="{{ route('guru.index') }}" method="GET" class="mb-3 d-flex" style="gap: 10px; max-width: 400px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama atau nilai..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>
                    @if(request('search'))
                        <p>Hasil pencarian untuk: <strong>{{ request('search') }}</strong></p>
                    @endif

                    @forelse($nilais as $nilai)
                        @if($loop->first)
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Kelas</th>
                                        <th>Nilai</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                        @endif
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $nilai->siswa->nama }}</td>
                            <td>{{ $nilai->siswa->kelas->nama_kelas ?? '-' }}</td>
                            <td>{{ $nilai->nilai }}</td>
                            <td>
                                <form action="{{ route('guru.nilai.destroy', $nilai->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data nilai ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @if($loop->last)
                                </tbody>
                            </table>
                        @endif
                    @empty
                        <p>Tidak ada data nilai siswa.</p>
                    @endforelse
                </div>

                <!-- Data Siswa Section -->
                <div id="data-siswa" class="content-section">
                    <h2>Data Siswa</h2>

                    @if($siswas->count())
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Kelas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswas as $s)
                                    <tr>
                                        <td>{{ $s->id }}</td>
                                        <td>{{ $s->nama }}</td>
                                        <td>{{ $s->kelas->nama_kelas ?? '-' }}</td>
                                        <td>
                                            <form action="{{ route('siswa.destroy', $s->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p>Tidak ada data siswa untuk ditampilkan.</p>
                    @endif
                </div>

                <!-- Buat Token Section -->
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
