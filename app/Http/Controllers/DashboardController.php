<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Jalan;
use App\Models\Kriteria;
use App\Models\Penilaian;

class DashboardController extends Controller
{
    public function index()
    {

        $user = Auth::user();
        
        $totalUsers = User::where('status', 'aktif')->count();
        $totalJalan = Jalan::where('status', 'Aktif')->count();
        $totalKriteria = Kriteria::where('status', 'Aktif')->count();

        // hanya hitung penilaian yang sudah submitted (otomatis berubah jika ada perubahan)
        $totalPenilaian = Penilaian::where('status', 'Submitted')->count();
        // Ambil data profil user dari session (jika ada) — fallback demo
        $profile = [
            'name' => $user->name,
            'username' => $user->username,
            'role' => $user->role,
        ];

        return view('dashboard', compact(
            'user',
            'totalUsers',
            'totalJalan',
            'totalKriteria',
            'totalPenilaian',
            'profile',
        ));
    }

    public function logout(Request $request)
    {
        // bersihkan session yang relevan
        $request->session()->forget(['user_name','username','role','user_id']);
        $request->session()->flush();
        return redirect('/login'); // asumsikan ada halaman login, kalau tidak redirect ke /
    }
}