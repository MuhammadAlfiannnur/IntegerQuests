<?php

namespace App\Exports;

use App\Models\Nilai;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class NilaiExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected $search;
    protected $filterKelas;

    // Menerima parameter filter dari Controller
    public function __construct($search, $filterKelas)
    {
        $this->search = $search;
        $this->filterKelas = $filterKelas;
    }

    /**
     * Menentukan judul untuk setiap kolom di baris pertama file Excel.
     */
    public function headings(): array
    {
        return [
            'Nama Siswa',
            'Kelas',
            'Level',
            'Skor',
            'Waktu Pengerjaan',
        ];
    }

    /**
     * Mengubah setiap baris data dari Eloquent menjadi array.
     * Urutannya harus sama persis dengan headings().
     * @param \App\Models\Nilai $nilai
     */
    public function map($nilai): array
    {
        return [
            $nilai->siswa->nama ?? 'Siswa Telah Dihapus',
            $nilai->siswa->kelas->nama_kelas ?? '-',
            $nilai->siswa->level ?? '-',
            $nilai->nilai,
            $nilai->created_at->format('d-m-Y H:i:s'),
        ];
    }

    /**
     * Query untuk mengambil data dari database.
     * Kita gunakan query yang sama persis dengan di Controller halaman guru
     * agar data yang diekspor selalu sinkron.
     */
    public function query()
    {
        // Kita mulai query dari Model Nilai
        $query = Nilai::query()->with(['siswa.kelas'])
                      ->orderBy('created_at', 'desc');

        // Terapkan filter pencarian jika ada
        if ($this->search) {
            $query->whereHas('siswa', function ($q) {
                $q->where('nama', 'like', "%{$this->search}%");
            });
        }
    
        // Terapkan filter kelas jika ada
        if ($this->filterKelas) {
            $query->whereHas('siswa', function ($q) {
                $q->where('kelas_id', $this->filterKelas);
            });
        }

        return $query;
    }
}