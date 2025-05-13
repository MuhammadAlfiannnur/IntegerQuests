<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JawabanSiswa extends Model
{
    protected $table = 'jawaban_siswas'; 
    protected $fillable = ['siswa_id', 'soal_id', 'jawaban', 'is_benar'];

    public function siswa(): BelongsTo
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }

    public function soal(): BelongsTo
    {
        return $this->belongsTo(EvaluasiSoal::class, 'soal_id');
    }
}
