<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Token;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel; // <-- Tambahan untuk Excel
use App\Exports\NilaiExport;        // <-- Tambahan untuk Excel

class HalamanGuruController extends Controller
{
    public function __construct()
    {
        if (!session()->has('guru_logged_in')) {
            abort(403, 'Silakan login terlebih dahulu.');
        }
    }

    private function checkLogin()
    {
        if (!session('guru_logged_in')) {
            abort(403, 'Akses ditolak. Silakan login terlebih dahulu.');
        }
    }

    public function index(Request $request)
    {
        $this->checkLogin();

        $search = $request->input('search');
        $filterKelas = $request->input('kelas_id');

        // Query utama: Mulai dari Siswa untuk menampilkan semua siswa
        $query = Siswa::with(['kelas', 'nilai'])->orderBy('nama', 'asc');

        // Terapkan filter pencarian nama jika ada
        if ($search) {
            $query->where('nama', 'like', "%{$search}%");
        }

        // Terapkan filter kelas jika ada
        if ($filterKelas) {
            $query->where('kelas_id', $filterKelas);
        }

        $siswas = $query->get();
        $kelas = Kelas::all();

        // Hitung semua data statistik
        $totalSiswa = Siswa::count();
        $totalEvaluasi = Nilai::count();
        $rataRataNilai = Nilai::avg('nilai');

        // Kirim SEMUA variabel yang dibutuhkan ke view
        return view('HalamanGuru', compact(
            'siswas', 
            'kelas', 
            'totalSiswa', 
            'totalEvaluasi', 
            'rataRataNilai'
        ));
    }

    public function exportPDF(Request $request)
    {
        $search = $request->input('search');
        $filterKelas = $request->input('kelas_id');

        // Query untuk PDF (bersumber dari Nilai agar setiap pengerjaan tercatat)
        $query = Nilai::with(['siswa.kelas'])->orderBy('created_at', 'desc');

        if ($search) {
            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%");
            });
        }

        if ($filterKelas) {
            $query->whereHas('siswa', function ($q) use ($filterKelas) {
                $q->where('kelas_id', $filterKelas);
            });
        }

        $nilais = $query->get();
        
        $pdf = Pdf::loadView('exports.nilai_pdf', compact('nilais'));
        return $pdf->download('laporan-nilai-siswa.pdf');
    }

    /**
     * Menangani permintaan untuk mengekspor data ke Excel.
     */
    public function exportExcel(Request $request)
    {
        // 1. Ambil filter yang sedang aktif dari URL
        $search = $request->input('search');
        $filterKelas = $request->input('kelas_id');
        
        // 2. Tentukan nama file yang akan diunduh secara dinamis
        $fileName = 'hasil-evaluasi-' . date('d-m-Y') . '.xlsx';

        // 3. Panggil class export dengan membawa filter, lalu unduh filenya
        return Excel::download(new NilaiExport($search, $filterKelas), $fileName);
    }

    public function destroySiswa($id)
    {
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('guru.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    public function destroyNilai($id)
    {
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        return redirect()->route('guru.index')->with('success', 'Data nilai berhasil dihapus');
    }

    public function storeToken(Request $request)
    {
        $this->checkLogin();

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $tokenValue = strtoupper(bin2hex(random_bytes(4)));

        Token::create([
            'kelas_id' => $request->kelas_id,
            'token' => $tokenValue,
        ]);

        return redirect()->route('guru.index')
            ->with('token_success', 'Token berhasil dibuat!')
            ->with('token_generated', $tokenValue);
    }
}