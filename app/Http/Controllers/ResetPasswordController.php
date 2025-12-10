<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class ResetPasswordController extends Controller
{
    // Tampilkan form reset password
    public function showForm()
    {
        return view('auth.reset-password');
    }

    // Proses simpan password baru
    public function update(Request $request)
    {
        // Validasi input dasar
        $request->validate([
            'username'              => ['required','string'],
            'password'              => ['required', 'string', 'min:8', 'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/', 'confirmed'],
            'password_confirmation' => ['required']
        ]);

        // Cek apakah username terdaftar
        $user = User::where('username', $request->input('username'))->first();

        if (! $user) {
            // Kembalikan dengan error untuk field username
            return back()
                ->withInput($request->only('username'))
                ->withErrors(['username' => 'Username tidak terdaftar.']);
        }

        // Update password (hashed)
        $user->password = Hash::make($request->input('password'));
        // opsional: catat waktu perubahan password
        if (Schema::hasColumn($user->getTable(), 'password_changed_at')) {
            $user->password_changed_at = now();
        }
        $user->save();

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('login')->with('status', 'Password berhasil diubah. Silakan login dengan password baru.');
    }

    // Endpoint AJAX: cek username (mengembalikan JSON)
    public function checkUsername(Request $request)
    {
        $username = (string) $request->query('username', '');
        if ($username === '') {
            return response()->json(['exists' => false, 'message' => 'Masukkan username.']);
        }

        $exists = User::where('username', $username)->exists();

        return response()->json([
            'exists' => $exists,
            'message' => $exists ? 'Username terdaftar.' : 'Username tidak ditemukan.'
        ]);
    }
}