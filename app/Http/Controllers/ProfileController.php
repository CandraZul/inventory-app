<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\ProfileMahasiswa;
use App\Models\ProfileDosen;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil
     */
    public function index()
    {
        $user = Auth::user();

        return view('profile', [
            'user' => $user,
            'role' => $user->getRoleNames()->first(),
            'mahasiswaProfile' => $user->mahasiswaProfile ?? null,
            'dosenProfile' => $user->dosenProfile ?? null,
        ]);
    }

    /**
     * Update data profil
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $role = $user->getRoleNames()->first();

        // ================= VALIDASI =================
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'kontak' => 'nullable|string|max:20',
            'id_number' => 'nullable|string|max:30',
        ]);

        // ================= UPDATE USER =================
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        // ================= UPDATE PROFILE SESUAI ROLE =================
        if ($role === 'mahasiswa') {
            ProfileMahasiswa::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nim' => $request->id_number,
                    'kontak' => $request->kontak,
                ]
            );
        }

        if ($role === 'dosen') {
            ProfileDosen::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'nip' => $request->id_number,
                    'kontak' => $request->kontak,
                ]
            );
        }

        return redirect()->route('profile.index')
            ->with('success', 'Profil berhasil diperbarui');
    }
}
