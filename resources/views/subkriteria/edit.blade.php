@extends('layouts.app')

@section('title', 'Edit Sub Kriteria')
@section('page-title', 'Edit Sub Kriteria')

@section('content')
<div class="card bg-white p-6">
  <h2 class="text-lg font-semibold mb-4">Edit Sub Kriteria</h2>

  {{-- Tampilkan error validasi --}}
  @if ($errors->any())
    <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  {{-- Form edit --}}
  <form method="POST" action="{{ route('subkriteria.update', $subkriteria->id) }}">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      {{-- Nama Kriteria (non-editable) --}}
      <div>
        <label class="block text-sm text-gray-700 mb-1">Kriteria</label>
        <input type="text" 
               class="w-full p-3 border rounded bg-gray-100 cursor-not-allowed" 
               value="{{ $subkriteria->kriteria->nama }}" readonly>
        {{-- tetap kirim id tersembunyi agar data utuh --}}
        <input type="hidden" name="kriteria_id" value="{{ $subkriteria->kriteria_id }}">
      </div>

      {{-- Nama Sub Kriteria --}}
      <div>
        <label class="block text-sm text-gray-700 mb-1">Nama Sub Kriteria</label>
        <input name="nama" 
               value="{{ old('nama', $subkriteria->nama) }}" 
               class="w-full p-3 border rounded" required>
      </div>

      {{-- Deskripsi --}}
      <div class="md:col-span-2">
        <label class="block text-sm text-gray-700 mb-1">Deskripsi</label>
        <textarea name="deskripsi" 
                  class="w-full p-3 border rounded">{{ old('deskripsi', $subkriteria->deskripsi) }}</textarea>
      </div>

      {{-- Nilai --}}
      <div>
        <label class="block text-sm text-gray-700 mb-1">
          Nilai (1 - {{ $maxAllowed ?? 'N' }})
        </label>
        <input name="nilai" 
               type="number" 
               step="1" 
               min="1" 
               max="{{ $maxAllowed ?? '' }}" 
               value="{{ old('nilai', $subkriteria->nilai) }}" 
               class="w-full p-3 border rounded" 
               required>
      </div>
    </div>

    <input type="hidden" name="q" value="{{ request('q', '') }}">
    <input type="hidden" name="kriteria_status" value="{{ request('kriteria_status', '') }}">
    <input type="hidden" name="page" value="{{ request('page', '') }}">

    {{-- Tombol Aksi --}}
    <div class="mt-4">
      <a href="{{ route('subkriteria.index') }}" class="inline-block mr-2 px-4 py-2 border rounded">Batal</a>
      <button type="submit" class="px-4 py-2 bg-blue-800 text-white rounded">Perbarui</button>
    </div>
  </form>
</div>
@endsection