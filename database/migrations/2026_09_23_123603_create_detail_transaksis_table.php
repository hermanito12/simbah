<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaksi_id')->constrained('transaksi')->cascadeOnDelete();
            $table->foreignId('jenis_sampah_id')->constrained('jenis_sampah');
            $table->decimal('berat', 10, 2);
            $table->decimal('harga_saat_transaksi', 12, 2)->comment('snapshot harga, tidak berubah walau harga master diupdate');
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};
