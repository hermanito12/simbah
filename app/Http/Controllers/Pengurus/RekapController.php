<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\DetailTransaksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class RekapController extends Controller
{
    public function index(Request $request)
    {
        $unitId = auth()->user()->unit_id;

        // Default periode: bulan berjalan, tapi bisa di-override lewat filter
        $tanggalMulai = $request->input('tanggal_mulai', now()->startOfMonth()->toDateString());
        $tanggalAkhir = $request->input('tanggal_akhir', now()->endOfMonth()->toDateString());

        $baseQuery = Transaksi::where('unit_id', $unitId)
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);

        $totalTransaksi = (clone $baseQuery)->count();
        $totalNilai = (clone $baseQuery)->sum('total');
        $totalTabungan = (clone $baseQuery)->where('metode', 'tabungan')->sum('total');
        $totalTunai = (clone $baseQuery)->where('metode', 'tunai')->sum('total');

        $totalBerat = DetailTransaksi::whereHas('transaksi', function ($q) use ($unitId, $tanggalMulai, $tanggalAkhir) {
            $q->where('unit_id', $unitId)->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        })->sum('berat');

        // Breakdown per jenis sampah: jenis apa yang paling banyak disetor
        $breakdownJenis = DetailTransaksi::whereHas('transaksi', function ($q) use ($unitId, $tanggalMulai, $tanggalAkhir) {
            $q->where('unit_id', $unitId)->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        })
            ->join('jenis_sampah', 'detail_transaksi.jenis_sampah_id', '=', 'jenis_sampah.id')
            ->selectRaw('jenis_sampah.nama as nama_jenis, SUM(detail_transaksi.berat) as total_berat, SUM(detail_transaksi.subtotal) as total_nilai')
            ->groupBy('jenis_sampah.id', 'jenis_sampah.nama')
            ->orderByDesc('total_berat')
            ->get();

        return view('pengurus.rekap.index', compact(
            'totalTransaksi',
            'totalNilai',
            'totalTabungan',
            'totalTunai',
            'totalBerat',
            'breakdownJenis',
            'tanggalMulai',
            'tanggalAkhir'
        ));
    }
}
