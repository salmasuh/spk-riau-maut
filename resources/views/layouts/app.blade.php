<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Dashboard') - DSS Jalan</title>
  <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body { font-family: Inter, ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial; }
    .sidebar { background: linear-gradient(180deg,#053b78,#0b4d96); color: #fff; }
    .sidebar .nav-item { padding: 12px 18px; border-radius: 8px; display:flex; align-items:center; gap:10px; color:#e6f0ff; text-decoration:none; }
    .sidebar .nav-item.active { background: rgba(255,255,255,0.06); color:#fff; }
    .avatar-badge { height:42px; width:42px; border-radius:8px; background:#063a78; display:flex; align-items:center; justify-content:center; color:white; font-weight:700; }
    .no-scrollbar::-webkit-scrollbar { width: 6px; }
    .no-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.06); border-radius: 6px; }
  </style>
  @stack('styles')
</head>
<body class="bg-gray-50">
  <div class="flex">
    <!-- IMPORTANT:
         - h-screen + sticky top-0 membuat sidebar tetap berada di viewport.
         - nav overflow-y-auto agar menu panjang bisa discroll sendiri.
         - mt-auto pada wrapper pengguna menjaga posisi tetap di dasar sidebar (viewport), bukan dasar halaman.
    -->
    <aside class="sidebar w-64 p-6 hidden md:flex md:flex-col flex-shrink-0 h-screen sticky top-0">
      <!-- Brand -->
      <div class="mb-6">
        <div class="flex items-center gap-3">
              <img src="{{ asset('logo_pupr.jpg') }}" class="h-16 w-16 rounded-full object-cover border border-white" alt="Logo">

          <div class="flex flex-col justify-center">
            <div class="text-sm font-semibold leading-tight">DSS Jalan</div>
            <div class="text-xs opacity-80 leading-tight">Provinsi Riau</div>
          </div>
        </div>
      </div>

      <!-- NAV: scrollable jika panjang -->
      <nav class="space-y-2 flex-1 overflow-y-auto no-scrollbar">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
          <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="3" width="8" height="8" rx="1.5" stroke-width="1.5"></rect><rect x="13" y="3" width="8" height="8" rx="1.5" stroke-width="1.5"></rect><rect x="3" y="13" width="8" height="8" rx="1.5" stroke-width="1.5"></rect><rect x="13" y="13" width="8" height="8" rx="1.5" stroke-width="1.5"></rect></svg>
          <span>Dashboard</span>
        </a>

        @if(auth()->user()->isRole(['admin']))
          <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"><circle cx="12" cy="8" r="3" stroke-width="1.5"></circle><path d="M5.5 20a6.5 6.5 0 0113 0" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            <span>Data Pengguna</span>
          </a>
        @endif

        @if(auth()->user()->isRole(['admin','staf']))
          <a href="{{ route('jalan.index') }}" class="nav-item {{ request()->routeIs('jalan.*') ? 'active' : '' }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 11.5a2.5 2.5 0 100-5 2.5 2.5 0 000 5z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 21s7-4.5 7-10.5A7 7 0 105 10.5C5 16.5 12 21 12 21z" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            <span>Data Jalan</span>
          </a>
        @endif

        @if(auth()->user()->isRole(['admin']))
          <a href="{{ route('kriteria.index') }}" class="nav-item {{ request()->routeIs('kriteria.*') ? 'active' : '' }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 5h18" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path><path d="M7 11h10" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path><path d="M10 17h4" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path><path d="M12 12v6" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            <span>Data Kriteria</span>
          </a>

          <a href="{{ route('subkriteria.index') }}" class="nav-item {{ request()->routeIs('subkriteria.*') ? 'active' : '' }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3" y="7" width="18" height="3" rx="1" stroke-width="1.2"></rect><rect x="5" y="12" width="14" height="3" rx="1" stroke-width="1.2"></rect><rect x="7" y="17" width="10" height="3" rx="1" stroke-width="1.2"></rect></svg>
            <span>Data Sub Kriteria</span>
          </a>
        @endif

        @if(auth()->user()->isRole(['admin','staf']))
          <a href="{{ route('penilaian.index') }}" class="nav-item {{ request()->routeIs('penilaian.*') ? 'active' : '' }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"><rect x="3.5" y="10" width="3" height="10" rx="0.5" stroke-width="1.4"></rect><rect x="10.25" y="6" width="3" height="14" rx="0.5" stroke-width="1.4"></rect><rect x="16.75" y="3" width="3" height="17" rx="0.5" stroke-width="1.4"></rect></svg>
            <span>Data Penilaian</span>
          </a>
        @endif

        @if(auth()->user()->isRole(['admin','pimpinan','staf']))
          <a href="{{ route('hasil.index') }}" class="nav-item {{ request()->routeIs('hasil.*') ? 'active' : '' }}">
            <svg class="h-5 w-5 flex-shrink-0" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M3 17l6-6 4 4 8-8" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path><path d="M21 7v6h-6" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"></path></svg>
            <span>Hasil Akhir Prioritas</span>
          </a>
        @endif
      </nav>

      <!-- USER: selalu berada di dasar sidebar viewport -->
      <div class="mt-auto">
        <div class="bg-white/5 p-4 rounded-lg">
          <div class="text-sm text-white opacity-90 font-medium">Pengguna</div>
          <div class="text-white font-semibold mt-2">{{ Auth::user()->name }}</div>
          <div class="text-xs opacity-80">{{ ucfirst(Auth::user()->role) }}</div>
          <div class="mt-4">
            <a href="#" class="block bg-transparent border border-white/10 text-white text-sm py-2 px-3 rounded">Profil</a>
            <form method="POST" action="{{ route('logout') }}" class="mt-3">
              @csrf
              <button type="submit" class="w-full bg-red-600 text-white py-2 rounded text-sm">Logout</button>
            </form>
          </div>
        </div>
      </div>
    </aside>

    <!-- MAIN: konten akan discroll secara normal, sidebar tetap di tempat -->
    <main class="flex-1 p-6">
      <header class="flex items-center justify-between mb-6">
        <div>
          <div class="text-sm text-gray-500">Dinas PUPRPKPP Provinsi Riau</div>
          <h1 class="text-2xl font-bold">@yield('page-title','Dashboard')</h1>
        </div>
        <div class="flex items-center gap-4">
          <div class="text-sm text-gray-600 hidden sm:block">Hai,<strong>{{ Auth::user()->name }}</strong></div>
          <button class="rounded-full p-2 bg-white shadow"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6 6 0 10-12 0v3.159c0 .538-.214 1.055-.595 1.436L4 17h5" stroke-width="1.5"/></svg></button>
          <button class="rounded-full p-2 bg-white shadow"><svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor"><path d="M12 4v16m8-8H4" stroke-width="1.5"/></svg></button>
        </div>
      </header>

      <div class="content">
        @yield('content')
      </div>
    </main>
  </div>
  @stack('scripts')
</body>
</html>