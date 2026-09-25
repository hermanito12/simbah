<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JenisSampah extends Model
{
    protected $table = 'jenis_sampah';

    protected $fillable = ['nama', 'kategori', 'satuan', 'status'];

    public function hargaAktifUntukUnit(int $unitId)
    {
        return $this->hasMany(HargaSampah::class)
            ->where('unit_id', $unitId)
            ->whereDate('tanggal_mulai', '<=', now())
            ->where(function ($q) {
                $q->whereNull('tanggal_akhir')->orWhereDate('tanggal_akhir', '>=', now());
            })
            ->latest('tanggal_mulai')
            ->first();
    }
}
