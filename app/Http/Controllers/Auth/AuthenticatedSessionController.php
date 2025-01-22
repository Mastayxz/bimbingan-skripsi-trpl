<?php

namespace App\Http\Controllers\Auth;

use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Support\Facades\RateLimiter;
use App\Models\User; // Menambahkan model User
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Cache;


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

        $identifier = $credentials['identifier'];

        // Cache key untuk percobaan login
        $cacheKey = 'login_attempts_' . $identifier;
        $maxAttempts = 3;
        $lockoutTime = 5; // dalam detik

        // Periksa apakah pengguna terkunci
        if (Cache::has($cacheKey . '_lockout')) {
            $secondsRemaining = Cache::get($cacheKey . '_lockout') - now()->timestamp;
            throw ValidationException::withMessages([
                'pesan' => __('Too many login attempts. Please try again in :seconds seconds.', [
                    'seconds' => $secondsRemaining,
                ]),
            ]);
        }

        $entity = Mahasiswa::where('nim', $identifier)->first() ??
            Dosen::where('nip', $identifier)->first();

        if ($entity && Hash::check($credentials['password'], $entity->password)) {
            // Reset percobaan login jika berhasil
            Cache::forget($cacheKey);
            Cache::forget($cacheKey . '_lockout');

            $user = User::where('mahasiswa_id', $entity->id)
                ->orWhere('dosen_id', $entity->id)
                ->first();

            if (!$user) {
                $user = User::create([
                    'name' => $entity->nama,
                    'email' => $entity->email ?? Str::slug($entity->nama, '.') . '@example.com',
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

        // Jika login gagal
        $attempts = Cache::get($cacheKey, 0) + 1;

        if ($attempts >= $maxAttempts) {
            // Set waktu lockout dan hitung sisa waktu
            $lockoutExpiration = now()->timestamp + $lockoutTime;
            Cache::put($cacheKey . '_lockout', $lockoutExpiration, $lockoutTime);
            Cache::forget($cacheKey); // Reset percobaan

            $secondsRemaining = $lockoutExpiration - now()->timestamp;

            // Kirimkan waktu lockout ke view
            return back()->withErrors([
                'pesan' => __('Too many login attempts. Please try again in :seconds seconds.', [
                    'seconds' => $secondsRemaining,
                ]),
            ])->with('lockout_time', $secondsRemaining);
        }

        // Simpan percobaan yang gagal
        Cache::put($cacheKey, $attempts, $lockoutTime);

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
