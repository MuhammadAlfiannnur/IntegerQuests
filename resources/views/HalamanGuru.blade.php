<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Halaman Guru</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="{{ asset('css/stylesHalamanGuru.css') }}" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .content-section {
            display: none;
        }

        .content-section.active {
            display: block;
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">
        <!-- Sidebar -->
        <div class="border-end bg-white" id="sidebar-wrapper">
            <div class="sidebar-heading border-bottom bg-light">Halaman Guru</div>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#" data-target="nilai-siswa">Nilai Siswa</a>
                {{-- <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#" data-target="hasil-evaluasi">Hasil Evaluasi</a> --}}
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#" data-target="data-siswa">Data Siswa</a>
                <a class="list-group-item list-group-item-action list-group-item-light p-3" href="{{ route('beranda') }}" onclick="return confirmBack()" class="btn btn-secondary">Kembali Ke Beranda</a>
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
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="mb-3">
                        <a href="{{ route('guru.export.pdf') }}" class="btn btn-danger">Export PDF</a>
                    </div>

                    {{-- Form Pencarian --}}
                    <form action="{{ route('guru.index') }}" method="GET" class="mb-3 d-flex" style="gap: 10px; max-width: 400px;">
                        <input type="text" name="search" class="form-control" placeholder="Cari nama atau nilai..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-primary">Cari</button>
                    </form>

                    @if(request('search'))
                        <p>Hasil pencarian untuk: <strong>{{ request('search') }}</strong></p>
                    @endif

                    @if($nilais->count())
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama Siswa</th>
                                <th>Nilai</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($nilais as $nilai)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $nilai->siswa->nama }}</td>
                                    <td>{{ $nilai->nilai }}</td>
                                    <td>
                                        <!-- Menghapus data nilai -->
                                        <form action="{{ route('guru.nilai.destroy', $nilai->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data nilai ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>

                <!-- Data Siswa Section -->
                <div id="data-siswa" class="content-section">
                    <h2>Data Siswa</h2>

                    <div class="container mt-5">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswas as $siswa)
                                <tr>
                                    <td>{{ $siswa->id }}</td>
                                    <td>{{ $siswa->nama }}</td>
                                    <td>
                                        <!-- Menghapus data siswa -->
                                        <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data siswa ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap & Script -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script>
        // Konfirmasi untuk kembali ke beranda
        function confirmBack() {
            return confirm('Yakin ingin kembali ke beranda?');
        }

        // Toggle sidebar
        document.getElementById("sidebarToggle").addEventListener("click", function () {
            document.getElementById("wrapper").classList.toggle("toggled");
        });

        // Data-target menu switching
        document.querySelectorAll('[data-target]').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('data-target');

                // Sembunyikan semua konten
                document.querySelectorAll('.content-section').forEach(section => {
                    section.classList.remove('active');
                });

                // Tampilkan konten yang dipilih
                document.getElementById(targetId).classList.add('active');

                // (Opsional) Highlight menu aktif
                document.querySelectorAll('.list-group a').forEach(a => a.classList.remove('active'));
                this.classList.add('active');
            });
        });
    </script>
</body>

</html>
