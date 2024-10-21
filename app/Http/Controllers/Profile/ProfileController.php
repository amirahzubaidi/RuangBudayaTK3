<?php

namespace App\Http\Controllers\Profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile.index');
    }

    public function update(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore(Auth::id())],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Maksimal 10MB
        ]);

        // Ambil user yang sedang login
        $user = Auth::user();

        // Update data diri
        $user->name = $request->nama;
        $user->username = $request->username;
        $user->email = $request->email;

        // Jika ada foto baru yang diunggah
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('profile-pictures', 'public');
            $user->profile_picture = $photoPath;
        }

        // Simpan perubahan
        $user->save();

        // Redirect dengan pesan sukses
        return redirect()->route('profile.index')->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        // Validasi input
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        // Cek apakah kata sandi lama cocok
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Kata sandi lama tidak sesuai.']);
        }

        // Update kata sandi baru
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Kata sandi berhasil diperbarui.');
    }
}
