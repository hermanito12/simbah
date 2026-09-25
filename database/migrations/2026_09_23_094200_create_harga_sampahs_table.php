<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('harga_sampah', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('jenis_sampah_id')->constrained('jenis_sampah')->cascadeOnDelete();
            $table->decimal('harga_pengepul', 12, 2)->nullable();
            $table->decimal('harga_nasabah', 12, 2);
            $table->date('tanggal_mulai');
            $table->date('tanggal_akhir')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('harga_sampah');
    }
};
