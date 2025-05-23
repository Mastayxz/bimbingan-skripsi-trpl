<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:mahasiswa,dosen',
            'identifier' => 'required|unique:mahasiswas,nim|unique:dosens,nip',
            'jurusan' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Membuat user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Tambahkan role pada user
        $user->assignRole($request->role);

        // Simpan data tambahan berdasarkan role
        if ($request->role === 'mahasiswa') {
            Mahasiswa::create([
                'user_id' => $user->id,
                'nim' => $request->identifier,
                'nama' => $request->name,
                'jurusan' => $request->jurusan,
            ]);
        } elseif ($request->role === 'dosen') {
            Dosen::create([
                'user_id' => $user->id,
                'nip' => $request->identifier,
                'nama' => $request->name,
                'jurusan' => $request->jurusan,
                'password' => Hash::make($request->password), // Enkripsi password
            ]);
        }

        // Trigger event untuk registrasi (opsional)
        event(new Registered($user));

        // Redirect ke halaman login dengan pesan sukses
        return redirect()
            ->route('login')
            ->with('success', 'Registrasi berhasil! Silakan login menggunakan akun Anda.');
    }
}
