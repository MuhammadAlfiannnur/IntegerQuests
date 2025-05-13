<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class EvaluasiSoal extends Model
{
    use HasFactory;

    protected $table = 'evaluasi_soals'; 
    protected $fillable = ['pertanyaan', 'opsi_a', 'opsi_b', 'opsi_c', 'opsi_d', 'jawaban_benar'];


    public function JawabanSiswas(): HasMany
    {
        return $this->hasMany(JawabanSiswa::class, 'soal_id');
    }

    // Helper method untuk mendapatkan opsi jawaban
    public function getOpsiJawaban()
    {
        return [
            'a' => $this->opsi_a,
            'b' => $this->opsi_b,
            'c' => $this->opsi_c,
            'd' => $this->opsi_d
        ];
    }
}
