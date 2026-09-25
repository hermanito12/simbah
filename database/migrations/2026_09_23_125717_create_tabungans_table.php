<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tabungan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('nasabah_id')->constrained('nasabah')->cascadeOnDelete();
            $table->foreignId('transaksi_id')->nullable()->constrained('transaksi')->nullOnDelete();
            $table->foreignId('dicatat_oleh')->nullable()->constrained('users')->nullOnDelete()->comment('pengurus yang mencatat penarikan');
            $table->enum('jenis', ['masuk', 'keluar']);
            $table->decimal('nominal', 12, 2);
            $table->string('keterangan')->nullable();
            $table->date('tanggal');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tabungan');
    }
};
