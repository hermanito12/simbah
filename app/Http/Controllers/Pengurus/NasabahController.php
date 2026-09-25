<?php

namespace App\Http\Controllers\Pengurus;

use App\Http\Controllers\Controller;
use App\Models\Nasabah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class NasabahController extends Controller
{
    public function index()
    {
        $nasabah = Nasabah::where('unit_id', auth()->user()->unit_id)
            ->latest()
            ->get();

        return view('pengurus.nasabah.index', compact('nasabah'));
    }

    public function create()
    {
        return view('pengurus.nasabah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nomor_induk' => ['required', 'string', 'max:50', 'unique:nasabah,nomor_induk'],
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
        ]);

        $unitId = auth()->user()->unit_id;

        $username = Str::slug($validated['nomor_induk']);
        $passwordAwal = Str::random(8);

        $user = DB::transaction(function () use ($unitId, $validated, $username, $passwordAwal) {
            $user = User::create([
                'name' => $validated['nama'],
                'username' => $username,
                'email' => $username . '@simbah.internal',
                'password' => Hash::make($passwordAwal),
                'role' => 'nasabah',
                'unit_id' => $unitId,
            ]);

            Nasabah::create([
                'unit_id' => $unitId,
                'user_id' => $user->id,
                'nomor_induk' => $validated['nomor_induk'],
                'nama' => $validated['nama'],
                'alamat' => $validated['alamat'],
                'status' => 'aktif',
            ]);

            return $user;
        });

        return redirect()->route('pengurus.nasabah.index')
            ->with('success', "Nasabah berhasil ditambahkan. Login: {$user->username} / {$passwordAwal}");
    }

    public function edit(Nasabah $nasabah)
    {
        $this->authorizeUnit($nasabah);
        return view('pengurus.nasabah.edit', compact('nasabah'));
    }

    public function update(Request $request, Nasabah $nasabah)
    {
        $this->authorizeUnit($nasabah);

        $validated = $request->validate([
            'nomor_induk' => ['required', 'string', 'max:50', 'unique:nasabah,nomor_induk,' . $nasabah->id],
            'nama' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $nasabah->update($validated);
        $nasabah->user->update(['name' => $validated['nama']]);

        return redirect()->route('pengurus.nasabah.index')->with('success', 'Data nasabah diperbarui.');
    }

    public function resetPassword(Nasabah $nasabah)
    {
        $this->authorizeUnit($nasabah);

        $passwordBaru = Str::random(8);
        $nasabah->user->update(['password' => Hash::make($passwordBaru)]);

        return redirect()->route('pengurus.nasabah.index')
            ->with('success', "Password nasabah {$nasabah->nama} berhasil direset. Password baru: {$passwordBaru} (catat sekarang, tidak ditampilkan lagi).");
    }

    public function destroy(Nasabah $nasabah)
    {
        $this->authorizeUnit($nasabah);
        $nasabah->update(['status' => 'nonaktif']);
        return redirect()->route('pengurus.nasabah.index')->with('success', 'Nasabah dinonaktifkan.');
    }

    /**
     * Pastikan nasabah yang diakses benar-benar milik unit pengurus yang login.
     * Ini pertahanan penting: mencegah pengurus akses nasabah unit lain
     * lewat manipulasi URL (misal /pengurus/nasabah/5/edit).
     */
    private function authorizeUnit(Nasabah $nasabah): void
    {
        if ($nasabah->unit_id !== auth()->user()->unit_id) {
            abort(403, 'Nasabah ini bukan milik unit Anda.');
        }
    }
}
