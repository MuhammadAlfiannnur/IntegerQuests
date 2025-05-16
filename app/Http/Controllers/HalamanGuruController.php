<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Nilai;
use App\Models\JawabanSiswa;
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

        // Ambil data nilai + relasi siswa, dengan pencarian berdasarkan nama atau nilai
        $nilais = \App\Models\Nilai::with('siswa')
            ->when($search, function ($query, $search) {
                return $query->whereHas('siswa', function ($q) use ($search) {
                            $q->where('nama', 'like', "%{$search}%");
                        })
                        ->orWhere('nilai', 'like', "%{$search}%");
            })
            ->get();


        // Ambil semua data nilai siswa

        // Ambil semua data siswa jika ingin menampilkan data siswa di halaman yang sama
        $siswas = \App\Models\Siswa::all();

        // Kirim data nilai dan siswa ke view HalamanGuru
        return view('HalamanGuru', compact('nilais', 'siswas'));
    }

    public function exportPDF()
    {
        $nilais = \App\Models\Nilai::with('siswa')->get();

        $pdf = Pdf::loadView('exports.nilai_pdf', compact('nilais'));
        return $pdf->download('data_nilai.pdf');
    }


    public function destroySiswa($id)
    {
        // Menghapus data siswa berdasarkan id
        $siswa = Siswa::findOrFail($id);
        $siswa->delete();

        return redirect()->route('guru.index')->with('success', 'Data siswa berhasil dihapus.');
    }

    public function destroyNilai($id)
    {
        // Menghapus data nilai berdasarkan id
        $nilai = Nilai::findOrFail($id);
        $nilai->delete();

        return redirect()->route('guru.index')->with('success', 'Data nilai berhasil dihapus');
    }
    
}
