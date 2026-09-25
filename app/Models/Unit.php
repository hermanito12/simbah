<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    protected $fillable = [
        'nama_unit',
        'tingkat',
        'alamat',
        'status',
    ];
    public function nasabah()
    {
        return $this->hasMany(Nasabah::class);
    }

    public function users()
    {
        return $this->hasMany(\App\Models\User::class);
    }
}
