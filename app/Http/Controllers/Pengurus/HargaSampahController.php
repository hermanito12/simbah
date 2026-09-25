<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\HargaSampah;
use App\Models\JenisSampah;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class HargaSampahController extends Controller
{
    public function index()
    {
        $unitId = auth()->user()->unit_id;

        $hargaAktif = HargaSampah::with('jenisSampah')
            ->where('unit_id', $unitId)
            ->whereDate('tanggal_mulai', '<=', now())
            ->where(function ($q) {
                $q->whereNull('tanggal_akhir')->orWhereDate('tanggal_akhir', '>=', now());
            })
            ->get()
            ->unique('jenis_sampah_id');

        return view('pengurus.harga.index', compact('hargaAktif'));
    }

    public function create()
    {
        $jenisSampah = JenisSampah::where('status', 'aktif')
            ->orderBy('kategori')
            ->orderBy('nama')
            ->get();
        return view('pengurus.harga.create', compact('jenisSampah'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'jenis_sampah_id' => ['required', 'exists:jenis_sampah,id'],
            'harga_pengepul' => ['nullable', 'numeric', 'min:0.01'],
            'harga_nasabah' => ['required', 'numeric', 'min:0.01'],
            'tanggal_mulai' => ['required', 'date'],
        ]);

        $unitId = auth()->user()->unit_id;
        $jenisSampah = JenisSampah::whereKey($validated['jenis_sampah_id'])
            ->where('status', 'aktif')
            ->first();

        if (!$jenisSampah) {
            abort(422, 'Jenis sampah tidak aktif.');
        }

        $tanggalMulai = Carbon::parse($validated['tanggal_mulai']);

        DB::transaction(function () use ($unitId, $validated, $tanggalMulai) {
            HargaSampah::where('unit_id', $unitId)
                ->where('jenis_sampah_id', $validated['jenis_sampah_id'])
                ->whereNull('tanggal_akhir')
                ->update(['tanggal_akhir' => $tanggalMulai->copy()->subDay()->toDateString()]);

            HargaSampah::create([
                'unit_id' => $unitId,
                'jenis_sampah_id' => $validated['jenis_sampah_id'],
                'harga_pengepul' => $validated['harga_pengepul'],
                'harga_nasabah' => $validated['harga_nasabah'],
                'tanggal_mulai' => $tanggalMulai->toDateString(),
                'tanggal_akhir' => null,
            ]);
        });

        return redirect()->route('pengurus.harga.index')->with('success', 'Harga berhasil disimpan.');
    }

    public function riwayat(JenisSampah $jenisSampah)
    {
        $unitId = auth()->user()->unit_id;

        $riwayat = HargaSampah::where('unit_id', $unitId)
            ->where('jenis_sampah_id', $jenisSampah->id)
            ->orderByDesc('tanggal_mulai')
            ->get();

        return view('pengurus.harga.riwayat', compact('jenisSampah', 'riwayat'));
    }
}
