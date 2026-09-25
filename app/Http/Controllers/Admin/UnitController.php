<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::latest()->get();
        return view('admin.units.index', compact('units'));
    }

    public function create()
    {
        return view('admin.units.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_unit' => ['required', 'string', 'max:255'],
            'tingkat' => ['required', 'in:RT,RW'],
            'alamat' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        Unit::create($validated);

        return redirect()->route('admin.units.index')->with('success', 'Unit berhasil ditambahkan.');
    }

    public function edit(Unit $unit)
    {
        return view('admin.units.edit', compact('unit'));
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'nama_unit' => ['required', 'string', 'max:255'],
            'tingkat' => ['required', 'in:RT,RW'],
            'alamat' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:aktif,nonaktif'],
        ]);

        $unit->update($validated);

        return redirect()->route('admin.units.index')->with('success', 'Unit berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        $unit->update(['status' => 'nonaktif']);
        return redirect()->route('admin.units.index')->with('success', 'Unit dinonaktifkan.');
    }
}
