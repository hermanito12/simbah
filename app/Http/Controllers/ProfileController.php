<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = auth()->user();
        $nasabah = $user->role === 'nasabah'
            ? Nasabah::where('user_id', $user->id)->first()
            : null;

        return view('profile.edit', compact('user', 'nasabah'));
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $rules = ['name' => ['required', 'string', 'max:255']];

        if ($user->role === 'nasabah') {
            $rules['alamat'] = ['required', 'string', 'max:255'];
        }

        $validated = $request->validate($rules);
        $user->update(['name' => $validated['name']]);

        if ($user->role === 'nasabah') {
            $nasabah = Nasabah::where('user_id', $user->id)->first();
            if ($nasabah) {
                $nasabah->update([
                    'nama' => $validated['name'],
                    'alamat' => $validated['alamat'],
                ]);
            }
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'password_lama' => ['required'],
            'password_baru' => ['required', 'confirmed', Password::min(6)],
        ]);

        $user = auth()->user();

        if (!Hash::check($validated['password_lama'], $user->password)) {
            return back()->withErrors(['password_lama' => 'Password lama tidak sesuai.']);
        }

        $user->update(['password' => Hash::make($validated['password_baru'])]);

        return back()->with('success', 'Password berhasil diubah.');
    }
}
