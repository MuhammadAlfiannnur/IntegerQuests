<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('siswas', function (Blueprint $table) {
            $table->id(); // Ini otomatis unsignedBigInteger
            $table->string('nama');
            $table->timestamps(); 
        });
    }

    public function down(): void {
        Schema::dropIfExists('siswas');
    }
};