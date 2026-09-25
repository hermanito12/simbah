<?php

namespace App\Http\Controllers\Kelurahan;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Nasabah;
use App\Models\Transaksi;
use App\Models\Unit;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $tanggalMulai = $request->input('tanggal_mulai', now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', now()->endOfMonth()->toDateString());

        // Angka ringkasan level kelurahan (semua unit digabung)
        $jumlahUnit = Unit::where('status', 'aktif')->count();
        $jumlahNasabah = Nasabah::where('status', 'aktif')->count();

        $transaksiPeriode = Transaksi::whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        $jumlahTransaksi = (clone $transaksiPeriode)->count();
        $totalNilai = (clone $transaksiPeriode)->sum('total');

        $totalBerat = DetailTransaksi::whereHas('transaksi', function ($q) use ($tanggalMulai, $tanggalAkhir) {
            $q->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        })->sum('berat');

        // Breakdown per Unit — biar kelurahan tahu unit mana yang paling aktif
        $rekapPerUnit = Unit::withCount(['nasabah' => function ($q) {
            $q->where('status', 'aktif');
        }])
            ->get()
            ->map(function ($unit) use ($tanggalMulai, $tanggalAkhir) {
                $transaksiUnit = Transaksi::where('unit_id', $unit->id)
                    ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);

                $unit->jumlah_transaksi = (clone $transaksiUnit)->count();
                $unit->total_nilai = (clone $transaksiUnit)->sum('total');
                $unit->total_berat = DetailTransaksi::whereHas('transaksi', function ($q) use ($unit, $tanggalMulai, $tanggalAkhir) {
                    $q->where('unit_id', $unit->id)->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
                })->sum('berat');

                return $unit;
            });

        return view('kelurahan.dashboard', compact(
            'jumlahUnit',
            'jumlahNasabah',
            'jumlahTransaksi',
            'totalNilai',
            'totalBerat',
            'rekapPerUnit',
            'tanggalMulai',
            'tanggalAkhir'
        ));
    }
}
