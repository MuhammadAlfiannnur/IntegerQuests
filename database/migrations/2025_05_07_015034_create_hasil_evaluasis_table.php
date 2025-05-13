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
        Schema::create('hasil_evaluasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained()->onDelete('cascade'); // Relasi ke siswa
            $table->integer('total_soal'); // Jumlah total soal
            $table->integer('jawaban_benar'); // Jumlah jawaban benar
            $table->decimal('nilai', 5, 2); // Nilai akhir (contoh: 85.50)
            $table->timestamps();

            $table->index(['siswa_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hasil_evaluasis');
    }
};
