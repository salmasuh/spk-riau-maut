@extends('layouts.app')

@section('title','Dashboard')
@section('page-title','Dashboard')

@section('content')
<div class="space-y-6">
  <!-- greeting -->
  <div>
    <p class="text-gray-600">Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong></p>
  </div>

  <!-- metric cards (diperbaiki spacing & padding) -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
  <!-- Card 1 -->
  <div class="bg-blue-50 rounded-lg shadow-sm p-5 min-h-24">
    <div class="flex items-start justify-between">
      <!-- teks: beri ruang kanan agar tidak mepet ke ikon -->
      <div class="pr-4">
        <div class="text-sm text-gray-500">Total Pengguna</div>
        <div class="text-2xl font-bold mt-2">{{ number_format($totalUsers ?? 0) }}</div>
        <div class="text-xs text-gray-400 mt-1">Aktif</div>
      </div>

      <!-- ikon di kanan: bungkus dengan wadah putih dan padding -->
      <div class="flex-shrink-0 bg-white rounded-lg p-3 shadow-sm flex items-center justify-center">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
          <circle cx="12" cy="8" r="3" stroke-width="1.5"></circle>
          <path d="M5.5 20a6.5 6.5 0 0113 0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
      </div>
    </div>
  </div>

  <!-- Card 2 -->
  <div class="bg-green-50 rounded-lg shadow-sm p-5 min-h-24">
    <div class="flex items-start justify-between">
      <div class="pr-4">
        <div class="text-sm text-gray-500">Total Jalan</div>
        <div class="text-2xl font-bold mt-2">{{ $totalJalan ?? 0 }}</div>
        <div class="text-xs text-gray-400 mt-1">Aktif</div>
      </div>
      <div class="flex-shrink-0 bg-white rounded-lg p-3 shadow-sm flex items-center justify-center">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
          <path d="M12 11.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
          <path d="M12 21s7-4.5 7-10.5A7 7 0 105 10.5C5 16.5 12 21 12 21z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
      </div>
    </div>
  </div>

  <!-- Card 3 -->
  <div class="bg-purple-50 rounded-lg shadow-sm p-5 min-h-24">
    <div class="flex items-start justify-between">
      <div class="pr-4">
        <div class="text-sm text-gray-500">Total Kriteria</div>
        <div class="text-2xl font-bold mt-2">{{ $totalKriteria ?? 0 }}</div>
        <div class="text-xs text-gray-400 mt-1">Aktif</div>
      </div>
      <div class="flex-shrink-0 bg-white rounded-lg p-3 shadow-sm flex items-center justify-center">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
          <path d="M3 5h18" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
          <path d="M7 11h10" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
          <path d="M10 17h4" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
          <path d="M12 12v6" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
        </svg>
      </div>
    </div>
  </div>

  <!-- Card 4 -->
  <div class="bg-green-50 rounded-lg shadow-sm p-5 min-h-24">
    <div class="flex items-start justify-between">
      <div class="pr-4">
        <div class="text-sm text-gray-500">Data Penilaian</div>
        <div class="text-2xl font-bold mt-2">{{ number_format($totalPenilaian ?? 0) }}</div>
        <div class="text-xs text-gray-400 mt-1">Submitted</div>
      </div>
      <div class="flex-shrink-0 bg-white rounded-lg p-3 shadow-sm flex items-center justify-center">
        <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
          <rect x="3.5" y="10" width="3" height="10" rx="0.5" stroke-width="1.4"></rect>
          <rect x="10.25" y="6" width="3" height="14" rx="0.5" stroke-width="1.4"></rect>
          <rect x="16.75" y="3" width="3" height="17" rx="0.5" stroke-width="1.4"></rect>
        </svg>
      </div>
    </div>
  </div>
</div>


  <!-- main panels grid -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2">
      <div class="card bg-white p-5">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-semibold">Informasi Sistem</h3>
          <div class="text-sm text-gray-400">Sistem Pendukung Keputusan Infrastruktur Jalan Provinsi Riau</div>
        </div>

        <p class="text-gray-600 mb-4">
          Sistem ini membantu dalam pengambilan keputusan untuk menentukan prioritas proyek perbaikan atau pembangunan infrastruktur jalan provinsi berdasarkan metode Multi Attribute Utility Theory (MAUT). Dengan menggunakan data komprehensif dan analisis mendalam, sistem ini memberikan rekomendasi yang objektif dan terukur.
        </p>

        <div class="grid grid-cols-1 gap-4 mt-3">
          <div class="p-4 bg-gray-50 rounded">
            <h4 class="font-semibold mb-2">Tahapan Metode</h4>
            <ul class="text-sm text-gray-700 list-disc list-inside space-y-1">
              <li>Membuat matriks keputusan</li>
              <li>Normalisasi matriks keputusan</li>
              <li>Menentukan matriks utilitas (U)</li>
              <li>Menghitung utilitas akhir (U<sub>i</sub>)</li>
              <li>Perangkingan — nilai utilitas akhir yang terbesar adalah alternatif yang baik</li>
            </ul>
          </div>
        </div>
      </div>
    </div>

    <!-- right column -->
    <div class="space-y-4">
      <div class="card bg-white p-4">
        <h4 class="font-semibold mb-2">Akses Cepat</h4>
        <p class="text-sm text-gray-500 mb-3">Menu sesuai peran Anda</p>
        <div class="space-y-2">

            {{-- ADMIN: akses semua --}}
            @if(Auth::user()->role == 'admin')
                <a href="{{ route('users.index') }}" class="block p-3 bg-gray-50 rounded flex items-center gap-3">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                      <circle cx="12" cy="8" r="3" stroke-width="1.5"></circle>
                      <path d="M5.5 20a6.5 6.5 0 0113 0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div>Kelola Pengguna</div>
                </a>
                <a href="{{ route('jalan.index') }}" class="block p-3 bg-gray-50 rounded flex items-center gap-3">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                      <path d="M12 11.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M12 21s7-4.5 7-10.5A7 7 0 105 10.5C5 16.5 12 21 12 21z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div>Kelola Jalan</div>
                </a>
                <a href="{{ route('kriteria.index') }}" class="block p-3 bg-gray-50 rounded flex items-center gap-3">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                      <path d="M3 5h18" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M7 11h10" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M10 17h4" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M12 12v6" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div>Kelola Kriteria</div>
                </a>
            @endif

            {{-- STAF LAPANGAN: jalan, penilaian, hasil --}}
            @if(Auth::user()->role == 'staf')
                <a href="{{ route('jalan.index') }}" class="block p-3 bg-gray-50 rounded flex items-center gap-3">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                      <path d="M12 11.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M12 21s7-4.5 7-10.5A7 7 0 105 10.5C5 16.5 12 21 12 21z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div>Kelola Jalan</div>
                </a>
                <a href="{{ route('penilaian.index') }}" class="block p-3 bg-gray-50 rounded flex items-center gap-3">
                   <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                      <rect x="3.5" y="10" width="3" height="10" rx="0.5" stroke-width="1.4"></rect>
                      <rect x="10.25" y="6" width="3" height="14" rx="0.5" stroke-width="1.4"></rect>
                      <rect x="16.75" y="3" width="3" height="17" rx="0.5" stroke-width="1.4"></rect>
                    </svg>
                    <div>Input Penilaian</div>
                </a>
                <a href="{{ route('hasil.index') }}" class="block p-3 bg-gray-50 rounded flex items-center gap-3">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                      <path d="M3 17l6-6 4 4 8-8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M21 7v6h-6" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div>Hasil Prioritas</div>
                </a>
            @endif

            {{-- PIMPINAN: hanya hasil --}}
            @if(Auth::user()->role == 'pimpinan')
                <a href="{{ route('hasil.index') }}" class="block p-3 bg-gray-50 rounded flex items-center gap-3">
                    <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor" aria-hidden="true">
                      <path d="M3 17l6-6 4 4 8-8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
                      <path d="M21 7v6h-6" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path>
                    </svg>
                    <div>Hasil Prioritas</div>
                </a>
            @endif
        </div>
    </div>

      <div class="card bg-white p-4">
          <h4 class="font-semibold mb-2">Profil Anda</h4>
          <div class="text-sm text-gray-600">
              <div class="mb-2">
                  <span class="text-gray-500">Nama</span>
                  <div class="font-medium">{{ Auth::user()->name }}</div>
              </div>
              <div class="mb-2">
                  <span class="text-gray-500">Username</span>
                  <div class="font-medium">{{ Auth::user()->username }}</div>
              </div>
              <div class="mb-2">
                  <span class="text-gray-500">Peran</span>
                  <div class="font-medium text-uppercase">
                      {{ ucfirst(Auth::user()->role) }}
                  </div>
              </div>
          </div>
      </div>

    </div>
  </div>
</div>
@endsection