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
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
          <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.928 19.634h2.138a1.165 1.165 0 0 0 1.116-1.555a6.85 6.85 0 0 0-6.117-3.95m0-2.759a3.664 3.664 0 0 0 3.665-3.664a3.664 3.664 0 0 0-3.665-3.674m-1.04 16.795a1.908 1.908 0 0 0 1.537-3.035a8.03 8.03 0 0 0-6.222-3.196a8.03 8.03 0 0 0-6.222 3.197a1.909 1.909 0 0 0 1.536 3.034zM9.34 11.485a4.16 4.16 0 0 0 4.15-4.161a4.151 4.151 0 0 0-8.302 0a4.16 4.16 0 0 0 4.151 4.16"/>
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
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
          <path fill="currentColor" fill-rule="evenodd" d="m12.065 21.243l-.006-.005zm.182-.274a29 29 0 0 0 3.183-3.392c2.04-2.563 3.281-5.09 3.365-7.337a6.8 6.8 0 1 0-13.591 0c.085 2.247 1.327 4.774 3.366 7.337a29 29 0 0 0 3.183 3.392q.166.15.247.218zm-.985 1.165S4 16.018 4 10a8 8 0 1 1 16 0c0 6.018-7.262 12.134-7.262 12.134c-.404.372-1.069.368-1.476 0M12 12.8a2.8 2.8 0 1 0 0-5.6a2.8 2.8 0 0 0 0 5.6m0 1.2a4 4 0 1 1 0-8a4 4 0 0 1 0 8"/>
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
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16">
          <path fill="currentColor" fill-rule="evenodd" d="m9.759 12.652l-1.8 2.25l-.78-.625l1.8-2.25A.1.1 0 0 0 9 11.965V8.362a1 1 0 0 1 .232-.64l4.631-5.558A.1.1 0 0 0 13.787 2H2.213a.1.1 0 0 0-.077.164l4.631 5.558a1 1 0 0 1 .232.64v5.853a.1.1 0 0 0 .178.062l.781.625c-.65.812-1.959.353-1.959-.687V8.362L1.368 2.804C.771 2.088 1.281 1 2.214 1h11.573c.932 0 1.442 1.088.845 1.804L10 8.362v3.603a1.1 1.1 0 0 1-.241.687"/>
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
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
          <path fill="currentColor" d="M4.5 20.25a.76.76 0 0 1-.75-.75v-15a.75.75 0 0 1 1.5 0v15a.76.76 0 0 1-.75.75"/><path fill="currentColor" d="M19.5 20.25h-15a.75.75 0 0 1 0-1.5h15a.75.75 0 0 1 0 1.5M8 16.75a.76.76 0 0 1-.75-.75v-4a.75.75 0 0 1 1.5 0v4a.76.76 0 0 1-.75.75m3.5 0a.76.76 0 0 1-.75-.75V8a.75.75 0 0 1 1.5 0v8a.76.76 0 0 1-.75.75m3.5 0a.76.76 0 0 1-.75-.75v-4a.75.75 0 0 1 1.5 0v4a.76.76 0 0 1-.75.75m3.5 0a.76.76 0 0 1-.75-.75V8a.75.75 0 0 1 1.5 0v8a.76.76 0 0 1-.75.75"/>
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
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.928 19.634h2.138a1.165 1.165 0 0 0 1.116-1.555a6.85 6.85 0 0 0-6.117-3.95m0-2.759a3.664 3.664 0 0 0 3.665-3.664a3.664 3.664 0 0 0-3.665-3.674m-1.04 16.795a1.908 1.908 0 0 0 1.537-3.035a8.03 8.03 0 0 0-6.222-3.196a8.03 8.03 0 0 0-6.222 3.197a1.909 1.909 0 0 0 1.536 3.034zM9.34 11.485a4.16 4.16 0 0 0 4.15-4.161a4.151 4.151 0 0 0-8.302 0a4.16 4.16 0 0 0 4.151 4.16"/>
                  </svg>
                    <div>Kelola Pengguna</div>
                </a>
                <a href="{{ route('jalan.index') }}" class="block p-3 bg-gray-50 rounded flex items-center gap-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor" fill-rule="evenodd" d="m12.065 21.243l-.006-.005zm.182-.274a29 29 0 0 0 3.183-3.392c2.04-2.563 3.281-5.09 3.365-7.337a6.8 6.8 0 1 0-13.591 0c.085 2.247 1.327 4.774 3.366 7.337a29 29 0 0 0 3.183 3.392q.166.15.247.218zm-.985 1.165S4 16.018 4 10a8 8 0 1 1 16 0c0 6.018-7.262 12.134-7.262 12.134c-.404.372-1.069.368-1.476 0M12 12.8a2.8 2.8 0 1 0 0-5.6a2.8 2.8 0 0 0 0 5.6m0 1.2a4 4 0 1 1 0-8a4 4 0 0 1 0 8"/>
                  </svg>           
                    <div>Kelola Jalan</div>
                </a>
                <a href="{{ route('kriteria.index') }}" class="block p-3 bg-gray-50 rounded flex items-center gap-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16">
                    <path fill="currentColor" fill-rule="evenodd" d="m9.759 12.652l-1.8 2.25l-.78-.625l1.8-2.25A.1.1 0 0 0 9 11.965V8.362a1 1 0 0 1 .232-.64l4.631-5.558A.1.1 0 0 0 13.787 2H2.213a.1.1 0 0 0-.077.164l4.631 5.558a1 1 0 0 1 .232.64v5.853a.1.1 0 0 0 .178.062l.781.625c-.65.812-1.959.353-1.959-.687V8.362L1.368 2.804C.771 2.088 1.281 1 2.214 1h11.573c.932 0 1.442 1.088.845 1.804L10 8.362v3.603a1.1 1.1 0 0 1-.241.687"/>
                  </svg>            
                    <div>Kelola Kriteria</div>
                </a>
            @endif

            {{-- STAF LAPANGAN: jalan, penilaian, hasil --}}
            @if(Auth::user()->role == 'staf')
                <a href="{{ route('jalan.index') }}" class="block p-3 bg-gray-50 rounded flex items-center gap-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor" fill-rule="evenodd" d="m12.065 21.243l-.006-.005zm.182-.274a29 29 0 0 0 3.183-3.392c2.04-2.563 3.281-5.09 3.365-7.337a6.8 6.8 0 1 0-13.591 0c.085 2.247 1.327 4.774 3.366 7.337a29 29 0 0 0 3.183 3.392q.166.15.247.218zm-.985 1.165S4 16.018 4 10a8 8 0 1 1 16 0c0 6.018-7.262 12.134-7.262 12.134c-.404.372-1.069.368-1.476 0M12 12.8a2.8 2.8 0 1 0 0-5.6a2.8 2.8 0 0 0 0 5.6m0 1.2a4 4 0 1 1 0-8a4 4 0 0 1 0 8"/>
                  </svg>           
                    <div>Kelola Jalan</div>
                </a>
                <a href="{{ route('penilaian.index') }}" class="block p-3 bg-gray-50 rounded flex items-center gap-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="currentColor" d="M4.5 20.25a.76.76 0 0 1-.75-.75v-15a.75.75 0 0 1 1.5 0v15a.76.76 0 0 1-.75.75"/><path fill="currentColor" d="M19.5 20.25h-15a.75.75 0 0 1 0-1.5h15a.75.75 0 0 1 0 1.5M8 16.75a.76.76 0 0 1-.75-.75v-4a.75.75 0 0 1 1.5 0v4a.76.76 0 0 1-.75.75m3.5 0a.76.76 0 0 1-.75-.75V8a.75.75 0 0 1 1.5 0v8a.76.76 0 0 1-.75.75m3.5 0a.76.76 0 0 1-.75-.75v-4a.75.75 0 0 1 1.5 0v4a.76.76 0 0 1-.75.75m3.5 0a.76.76 0 0 1-.75-.75V8a.75.75 0 0 1 1.5 0v8a.76.76 0 0 1-.75.75"/>
                  </svg>           
                    <div>Input Penilaian</div>
                </a>
                <a href="{{ route('hasil.index') }}" class="block p-3 bg-gray-50 rounded flex items-center gap-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m3.25 16.75l4.793-4.793a1 1 0 0 1 1.414 0l2.586 2.586a1 1 0 0 0 1.414 0L19.75 8.25l.56-.56m-5.56-.44h4.5c.414 0 .79.168 1.06.44m.44 5.56v-4.5c0-.414-.168-.79-.44-1.06"/>
                  </svg>           
                    <div>Hasil Prioritas</div>
                </a>
            @endif

            {{-- PIMPINAN: hanya hasil --}}
            @if(Auth::user()->role == 'pimpinan')
                <a href="{{ route('hasil.index') }}" class="block p-3 bg-gray-50 rounded flex items-center gap-3">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m3.25 16.75l4.793-4.793a1 1 0 0 1 1.414 0l2.586 2.586a1 1 0 0 0 1.414 0L19.75 8.25l.56-.56m-5.56-.44h4.5c.414 0 .79.168 1.06.44m.44 5.56v-4.5c0-.414-.168-.79-.44-1.06"/>
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