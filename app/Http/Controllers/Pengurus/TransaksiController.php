<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\JenisSampah;
use App\Models\Nasabah;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransaksiController extends Controller
{
    public function index()
    {
        $unitId = auth()->user()->unit_id;

        $transaksi = Transaksi::with(['nasabah', 'detail.jenisSampah'])
            ->where('unit_id', $unitId)
            ->latest('tanggal')
            ->latest('id')
            ->paginate(15);

        return view('pengurus.transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $unitId = auth()->user()->unit_id;

        $nasabahList = Nasabah::where('unit_id', $unitId)
            ->where('status', 'aktif')
            ->orderBy('nama')
            ->get();

        $jenisSampah = JenisSampah::where('status', 'aktif')
            ->orderBy('kategori')
            ->orderBy('nama')
            ->get();

        return view('pengurus.transaksi.create', compact('nasabahList', 'jenisSampah'));
    }

    public function store(Request $request)
    {
        $unitId = auth()->user()->unit_id;

        $validated = $request->validate([
            'nasabah_id' => ['required', 'exists:nasabah,id'],
            'metode' => ['required', 'in:tabungan,tunai'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.jenis_sampah_id' => ['required', 'exists:jenis_sampah,id'],
            'items.*.berat' => ['required', 'numeric', 'min:0.01'],
        ]);

        // Pastikan nasabah benar-benar milik unit pengurus ini (anti manipulasi form)
        $nasabah = Nasabah::where('id', $validated['nasabah_id'])
            ->where('unit_id', $unitId)
            ->where('status', 'aktif')
            ->first();

        if (!$nasabah) {
            abort(403, 'Nasabah tidak valid untuk unit Anda.');
        }

        $items = collect($validated['items']);
        $detailToSave = [];
        $total = 0;

        // Server yang cari harga, BUKAN percaya harga dari frontend
        foreach ($items as $item) {
            $jenisSampah = JenisSampah::whereKey($item['jenis_sampah_id'])
                ->where('status', 'aktif')
                ->first();

            if (!$jenisSampah) {
                throw ValidationException::withMessages([
                    'items' => 'Jenis sampah yang dipilih tidak aktif atau tidak ditemukan.',
                ]);
            }

            $hargaAktif = $jenisSampah->hargaAktifUntukUnit($unitId);

            if (!$hargaAktif) {
                throw ValidationException::withMessages([
                    'items' => "Jenis sampah '{$jenisSampah->nama}' belum punya harga aktif untuk unit Anda. Set harga dulu di menu Harga Sampah.",
                ]);
            }

            $berat = (float) $item['berat'];
            $subtotal = $berat * (float) $hargaAktif->harga_nasabah;
            $total += $subtotal;

            $detailToSave[] = [
                'jenis_sampah_id' => $jenisSampah->id,
                'berat' => $berat,
                'harga_saat_transaksi' => $hargaAktif->harga_nasabah,
                'subtotal' => $subtotal,
            ];
        }

        DB::transaction(function () use ($unitId, $nasabah, $validated, $detailToSave, $total) {
            $transaksi = Transaksi::create([
                'unit_id' => $unitId,
                'nasabah_id' => $nasabah->id,
                'user_id' => auth()->id(),
                'metode' => $validated['metode'],
                'total' => $total,
                'tanggal' => now()->toDateString(),
            ]);

            foreach ($detailToSave as $d) {
                DetailTransaksi::create(array_merge($d, ['transaksi_id' => $transaksi->id]));
            }

            // Kalau metode tabungan, catat sebagai mutasi masuk di ledger
            if ($validated['metode'] === 'tabungan') {
                Tabungan::create([
                    'nasabah_id' => $nasabah->id,
                    'transaksi_id' => $transaksi->id,
                    'jenis' => 'masuk',
                    'nominal' => $total,
                    'keterangan' => 'Setoran sampah',
                    'tanggal' => now()->toDateString(),
                ]);
            }
        });

        return redirect()->route('pengurus.transaksi.index')
            ->with('success', "Transaksi berhasil disimpan. Total: Rp" . number_format($total, 0, ',', '.'));
    }

    public function show(Transaksi $transaksi)
    {
        if ($transaksi->unit_id !== auth()->user()->unit_id) {
            abort(403);
        }

        $transaksi->load(['nasabah', 'detail.jenisSampah']);

        return view('pengurus.transaksi.show', compact('transaksi'));
    }
}
