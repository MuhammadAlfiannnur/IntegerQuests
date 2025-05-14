<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Nilai;

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

    public function index()
    {
        // Ambil semua data nilai siswa
        $nilais = Nilai::with('siswa')->get(); // Menggunakan eager loading untuk mengakses data siswa

        // Ambil semua data siswa jika ingin menampilkan data siswa di halaman yang sama
        $siswas = Siswa::all();

        // Kirim data nilai dan siswa ke view HalamanGuru
        return view('HalamanGuru', compact('nilais', 'siswas'));
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
