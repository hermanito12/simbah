<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransaksi extends Model
{
    protected $table = 'detail_transaksi';

    protected $fillable = ['transaksi_id', 'jenis_sampah_id', 'berat', 'harga_saat_transaksi', 'subtotal'];

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class, 'transaksi_id');
    }
}