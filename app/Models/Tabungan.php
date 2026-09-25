<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    protected $table = 'tabungan';

    protected $fillable = [
        'nasabah_id',
        'transaksi_id',
        'dicatat_oleh',
        'jenis',
        'nominal',
        'keterangan',
        'tanggal',
    ];

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}
