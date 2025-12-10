@extends('layouts.app')

@section('title','Data Pengguna')
@section('page-title','Data Pengguna')

@section('content')
<div class="space-y-6">
  <div class="card bg-white p-6">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h2 class="text-lg font-semibold">Daftar Pengguna</h2>
        <div class="text-muted">Total {{ $totalAktif }} pengguna aktif dari {{ $totalSemua }} pengguna</div>
      </div>
      <div>
        <a href="{{ route('users.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-800 text-white rounded shadow">
          <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
          Tambah Pengguna
        </a>
      </div>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
      <div class="mb-4 text-sm text-green-700 bg-green-100 p-3 rounded">
        {{ session('success') }}
      </div>
    @endif

    <div class="mb-4">
      <form method="GET" action="{{ route('users.index') }}">
        <div class="flex gap-3">
          <input type="text" name="q" value="{{ old('q', $q ?? '') }}" placeholder="Cari nama atau username..." class="w-full p-3 border rounded bg-gray-50">
          <button type="submit" class="px-4 py-2 bg-white border rounded">Cari</button>
        </div>
      </form>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left">
        <thead class="text-sm text-gray-500 border-b">
          <tr>
            <th class="py-3 px-4">Username</th>
            <th class="py-3 px-4">Nama</th>
            <th class="py-3 px-4">Peran</th>
            <th class="py-3 px-4">Status</th>
            <th class="py-3 px-4 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="text-sm">
          @forelse($users as $user)
            <tr class="border-b last:border-b-0">
              <td class="py-4 px-4">{{ $user->username }}</td>
              <td class="py-4 px-4">{{ $user->name }}</td>
              <td class="py-4 px-4">
                @if($user->role == 'admin')
                  <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-700">admin</span>
                @elseif($user->role == 'pimpinan')
                  <span class="px-2 py-1 rounded text-xs bg-indigo-100 text-indigo-700">pimpinan</span>
                @else
                  <span class="px-2 py-1 rounded text-xs bg-blue-100 text-blue-700">{{ $user->role }}</span>
                @endif
              </td>
              <td class="py-4 px-4">
                @if($user->status == 'aktif')
                  <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">aktif</span>
                @else
                  <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">nonaktif</span>
                @endif
              </td>
              <td class="py-4 px-4 text-right">
                <a href="{{ route('users.edit', $user) }}" class="inline-block mr-2" title="Edit">
                  <svg class="h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536M3 21v-3.586a1 1 0 01.293-.707l11-11a1 1 0 011.414 0l3.586 3.586a1 1 0 010 1.414l-11 11A1 1 0 018.414 21H3z" stroke-width="1.5"/></svg>
                </a>

                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus pengguna ini?');">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="text-red-600" title="Hapus">
                    <svg class="h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7L5 7M10 11v6M14 11v6M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12" stroke-width="1.5"/></svg>
                  </button>
                </form>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="5" class="py-6 px-4 text-center text-gray-500">Tidak ada data pengguna.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="mt-4">
      {{ $users->links() }}
    </div>
  </div>
</div>
@endsection