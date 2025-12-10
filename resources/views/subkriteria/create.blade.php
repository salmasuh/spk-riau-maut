@extends('layouts.app')

@section('title','Tambah Sub Kriteria')
@section('page-title','Tambah Sub Kriteria')

@section('content')
<div class="card bg-white p-6">
  <h2 class="text-lg font-semibold mb-4">Tambah Sub Kriteria</h2>

  @if ($errors->any())
    <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('subkriteria.store') }}">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm text-gray-700 mb-1" for="kriteria_id">Kriteria</label>

        @if(!empty($selectedKriteria) && !empty($selectedKriteriaName))
          <!-- tampilkan nama kriteria dan value tersembunyi -->
          <div class="p-3 border rounded bg-gray-50">{{ $selectedKriteriaName }}</div>
          <input type="hidden" name="kriteria_id" value="{{ $selectedKriteria }}">
        @else
          <select id="kriteria_id" name="kriteria_id" class="w-full p-3 border rounded" required>
            <option value="">-- Pilih Kriteria --</option>
            @foreach($kriteriaList as $k)
              <option value="{{ $k->id }}" {{ old('kriteria_id', $selectedKriteria ?? '') == $k->id ? 'selected' : '' }}>
                {{ $k->nama }}
              </option>
            @endforeach
          </select>
        @endif
      </div>

      <div>
        <label class="block text-sm text-gray-700 mb-1" for="nama">Nama Sub Kriteria</label>
        <input id="nama" name="nama" value="{{ old('nama') }}" class="w-full p-3 border rounded" placeholder="Masukkan nama sub kriteria" required>
      </div>

      <div class="md:col-span-2">
        <label class="block text-sm text-gray-700 mb-1" for="deskripsi">Deskripsi</label>
        <textarea id="deskripsi" name="deskripsi" class="w-full p-3 border rounded" placeholder="Deskripsi (opsional)">{{ old('deskripsi') }}</textarea>
      </div>

      <div>
        <label class="block text-sm text-gray-700 mb-1" for="nilai">Nilai (1 - {{ $maxAllowed ?? 'N' }})</label>
        <input id="nilai" name="nilai" type="number" step="1" min="1" max="{{ $maxAllowed ?? '' }}" value="{{ old('nilai',1) }}" class="w-full p-3 border rounded" required>
        @if(isset($maxAllowed))
          <p class="text-xs text-gray-500 mt-1">Masukkan nilai antara 1 dan {{ $maxAllowed }} </p>
        @endif
      </div>
    </div>

    <input type="hidden" name="q" value="{{ $preserve['q'] ?? '' }}">
    <input type="hidden" name="kriteria_status" value="{{ $preserve['kriteria_status'] ?? '' }}">
    <input type="hidden" name="page" value="{{ $preserve['page'] ?? '' }}">
    
    {{-- Tombol Aksi --}}
    <div class="mt-4">
      <a href="{{ route('subkriteria.index') }}" class="inline-block mr-2 px-4 py-2 border rounded">Batal</a>
      <!-- preserve filters supaya setelah submit balik dengan filter yg sama -->
      <input type="hidden" name="q" value="{{ $preserve['q'] ?? '' }}">
      <input type="hidden" name="kriteria_status" value="{{ $preserve['kriteria_status'] ?? '' }}">
      <input type="hidden" name="page" value="{{ $preserve['page'] ?? '' }}">
      <button type="submit" class="px-4 py-2 bg-blue-800 text-white rounded">Simpan</button>
    </div>
  </form>
</div>
@endsection