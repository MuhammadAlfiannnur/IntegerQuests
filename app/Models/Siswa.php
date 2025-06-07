<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'siswas';

    // Isikan kolom yang boleh di‐mass‐assign, termasuk 'kelas_id'
    protected $fillable = ['nama', 'kelas_id'];

    public function jawabans()
    {
        return $this->hasMany(JawabanSiswa::class);
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class);
    }

    // Relasi ke Kelas—Laravel otomatis pakai foreign key 'kelas_id'
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', 'id');
    }
}
