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
  <div class="flex min-h-screen">
    <!-- IMPORTANT:
         - h-screen + sticky top-0 membuat sidebar tetap berada di viewport.
         - nav overflow-y-auto agar menu panjang bisa discroll sendiri.
         - mt-auto pada wrapper pengguna menjaga posisi tetap di dasar sidebar (viewport), bukan dasar halaman.
    -->
    <aside class="sidebar w-64 p-5 hidden md:flex md:flex-col flex-shrink-0 h-screen sticky top-0">
      <!-- Brand -->
      <div class="mb-6">
        <div class="flex items-center gap-3">
              <img src="{{ asset('logo_pupr.jpg') }}" class="h-8 w-8 rounded-full object-cover border border-white" alt="Logo">

          <div class="flex flex-col justify-center">
            <div class="text-sm font-semibold leading-tight">DSS Jalan</div>
            <div class="text-xs opacity-80 leading-tight">Provinsi Riau</div>
          </div>
        </div>
      </div>

      <!-- NAV: scrollable jika panjang -->
      <nav class="space-y-1 flex-1 overflow-y-auto no-scrollbar">
        <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
         <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linejoin="round" stroke-width="1.5" d="M10.5 8.75v-2c0-1.644 0-2.466-.454-3.019a2 2 0 0 0-.277-.277C9.216 3 8.394 3 6.75 3s-2.466 0-3.019.454a2 2 0 0 0-.277.277C3 4.284 3 5.106 3 6.75v2c0 1.644 0 2.466.454 3.019q.125.152.277.277c.553.454 1.375.454 3.019.454s2.466 0 3.019-.454q.152-.125.277-.277c.454-.553.454-1.375.454-3.019ZM7.75 15.5h-2c-.698 0-1.047 0-1.33.086a2 2 0 0 0-1.334 1.333C3 17.203 3 17.552 3 18.25s0 1.047.086 1.33a2 2 0 0 0 1.333 1.334C4.703 21 5.052 21 5.75 21h2c.698 0 1.047 0 1.33-.086a2 2 0 0 0 1.334-1.333c.086-.284.086-.633.086-1.331s0-1.047-.086-1.33a2 2 0 0 0-1.333-1.334c-.284-.086-.633-.086-1.331-.086ZM21 17.25v-2c0-1.644 0-2.466-.454-3.019a2 2 0 0 0-.277-.277c-.553-.454-1.375-.454-3.019-.454s-2.466 0-3.019.454a2 2 0 0 0-.277.277c-.454.553-.454 1.375-.454 3.019v2c0 1.644 0 2.466.454 3.019q.125.152.277.277c.553.454 1.375.454 3.019.454s2.466 0 3.019-.454q.152-.125.277-.277C21 19.716 21 18.894 21 17.25ZM18.25 3h-2c-.698 0-1.047 0-1.33.086a2 2 0 0 0-1.334 1.333c-.086.284-.086.633-.086 1.331s0 1.047.086 1.33a2 2 0 0 0 1.333 1.334c.284.086.633.086 1.331.086h2c.698 0 1.047 0 1.33-.086a2 2 0 0 0 1.334-1.333C21 6.797 21 6.448 21 5.75s0-1.047-.086-1.33a2 2 0 0 0-1.333-1.334C19.297 3 18.948 3 18.25 3Z"/></svg>
         <span>Dashboard</span>
        </a>

        @if(auth()->user()->isRole(['admin']))
          <a href="{{ route('users.index') }}" class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.928 19.634h2.138a1.165 1.165 0 0 0 1.116-1.555a6.85 6.85 0 0 0-6.117-3.95m0-2.759a3.664 3.664 0 0 0 3.665-3.664a3.664 3.664 0 0 0-3.665-3.674m-1.04 16.795a1.908 1.908 0 0 0 1.537-3.035a8.03 8.03 0 0 0-6.222-3.196a8.03 8.03 0 0 0-6.222 3.197a1.909 1.909 0 0 0 1.536 3.034zM9.34 11.485a4.16 4.16 0 0 0 4.15-4.161a4.151 4.151 0 0 0-8.302 0a4.16 4.16 0 0 0 4.151 4.16"/></svg>
            <span>Data Pengguna</span>
          </a>
        @endif

        @if(auth()->user()->isRole(['admin','staf']))
          <a href="{{ route('jalan.index') }}" class="nav-item {{ request()->routeIs('jalan.*') ? 'active' : '' }}">
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" fill-rule="evenodd" d="m12.065 21.243l-.006-.005zm.182-.274a29 29 0 0 0 3.183-3.392c2.04-2.563 3.281-5.09 3.365-7.337a6.8 6.8 0 1 0-13.591 0c.085 2.247 1.327 4.774 3.366 7.337a29 29 0 0 0 3.183 3.392q.166.15.247.218zm-.985 1.165S4 16.018 4 10a8 8 0 1 1 16 0c0 6.018-7.262 12.134-7.262 12.134c-.404.372-1.069.368-1.476 0M12 12.8a2.8 2.8 0 1 0 0-5.6a2.8 2.8 0 0 0 0 5.6m0 1.2a4 4 0 1 1 0-8a4 4 0 0 1 0 8"/></svg>
           <span>Data Jalan</span>
          </a>
        @endif

        @if(auth()->user()->isRole(['admin']))
          <a href="{{ route('kriteria.index') }}" class="nav-item {{ request()->routeIs('kriteria.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16"><path fill="currentColor" fill-rule="evenodd" d="m9.759 12.652l-1.8 2.25l-.78-.625l1.8-2.25A.1.1 0 0 0 9 11.965V8.362a1 1 0 0 1 .232-.64l4.631-5.558A.1.1 0 0 0 13.787 2H2.213a.1.1 0 0 0-.077.164l4.631 5.558a1 1 0 0 1 .232.64v5.853a.1.1 0 0 0 .178.062l.781.625c-.65.812-1.959.353-1.959-.687V8.362L1.368 2.804C.771 2.088 1.281 1 2.214 1h11.573c.932 0 1.442 1.088.845 1.804L10 8.362v3.603a1.1 1.1 0 0 1-.241.687"/></svg>
            <span>Data Kriteria</span>
          </a>

          <a href="{{ route('subkriteria.index') }}" class="nav-item {{ request()->routeIs('subkriteria.*') ? 'active' : '' }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 32 32"><path fill="currentColor" d="M16 24a1 1 0 0 1-.474-.12l-13-7l.948-1.76L16 21.864l12.526-6.744l.948 1.76l-13 7A1 1 0 0 1 16 24"/><path fill="currentColor" d="M16 30a1 1 0 0 1-.474-.12l-13-7l.948-1.76L16 27.864l12.526-6.744l.948 1.76l-13 7A1 1 0 0 1 16 30m0-12a1 1 0 0 1-.474-.12l-13-7a1 1 0 0 1 0-1.76l13-7a1 1 0 0 1 .948 0l13 7a1 1 0 0 1 0 1.76l-13 7A1 1 0 0 1 16 18M5.11 10L16 15.864L26.89 10L16 4.136z"/></svg>
            <span>Data Sub Kriteria</span>
          </a>
        @endif

        @if(auth()->user()->isRole(['admin','staf']))
          <a href="{{ route('penilaian.index') }}" class="nav-item {{ request()->routeIs('penilaian.*') ? 'active' : '' }}">
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M4.5 20.25a.76.76 0 0 1-.75-.75v-15a.75.75 0 0 1 1.5 0v15a.76.76 0 0 1-.75.75"/><path fill="currentColor" d="M19.5 20.25h-15a.75.75 0 0 1 0-1.5h15a.75.75 0 0 1 0 1.5M8 16.75a.76.76 0 0 1-.75-.75v-4a.75.75 0 0 1 1.5 0v4a.76.76 0 0 1-.75.75m3.5 0a.76.76 0 0 1-.75-.75V8a.75.75 0 0 1 1.5 0v8a.76.76 0 0 1-.75.75m3.5 0a.76.76 0 0 1-.75-.75v-4a.75.75 0 0 1 1.5 0v4a.76.76 0 0 1-.75.75m3.5 0a.76.76 0 0 1-.75-.75V8a.75.75 0 0 1 1.5 0v8a.76.76 0 0 1-.75.75"/></svg>
           <span>Data Penilaian</span>
          </a>
        @endif

        @if(auth()->user()->isRole(['admin','pimpinan','staf']))
          <a href="{{ route('hasil.index') }}" class="nav-item {{ request()->routeIs('hasil.*') ? 'active' : '' }}">
           <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="m3.25 16.75l4.793-4.793a1 1 0 0 1 1.414 0l2.586 2.586a1 1 0 0 0 1.414 0L19.75 8.25l.56-.56m-5.56-.44h4.5c.414 0 .79.168 1.06.44m.44 5.56v-4.5c0-.414-.168-.79-.44-1.06"/></svg>
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