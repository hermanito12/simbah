<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;

class TabunganController extends Controller
{
    public function index(Nasabah $nasabah)
    {
        if ($nasabah->unit_id !== auth()->user()->unit_id) {
            abort(403);
        }

        $mutasi = $nasabah->mutasiTabungan()->latest('tanggal')->latest('id')->get();

        return view('pengurus.tabungan.index', [
            'nasabah' => $nasabah,
            'mutasi' => $mutasi,
            'saldo' => $nasabah->saldo(),
        ]);
    }
}
