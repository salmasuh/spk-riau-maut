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
use Carbon\Carbon;

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

        $duaBulanTerakhir = Carbon::now()->subMonths(2);
        $totalJalan2Bulan = Jalan::where('created_at', '>=', $duaBulanTerakhir)->count();

        // Ambil data profil user dari session (jika ada) — fallback demo
        $profile = [
            'name' => $user->name,
            'username' => $user->username,
            'role' => $user->role,
        ];
        // Data ringkasan fitur / metode untuk panel informasi
        $features = [
            'Manajemen data pengguna',
            'Manajemen data jalan',
            'Perhitungan MAUT',
            'Analisis prioritas'
        ];
        $methods = [
            'Multi Attribute Utility',
            'Weighted Scoring',
            'Normalisasi Data',
            'Ranking Prioritas'
        ];

        return view('dashboard', compact(
            'user',
            'totalUsers',
            'totalJalan',
            'totalKriteria',
            'totalPenilaian',
            'profile',
            'features',
            'methods',
            'totalJalan2Bulan'
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