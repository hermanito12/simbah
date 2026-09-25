<?php

namespace App\Http\Controllers\Nasabah;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;

class BukuSakuController extends Controller
{
    public function index()
    {
        $nasabah = Nasabah::where('user_id', auth()->id())->firstOrFail();

        $mutasi = $nasabah->mutasiTabungan()->latest('tanggal')->latest('id')->get();
        $transaksi = $nasabah->transaksi()->with('detail.jenisSampah')->latest('tanggal')->latest('id')->take(10)->get();

        return view('nasabah.dashboard', [
            'nasabah' => $nasabah,
            'saldo' => $nasabah->saldo(),
            'mutasi' => $mutasi,
            'transaksi' => $transaksi,
        ]);
    }
}
