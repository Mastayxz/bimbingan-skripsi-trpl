<?php

namespace App\Http\Controllers\Auth;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use App\Models\User; // Menambahkan model User
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
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
        $credentials = $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cari user berdasarkan NIM/NIP di tabel mahasiswa atau dosen
        $mahasiswa = Mahasiswa::where('nim', $credentials['identifier'])->first();
        $dosen = Dosen::where('nip', $credentials['identifier'])->first();

        $user = $mahasiswa ? $mahasiswa->user : ($dosen ? $dosen->user : null);

        if (!$user || !Auth::attempt(['email' => $user->email, 'password' => $credentials['password']])) {
            throw ValidationException::withMessages([
                'identifier' => __('The provided credentials are incorrect.'),
            ]);
        }

        // Regenerate session to prevent session fixation attacks
        $request->session()->regenerate();

        // Cek role dan arahkan ke dashboard yang sesuai
        if ($user->hasRole('super-admin')) {
            return redirect()->route('dashboard.super-admin');
        }

        if ($user->hasRole('admin')) {
            return redirect()->route('dashboard.admin');
        }

        if ($user->hasRole('mahasiswa')) {
            return redirect()->route('dashboard.mahasiswa');
        }

        if ($user->hasRole('dosen')) {
            return redirect()->route('dashboard.dosen');
        }

        // Default redirect jika role tidak ditemukan
        return redirect()->route('dashboard');
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
