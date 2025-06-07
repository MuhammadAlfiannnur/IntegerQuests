<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\Kelas;
use App\Models\Token;
use Barryvdh\DomPDF\Facade\Pdf;

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

        // Ambil data Nilai sekaligus relasi Siswa—dan rekursif ambil relasi Kelas
        $nilais = \App\Models\Nilai::with('siswa.kelas')
            ->when($search, function ($query, $search) {
                return $query->whereHas('siswa', function ($q) use ($search) {
                            $q->where('nama', 'like', "%{$search}%");
                        })
                        ->orWhere('nilai', 'like', "%{$search}%");
            })
            ->get();

        // Ambil semua Kelas (untuk dropdown di form token)
        $kelas = \App\Models\Kelas::all();

        // Ambil semua Siswa sekaligus relasi Kelas
        $siswas = \App\Models\Siswa::with('kelas')->get();

        return view('HalamanGuru', compact('nilais', 'kelas', 'siswas'));
    }

    public function exportPDF()
    {
        $nilais = Nilai::with('siswa')->get();

        $pdf = Pdf::loadView('exports.nilai_pdf', compact('nilais'));
        return $pdf->download('data_nilai.pdf');
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

    // Tambahkan method untuk menyimpan token baru
    public function storeToken(Request $request)
    {
        $this->checkLogin();

        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        // Generate token unik, contoh 8 karakter acak
        $tokenValue = strtoupper(bin2hex(random_bytes(4)));

        // Simpan token ke database
        Token::create([
            'kelas_id' => $request->kelas_id,
            'token' => $tokenValue,
        ]);

        return redirect()->route('guru.index')
            ->with('token_success', 'Token berhasil dibuat!')
            ->with('token_generated', $tokenValue);

        
    }
}
