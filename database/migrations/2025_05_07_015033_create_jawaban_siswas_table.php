<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jawaban_siswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade'); // Relasi ke siswa
            $table->foreignId('soal_id')->constrained('evaluasi_soals')->onDelete('cascade'); // Relasi ke soal
            $table->enum('jawaban', ['a', 'b', 'c', 'd']); // Jawaban yang dipilih siswa
            $table->boolean('is_benar'); // Status benar/salah
            $table->timestamps();

            $table->index(['siswa_id', 'soal_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jawaban_siswas');
    }
};
