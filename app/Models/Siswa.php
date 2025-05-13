<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\HasMany; // Import class HasMany

class Siswa extends Model
{
    use HasFactory;

    // Tentukan nama tabel jika tidak menggunakan konvensi Laravel
    protected $table = 'siswas'; // Misalnya tabelnya bernama 'siswa'
    
    // Tentukan kolom-kolom yang dapat diisi
    protected $fillable = ['nama']; // Contoh
    // protected $table = 'siswas'; 

    public function jawabans()
    {
        return $this->hasMany(JawabanSiswa::class);
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class);
    }

    // public function nilais(): HasMany
    // {
    //     return $this->hasMany(Nilai::class, 'siswa_id');
    // }

    // public function jawabans(): HasMany
    // {
    //     return $this->hasMany(JawabanSiswa::class, 'siswa_id');
    // }

    // public function hasilEvaluasis(): HasMany
    // {
    //     return $this->hasMany(HasilEvaluasi::class, 'siswa_id');
    // }
    // public function hasilEvaluasi()
    // {
    //     return $this->hasMany(\App\Models\HasilEvaluasi::class);
    // }
}
