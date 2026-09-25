<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->foreignId('nasabah_id')->constrained('nasabah')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->comment('pengurus yang mencatat');
            $table->enum('metode', ['tabungan', 'tunai']);
            $table->decimal('total', 12, 2);
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
