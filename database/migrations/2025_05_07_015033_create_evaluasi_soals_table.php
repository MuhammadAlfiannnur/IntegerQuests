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
        Schema::create('evaluasi_soals', function (Blueprint $table) {
            $table->id();
            $table->text('pertanyaan');  // Kolom untuk menyimpan teks soal
            $table->string('opsi_a');    // Opsi jawaban A
            $table->string('opsi_b');    // Opsi jawaban B
            $table->string('opsi_c');    // Opsi jawaban C
            $table->string('opsi_d');    // Opsi jawaban D
            $table->enum('jawaban_benar', ['a', 'b', 'c', 'd']); // Jawaban yang benar
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('evaluasi_soals');
    }
};
