<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\Tabungan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PenarikanController extends Controller
{
    public function create(Nasabah $nasabah)
    {
        $this->authorizeUnit($nasabah);

        return view('pengurus.penarikan.create', [
            'nasabah' => $nasabah,
            'saldo' => $nasabah->saldo(),
        ]);
    }

    public function store(Request $request, Nasabah $nasabah)
    {
        $this->authorizeUnit($nasabah);

        $validated = $request->validate([
            'nominal' => ['required', 'numeric', 'min:0.01'],
            'keterangan' => ['nullable', 'string', 'max:255'],
        ]);

        DB::transaction(function () use ($nasabah, $validated) {
            $nasabahTerkunci = Nasabah::whereKey($nasabah->id)
                ->lockForUpdate()
                ->firstOrFail();
            $saldoTerkini = $nasabahTerkunci->saldo();

            if ($validated['nominal'] > $saldoTerkini) {
                throw ValidationException::withMessages([
                    'nominal' => 'Nominal penarikan (Rp' . number_format($validated['nominal'], 0, ',', '.') .
                        ') melebihi saldo nasabah (Rp' . number_format($saldoTerkini, 0, ',', '.') . ').',
                ]);
            }

            Tabungan::create([
                'nasabah_id' => $nasabahTerkunci->id,
                'dicatat_oleh' => auth()->id(),
                'jenis' => 'keluar',
                'nominal' => $validated['nominal'],
                'keterangan' => $validated['keterangan'] ?? 'Penarikan tabungan',
                'tanggal' => now()->toDateString(),
            ]);
        });

        return redirect()->route('pengurus.tabungan.index', $nasabah)
            ->with('success', 'Penarikan berhasil dicatat.');
    }

    private function authorizeUnit(Nasabah $nasabah): void
    {
        if ($nasabah->unit_id !== auth()->user()->unit_id) {
            abort(403, 'Nasabah ini bukan milik unit Anda.');
        }
    }
}
