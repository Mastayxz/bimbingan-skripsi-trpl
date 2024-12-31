<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Mahasiswa;
use App\Models\Dosen;

class PasswordController extends Controller
{
    /**
     * Update the user's password.
     */
    public function update(Request $request): RedirectResponse
    {
        // Validasi password yang dimasukkan
        $validated = $request->validateWithBag('updatePassword', [
            'current_password' => ['required', 'current_password'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        // Mengupdate password di tabel user
        $user = $request->user();
        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // Jika user memiliki relasi dengan mahasiswa, perbarui password di tabel mahasiswa
        if ($user->mahasiswa) {
            $user->mahasiswa->password = Hash::make($validated['password']);
            $user->mahasiswa->save();
        }

        // Jika user memiliki relasi dengan dosen, perbarui password di tabel dosen
        if ($user->dosen) {
            $user->dosen->password = Hash::make($validated['password']);
            $user->dosen->save();
        }

        return back()->with('status', 'password-updated');
    }
}
