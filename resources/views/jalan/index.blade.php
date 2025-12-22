@extends('layouts.app')

@section('title','Data Jalan')
@section('page-title','Data Jalan')

@section('content')
<div class="space-y-6">
  <div class="card bg-white p-6">
    <div class="flex items-center justify-between mb-4">
      <div>
        <h2 class="text-lg font-semibold">Daftar Jalan</h2>
        <div class="text-sm text-gray-500">Kelola data infrastruktur jalan</div>
        <div class="text-sm text-gray-400 mt-1">Total {{ $totalJalan }} jalan</div>
      </div>

      <div class="flex gap-2">
        <a href="{{ route('jalan.create') }}"
          class="inline-flex items-center px-4 py-2 bg-blue-800 text-white rounded shadow">
          + Tambah Jalan
        </a>

        <a href="{{ route('jalan.import.form') }}"
          class="inline-flex items-center px-4 py-2 border rounded">
          Import CSV
        </a>
      </div>
    </div>

    {{-- Flash message --}}
    @if(session('success'))
      <div class="mb-4 text-sm text-green-700 bg-green-100 p-3 rounded">
        {{ session('success') }}
      </div>
    @endif

    <div class="card bg-white p-4 mb-4">
      <form method="GET" action="{{ route('jalan.index') }}" class="flex gap-3 items-center">
          <input type="text" name="q" value="{{ old('q', $q ?? '') }}" placeholder="Cari nama jalan..."  class="flex-1 p-2 border rounded" />
          <select name="status" class="p-2 border rounded" onchange="this.form.submit()">
            <option value="" {{ empty($status) ? 'selected' : '' }}>Semua Status</option>
            <option value="Aktif" {{ ($status=='Aktif') ? 'selected' : '' }}>Aktif</option>
            <option value="Tidak Aktif" {{ ($status=='Tidak Aktif') ? 'selected' : '' }}>Tidak Aktif/Selesai</option>
          </select>
          
          <button class="px-4 py-2 bg-blue-800 text-white rounded">Cari</button>
      </form>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-left">
        <thead class="text-sm text-gray-500 border-b">
          <tr>
            <th class="py-3 px-4">Nama Jalan</th>
            <th class="py-3 px-4">Kabupaten/Kota</th>
            <th class="py-3 px-4">Status</th>
            <th class="py-3 px-4">Tanggal Input</th>
            <th class="py-3 px-4 text-right">Aksi</th>
          </tr>
        </thead>
        <tbody class="text-sm">
          @forelse($jalans as $jalan)
            <tr class="border-b last:border-b-0">
              <td class="py-4 px-4">{{ $jalan->nama_jalan }}</td>
              <td class="py-4 px-4">{{ $jalan->kabupaten_kota }}</td>
              <td class="py-3 px-4">
                <span class="px-2 py-1 rounded text-white {{ $jalan->status=='Aktif' ? 'bg-green-600' : 'bg-gray-500' }}">
                  {{ $jalan->status }}
                </span>
              </td>
              <td class="py-4 px-4">{{ $jalan->tanggal_input ? \Carbon\Carbon::parse($jalan->tanggal_input)->format('Y-m-d') : '-' }}</td>
              <td class="py-4 px-4 text-right">
                @php
                  // ambil query saat ini: q, status, page (jika ada)
                  $preserve = request()->only(['q','status','page']);
                  $qs = http_build_query(array_filter($preserve, fn($v) => $v !== null && $v !== ''));
                  $editUrl = route('jalan.edit', $jalan) . ($qs ? '?'.$qs : '');
                @endphp
                <div class="flex justify-end items-center">
                  <a href="{{ $editUrl }}" class="inline-block mr-2" title="Edit">
                    <svg class="h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536M3 21v-3.586a1 1 0 01.293-.707l11-11a1 1 0 011.414 0l3.586 3.586a1 1 0 010 1.414l-11 11A1 1 0 08.414 21H3z" stroke-width="1.5"/></svg>
                  </a>

                  <form action="{{ route('jalan.destroy', $jalan) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus data jalan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600" title="Hapus">
                      <svg class="h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7L5 7M10 11v6M14 11v6M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12" stroke-width="1.5"/></svg>
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="py-6 px-4 text-center text-gray-500">Tidak ada data jalan.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

  </div>
</div>
@endsection