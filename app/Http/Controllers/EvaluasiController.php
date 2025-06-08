<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\EvaluasiSoal;
use App\Models\JawabanSiswa;
use App\Models\Nilai;

class EvaluasiController extends Controller
{
    public function tampilkanEvaluasi()
    {
        // $soals = EvaluasiSoal::all()->mapWithKeys(function ($soal) {
        //     return [$soal->id => [
        //         'pertanyaan' => $soal->pertanyaan,
        //         'pilihan' => $soal->getOpsiJawaban()
        //     ]];
        // })->toArray();

        // return view('HalamanEvaluasi', [
        //     'soal' => $soals
        // ]);

        // 1. Ambil 20 soal secara acak dari database
        $randomSoals = EvaluasiSoal::inRandomOrder()->take(20)->get();

        // 2. Format soal-soal tersebut seperti kode Anda sebelumnya
        $soals = $randomSoals->mapWithKeys(function ($soal) {
            return [$soal->id => [
                'pertanyaan' => $soal->pertanyaan,
                'pilihan' => $soal->getOpsiJawaban()
            ]];
        })->toArray();

        // 3. Ambil ID dari 20 soal yang akan ditampilkan
        $soal_ids = $randomSoals->pluck('id')->implode(',');

        // 4. Kirim data soal DAN ID-nya ke view
        return view('HalamanEvaluasi', [
            'soal' => $soals,
            'soal_ids' => $soal_ids, // <-- Variabel baru untuk dikirim
        ]);
    }

    public function simpanJawaban(Request $request)
    {
        // 1. Ambil siswa yang sudah ada berdasarkan ID dari hidden input, bukan membuat baru.
        // Ini adalah perubahan paling penting.
        $siswa = Siswa::findOrFail($request->input('siswa_id'));

        // 2. Ambil ID dari 20 soal yang ditampilkan dari request
        $soalIds = explode(',', $request->input('soal_ids'));

        // 3. Ambil data soal yang SESUAI dari database berdasarkan ID tersebut
        $soals = EvaluasiSoal::whereIn('id', $soalIds)->get();

        // 4. Simpan setiap jawaban dan hitung total yang benar
        $totalBenar = 0;
        foreach ($soals as $soal) {
            // Ambil jawaban dari input
            $jawaban = $request->input('jawaban'.$soal->id);
            
            // Cek apakah jawaban benar
            $isBenar = ($jawaban == $soal->jawaban_benar) ? 1 : 0;
            
            if ($isBenar) {
                $totalBenar++;
            }

            // Simpan jawaban siswa ke database
            JawabanSiswa::create([
                'siswa_id' => $siswa->id,
                'soal_id' => $soal->id,
                'jawaban' => $jawaban ?? null, // Gunakan null jika jawaban tidak ada
                'is_benar' => $isBenar
            ]);
        }

        // 5. Hitung nilai akhir
        $totalSoal = count($soals);
        // Tambahkan pengaman untuk menghindari pembagian dengan nol
        $nilai = ($totalSoal > 0) ? ($totalBenar / $totalSoal) * 100 : 0;

        // 6. Simpan nilai akhir siswa
        Nilai::create([
            'siswa_id' => $siswa->id,
            'nilai' => $nilai
        ]);

        // 7. Redirect ke halaman hasil dengan ID siswa yang sama
        return redirect()->route('beranda', $siswa->id)
                        ->with('success', 'Evaluasi telah selesai. Jawaban berhasil disimpan!');
    }

    public function tampilkanHasil($id)
    {
        $siswa = Siswa::with(['jawabans', 'jawabans.soal', 'nilai'])->findOrFail($id);
        return view('HasilEvaluasi', compact('siswa'));
    }

    // Method baru untuk menampilkan data di HalamanGuru
    public function getDataEvaluasi()
    {
        $data = Siswa::with('nilai')
                    ->orderBy('created_at', 'desc')
                    ->get()
                    ->map(function ($siswa) {
                        return [
                            'id' => $siswa->id,
                            'nama' => $siswa->nama,
                            'nilai' => $siswa->nilai->nilai ?? 0,
                            'total_benar' => $siswa->nilai->total_benar ?? 0,
                            'total_salah' => $siswa->nilai->total_salah ?? 0,
                            'created_at' => $siswa->created_at->format('d-m-Y H:i')
                        ];
                    });

        return response()->json($data);
    }

    public function cekNamaSiswa(Request $request)
    {
        $nama = $request->input('nama');
        $siswa = Siswa::where('nama', $nama)->first();

        if ($siswa) {
            // Jika siswa ditemukan, kirim status 'exists' = true dan ID siswa
            return response()->json([
                'exists' => true,
                'siswa_id' => $siswa->id 
            ]);
        } else {
            // Jika tidak ditemukan, kirim status 'exists' = false
            return response()->json(['exists' => false]);
        }
    }
}