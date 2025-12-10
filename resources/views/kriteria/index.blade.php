@extends('layouts.app')

@section('title','Data Kriteria')
@section('page-title','Data Kriteria')

@section('content')
<div class="card bg-white p-6">
  <div class="flex items-center justify-between mb-4">
    <div>
      <h2 class="text-lg font-semibold">Daftar Kriteria</h2>
      <div class="text-sm text-gray-500">Kelola kriteria penilaian MAUT</div>
      <div class="text-sm text-gray-400 mt-1">Total {{ $kriterias->total() }} kriteria (Total Bobot Aktif: {{ number_format($totalBobotAktif,4) }})</div>
      <div class="text-sm text-gray-400 mt-1">Sisa bobot yang masih dapat digunakan: {{ number_format($sisaBobot ?? 1, 4) }}</div>
    </div>

    <div>
      <a href="{{ route('kriteria.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-800 text-white rounded shadow">
        + Tambah Kriteria
      </a>
    </div>
  </div>

  @if(session('success'))
    <div class="mb-4 text-sm text-green-700 bg-green-100 p-3 rounded">{{ session('success') }}</div>
  @endif

  <div class="mb-4">
    <form method="GET" action="{{ route('kriteria.index') }}">
      <div class="flex gap-3">
        <input type="text" name="q" value="{{ old('q', $q ?? '') }}" placeholder="Cari nama atau deskripsi kriteria..." class="w-full p-3 border rounded bg-gray-50">
        <button type="submit" class="px-4 py-2 bg-white border rounded">Cari</button>
      </div>
    </form>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-left">
      <thead class="text-sm text-gray-500 border-b">
        <tr>
          <th class="py-3 px-4">Nama Kriteria</th>
          <th class="py-3 px-4">Deskripsi</th>
          <th class="py-3 px-4">Bobot</th>
          <th class="py-3 px-4">Tipe</th>
          <th class="py-3 px-4">Status</th>
          <th class="py-3 px-4 text-right">Aksi</th>
        </tr>
      </thead>
      <tbody class="text-sm">
        @forelse($kriterias as $k)
          <tr class="border-b last:border-b-0">
            <td class="py-4 px-4">{{ $k->nama }}</td>
            <td class="py-4 px-4">{{ $k->deskripsi }}</td>
            <td class="py-4 px-4">{{ number_format($k->bobot,4) }}</td>
            <td class="py-4 px-4">
              <span class="px-2 py-1 rounded text-xs bg-gray-100">{{ $k->tipe }}</span>
            </td>
            <td class="py-4 px-4">
              @if($k->status === 'aktif')
                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-700">aktif</span>
              @else
                <span class="px-2 py-1 rounded text-xs bg-gray-100 text-gray-700">tidak aktif</span>
              @endif
            </td>
            <td class="py-4 px-4 text-right">
              {{-- Tombol Edit --}}
              <a href="{{ route('kriteria.edit', $k) }}" class="inline-block mr-2" title="Edit">
                <svg class="h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M15.232 5.232l3.536 3.536M3 21v-3.586a1 1 0 01.293-.707l11-11a1 1 0 011.414 0l3.586 3.586a1 1 0 010 1.414l-11 11A1 1 0 018.414 21H3z" stroke-width="1.5"/>
                </svg>
              </a>

              {{-- Tombol Hapus --}}
              <form action="{{ route('kriteria.destroy', $k) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus kriteria ini?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="text-red-600 hover:text-red-800 transition" title="Hapus">
                  <svg class="h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path d="M19 7H5M10 11v6m4-6v6M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12" stroke-width="1.5"/>
                  </svg>
                </button>
              </form>
            </td>

          </tr>
        @empty
          <tr><td colspan="6" class="py-6 px-4 text-center text-gray-500">Tidak ada kriteria.</td></tr>
        @endforelse
      </tbody>
    </table>
  </div>

  <div class="mt-4">
    {{ $kriterias->links() }}
  </div>
</div>
@endsection