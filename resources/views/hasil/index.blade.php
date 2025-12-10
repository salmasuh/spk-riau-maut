@extends('layouts.app')

@section('page-title','Hasil Akhir Prioritas')
@section('title','Hasil Akhir Prioritas')

@section('content')
<div class="space-y-6">
  <div class="card bg-white p-4">
    <div class="card bg-white p-4">
    <div class="mb-4">
      <h3 class="text-lg font-semibold">Daftar Lengkap Prioritas</h3>
      <div class="text-sm text-gray-500">Nilai utilitas akhir berdasarkan perhitungan MAUT</div>
    </div>

    {{-- Search bar --}}
    <div class="mb-4">
      <form method="GET" action="{{ route('hasil.index') }}">
        <div class="flex gap-3">
          <input type="text" name="q" value="{{ old('q', $q ?? '') }}"
            placeholder="Cari nama jalan atau lokasi..."
            class="w-full p-3 border rounded bg-gray-50">
          <button type="submit" class="px-4 py-2 bg-white border rounded">
            Cari
          </button>
        </div>
      </form>
    </div>

    {{-- Export button pindah ke kanan --}}
    <div class="flex justify-end mb-3">
        <a href="{{ route('hasil.export',['q'=>$q??'']) }}" class="px-4 py-2 bg-blue-800 text-white rounded shadow">
            Export PDF
        </a>
    </div>

    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead class="text-left text-xs text-gray-600 border-b">
          <tr>
            <th class="py-3 px-3 w-24">Ranking</th>
            <th class="py-3 px-3">Nama Jalan</th>
            <th class="py-3 px-3">Lokasi</th>
            <th class="py-3 px-3 w-48 text-right">Nilai Utilitas Akhir</th>
          </tr>
        </thead>
        <tbody>
          @forelse($collection as $row)
            <tr class="border-b hover:bg-gray-50">
              <td class="py-3 px-3">#{{ $row->rank }}</td>
              <td class="py-3 px-3">{{ $row->jalan->nama_jalan }}</td>
              <td class="py-3 px-3">{{ $row->jalan->kabupaten_kota }}</td>
              <td class="py-3 px-3 text-right font-semibold">
                {{ number_format($row->nilai_akhir,4,'.',',') }}
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="4" class="py-6 text-center text-gray-500">Belum ada data.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection