<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Token extends Model
{
    use HasFactory;

    // Nama tabel jika tidak sesuai konvensi plural (default: tokens)
    protected $table = 'tokens';

    // Kolom yang bisa diisi massal (fillable)
    protected $fillable = [
        'token',
        'kelas_id',
        'status',
    ];

    // Relasi ke kelas
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
