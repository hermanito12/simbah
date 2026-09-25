<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HargaSampah extends Model
{
    protected $table = 'harga_sampah';

    protected $fillable = [
        'unit_id',
        'jenis_sampah_id',
        'harga_pengepul',
        'harga_nasabah',
        'tanggal_mulai',
        'tanggal_akhir',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function jenisSampah()
    {
        return $this->belongsTo(JenisSampah::class);
    }
}
