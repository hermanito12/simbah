<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JenisSampah;
use Illuminate\Http\Request;

class JenisSampahController extends Controller
{
    public function index()
    {
        $jenisSampah = JenisSampah::orderBy('kategori')->orderBy('nama')->get();
        return view('admin.jenis-sampah.index', compact('jenisSampah'));
    }

    public function create()
    {
        return view('admin.jenis-sampah.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:Kertas,Plastik,Logam,Lain-lain'],
            'satuan' => ['required', 'string', 'max:20'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        JenisSampah::create($validated);

        return redirect()->route('admin.jenis-sampah.index')->with('success', 'Jenis sampah ditambahkan.');
    }

    public function edit(JenisSampah $jenisSampah)
    {
        return view('admin.jenis-sampah.edit', compact('jenisSampah'));
    }

    public function update(Request $request, JenisSampah $jenisSampah)
    {
        $validated = $request->validate([
            'nama' => ['required', 'string', 'max:255'],
            'kategori' => ['required', 'in:Kertas,Plastik,Logam,Lain-lain'],
            'satuan' => ['required', 'string', 'max:20'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $jenisSampah->update($validated);

        return redirect()->route('admin.jenis-sampah.index')->with('success', 'Jenis sampah diperbarui.');
    }

    public function destroy(JenisSampah $jenisSampah)
    {
        $jenisSampah->update(['status' => 'nonaktif']);
        return redirect()->route('admin.jenis-sampah.index')->with('success', 'Jenis sampah dinonaktifkan.');
    }
}
