<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'nama_kelas',
    ];

    // Relasi ke Token (1 kelas bisa punya banyak token)
    public function tokens()
    {
        return $this->hasMany(Token::class, 'kelas_id');
    }

    // Relasi ke Siswa (1 kelas punya banyak siswa)
    public function siswas()
    {
        return $this->hasMany(Siswa::class, 'kelas');
    }
}
