<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // validasi input
        $credentials = $request->validate([
            'username' => ['required','string'],
            'password' => ['required']
        ]);

        // coba login pakai Laravel Auth
        if (Auth::attempt($credentials)) {
            // proteksi session fixation
            $request->session()->regenerate();

            // ambil user yang ter-autentikasi
            $user = Auth::user();
            
            session([
                'user_id' => $user->id,
                'user_name' => $user->name,
                'username' => $user->username,
                'role' => $user->role,
            ]);

            return redirect()->intended('/');
        }

        // jika gagal, kembalikan pesan error yang konsisten
        return back()->with('error', 'Username atau password salah!')->withInput();
    }

    public function logout(Request $request)
    {
        // logout dari guard
        Auth::logout();

        // invalidate session dan regen token
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}