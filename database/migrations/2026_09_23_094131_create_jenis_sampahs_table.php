<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jenis_sampah', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->enum('kategori', ['Kertas', 'Plastik', 'Logam', 'Lain-lain']);
            $table->string('satuan')->default('kg');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jenis_sampah');
    }
};
