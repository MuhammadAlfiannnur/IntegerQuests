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
        // $soals = EvaluasiSoal::all()
        // ->take(2) // ambil 2 soal dulu
        // ->mapWithKeys(function ($soal) {
        //     return [$soal->id => [
        //         'pertanyaan' => $soal->pertanyaan,
        //         'pilihan' => $soal->getOpsiJawaban()
        //     ]];
        // })
        // ->toArray();
        $soals = EvaluasiSoal::all()->mapWithKeys(function ($soal) {
            return [$soal->id => [
                'pertanyaan' => $soal->pertanyaan,
                'pilihan' => $soal->getOpsiJawaban()
            ]];
        })->toArray();

        return view('HalamanEvaluasi', [
            'soal' => $soals
        ]);
    }

    public function simpanJawaban(Request $request)
    {
        // dd($request->all());
        // $request->validate([
        //     'nama' => 'required|string|max:255',
        // ]);

        // Simpan siswa
        $siswa = Siswa::create([
            'nama' => $request->nama
        ]);

        // Simpan jawaban dan hitung yang benar
        $totalBenar = 0;
        $soals = EvaluasiSoal::all();

        foreach ($soals as $soal) {
            $jawaban = $request->input('jawaban'.$soal->id);
            $isBenar = $jawaban == $soal->jawaban_benar ? 1 : 0;
            
            if ($isBenar) {
                $totalBenar++;
            }

            JawabanSiswa::create([
                'siswa_id' => $siswa->id,
                'soal_id' => $soal->id,
                'jawaban' => $jawaban,
                'is_benar' => $isBenar
            ]);
        }

        // Hitung nilai
        $totalSoal = count($soals);
        $nilai = ($totalBenar / $totalSoal) * 100;

        // Simpan nilai
        Nilai::create([
            'siswa_id' => $siswa->id,
            'nilai' => $nilai
        ]);

        return redirect()->route('beranda', $siswa->id)
                        ->with('success', 'Jawaban berhasil disimpan!');
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
}