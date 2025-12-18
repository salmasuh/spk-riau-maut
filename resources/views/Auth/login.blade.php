<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Masuk Sistem - DSS</title>
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
<link rel="icon" href="{{ asset('favicon.png') }}">
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
  <div class="w-full max-w-md">
    <div class="bg-white rounded-lg shadow-lg p-8">
      <div class="flex justify-center mb-4">
        <img src="{{ asset('logo_pupr.jpg') }}" class="h-16" alt="Logo">
    </div>

      <h2 class="text-2xl font-semibold text-center mb-2">Masuk Sistem</h2>
      <p class="text-center text-sm text-gray-500 mb-6">Sistem Pendukung Keputusan Infrastruktur Jalan Provinsi Riau</p>

        @if(session('error'))
    <div style="color:red; margin-bottom:10px;">
        {{ session('error') }}
    </div>
    @endif
    <form method="POST" action="{{ route('login.submit') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm">Username</label>
            <input type="text" name="username" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block text-sm">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>

        <button type="submit"
            class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
            Login
        </button>
    </form>

      <div class="text-center mt-4">
        <a href="{{ route('password.reset.form') }}" class="text-sm text-blue-600 hover:text-blue-800">
            Lupa Password?
        </a>
      </div>

      <hr class="my-6">
      <div class="text-center text-xs text-gray-500">
        Sistem Pendukung Keputusan (SPK) merupakan suatu sistem informasi spesifik yang ditujukan untuk membantu manajemen dalam mengambil keputusan yang berkaitan dengan persoalan yang bersifat semi terstruktur.
      </div>
    </div>

    <p class="text-center text-xs text-gray-500 mt-4">© Dinas PUPRPKPP Provinsi Riau 2025</p>
  </div>
</body>
</html>