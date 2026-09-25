<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nasabah extends Model
{
    protected $table = 'nasabah';

    protected $fillable = [
        'unit_id',
        'user_id',
        'nomor_induk',
        'nama',
        'alamat',
        'status',
    ];

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }

    public function mutasiTabungan()
    {
        return $this->hasMany(Tabungan::class);
    }

    public function saldo(): float
    {
        $masuk = $this->mutasiTabungan()->where('jenis', 'masuk')->sum('nominal');
        $keluar = $this->mutasiTabungan()->where('jenis', 'keluar')->sum('nominal');

        return (float) $masuk - (float) $keluar;
    }
}
