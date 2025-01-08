<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Mahasiswa;
use App\Models\Dosen;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();
        $user->fill($request->validated());

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Update User table
        $user->save();

        // Update Mahasiswa table if user is mahasiswa
        if ($user->mahasiswa_id) {
            $mahasiswa = Mahasiswa::find($user->mahasiswa_id);
            if ($mahasiswa) {
                $mahasiswa->nama = $request->name;
                $mahasiswa->email = $request->email;
                // $mahasiswa->telepon = $request->telepon;
                $mahasiswa->save();
            }
        }

        // Update Dosen table if user is dosen
        if ($user->dosen_id) {
            $dosen = Dosen::find($user->dosen_id);
            if ($dosen) {
                $dosen->nama = $request->name;
                $dosen->email = $request->email;
                $dosen->save();
            }
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        // Delete related Mahasiswa and Dosen records
        if ($user->mahasiswa_id) {
            Mahasiswa::find($user->mahasiswa_id)->delete();
        }

        if ($user->dosen_id) {
            Dosen::find($user->dosen_id)->delete();
        }

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
