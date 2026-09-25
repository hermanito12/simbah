<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('unit')
            ->whereIn('role', ['admin', 'pengurus', 'kelurahan'])
            ->orderBy('role')
            ->orderBy('name')
            ->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $units = Unit::where('status', 'aktif')->orderBy('nama_unit')->get();
        return view('admin.users.create', compact('units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:50', 'alpha_dash', 'unique:users,username'],
            'role' => ['required', 'in:admin,pengurus,kelurahan'],
            'unit_id' => ['required_if:role,pengurus', 'nullable', 'exists:units,id'],
        ]);

        if ($validated['role'] !== 'pengurus') {
            $validated['unit_id'] = null;
        }

        $passwordAwal = Str::random(8);

        $user = User::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'email' => $validated['username'] . '@simbah.internal', // internal saja, tidak pernah ditampilkan
            'password' => Hash::make($passwordAwal),
            'role' => $validated['role'],
            'unit_id' => $validated['unit_id'],
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "Akun berhasil dibuat. Username: {$user->username} / Password awal: {$passwordAwal} (catat sekarang, tidak ditampilkan lagi).");
    }

    public function edit(User $user)
    {
        $units = Unit::where('status', 'aktif')->orderBy('nama_unit')->get();
        return view('admin.users.edit', compact('user', 'units'));
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'role' => ['required', 'in:admin,pengurus,kelurahan'],
            'unit_id' => ['required_if:role,pengurus', 'nullable', 'exists:units,id'],
        ]);

        if ($validated['role'] !== 'pengurus') {
            $validated['unit_id'] = null;
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil diperbarui.');
    }

    public function resetPassword(User $user)
    {
        $passwordBaru = Str::random(8);
        $user->update(['password' => Hash::make($passwordBaru)]);

        return redirect()->route('admin.users.index')
            ->with('success', "Password {$user->email} berhasil direset. Password baru: {$passwordBaru} (catat sekarang, tidak ditampilkan lagi).");
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        try {
            $user->delete();
        } catch (\Illuminate\Database\QueryException $e) {
            return back()->with('error', 'Akun ini tidak bisa dihapus karena masih terkait data transaksi. Nonaktifkan penggunaannya saja jika perlu.');
        }

        return redirect()->route('admin.users.index')->with('success', 'Akun berhasil dihapus.');
    }
}
