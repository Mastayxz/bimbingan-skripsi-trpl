<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Cari mahasiswa berdasarkan email
        $mahasiswa = Mahasiswa::where('email', $request->email)->first();
        // Cari dosen berdasarkan email
        $dosen = Dosen::where('email', $request->email)->first();

        // Jika ditemukan mahasiswa atau dosen, kirimkan link reset password
        if ($mahasiswa) {
            // Anda bisa menambahkan logika di sini jika diperlukan
        } elseif ($dosen) {
            // Anda bisa menambahkan logika di sini jika diperlukan
        }

        // Kirimkan link reset password
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status == Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
