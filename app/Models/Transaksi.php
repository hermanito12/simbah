<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $table = 'transaksi';

    protected $fillable = ['unit_id', 'nasabah_id', 'user_id', 'metode', 'total', 'tanggal'];

    public function detail()
    {
        return $this->hasMany(DetailTransaksi::class, 'transaksi_id');
    }

    public function nasabah()
    {
        return $this->belongsTo(Nasabah::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
