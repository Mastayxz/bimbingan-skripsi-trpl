<?php

namespace App\Http\Controllers\Auth;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\User; // Menambahkan model User
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari mahasiswa atau dosen berdasarkan identifier
        $mahasiswa = Mahasiswa::where('nim', $credentials['identifier'])->first();
        $dosen = Dosen::where('nip', $credentials['identifier'])->first();

        // Cek jika pengguna ditemukan sebagai mahasiswa
        if ($mahasiswa && Hash::check($credentials['password'], $mahasiswa->password)) {
            $user = $mahasiswa->user;

            // Jika mahasiswa belum memiliki user, buatkan
            if (!$user) {
                $user = User::create([
                    'name' => $mahasiswa->nama,
                    'email' => $mahasiswa->email ?? $mahasiswa->nim . '@example.com', // Pastikan email valid
                    'password' => bcrypt($credentials['password']),
                ]);
                $user->assignRole('mahasiswa'); // Menetapkan role mahasiswa
                $mahasiswa->user_id = $user->id;
                $mahasiswa->save();
            }

            // Login pengguna
            Auth::login($user);
            return redirect()->route('dashboard.mahasiswa');
        }

        // Cek jika pengguna ditemukan sebagai dosen
        if ($dosen && Hash::check($credentials['password'], $dosen->password)) {
            $user = $dosen->user;

            // Jika dosen belum memiliki user, buatkan
            if (!$user) {
                $user = User::create([
                    'name' => $dosen->nama,
                    'email' => $dosen->email ?? $dosen->nip . '@example.com', // Pastikan email valid
                    'password' => bcrypt($credentials['password']),
                ]);
                $user->assignRole('dosen'); // Menetapkan role dosen
                $dosen->user_id = $user->id;
                $dosen->save();
            }
            if ($user->hasRole('admin')) {
                // Jika memiliki role admin, arahkan ke dashboard admin
                Auth::login($user);
                return redirect()->route('dashboard.admin');
            }
            // Login pengguna
            Auth::login($user);
            return redirect()->route('dashboard.dosen');
        }

        // Jika login gagal
        throw ValidationException::withMessages([
            'identifier' => __('The provided credentials are incorrect.'),
        ]);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
