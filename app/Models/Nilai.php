<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    use HasFactory;

    // Tentukan nama tabel
    protected $table = 'nilais';

    // Tentukan kolom yang dapat diisi
    protected $fillable = ['siswa_id', 'total_benar', 'total_salah', 'nilai'];
    
    // Relasi ke model Siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
