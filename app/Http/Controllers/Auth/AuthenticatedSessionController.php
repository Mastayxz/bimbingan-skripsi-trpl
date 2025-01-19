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
        $credentials = $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
        ]);

        $entity = Mahasiswa::where('nim', $credentials['identifier'])->first() ??
            Dosen::where('nip', $credentials['identifier'])->first();

        if ($entity && Hash::check($credentials['password'], $entity->password)) {
            $user = User::where('mahasiswa_id', $entity->id)
                ->orWhere('dosen_id', $entity->id)
                ->first();

            if (!$user) {
                $user = User::create([
                    'name' => $entity->nama,
                    'email' => $entity->email ?? strtolower($entity->nama) . '@gmail.com',
                    'password' => bcrypt($credentials['password']),
                    'mahasiswa_id' => $entity instanceof Mahasiswa ? $entity->id : null,
                    'dosen_id' => $entity instanceof Dosen ? $entity->id : null,
                ]);

                $user->assignRole($entity instanceof Mahasiswa ? 'mahasiswa' : 'dosen');
            }

            Auth::login($user);
            return redirect()->route(
                $user->hasRole('mahasiswa') ? 'dashboard.mahasiswa' : ($user->hasRole('dosen') ? 'dashboard.dosen' : 'dashboard.admin')
            );
        }

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
