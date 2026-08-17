@extends('layouts.app')

@section('title','Edit Jalan')
@section('page-title','Edit Jalan')

@section('content')
<div class="card bg-white p-6">
  <h2 class="text-lg font-semibold mb-4">Edit Jalan</h2>

  @if ($errors->any())
    <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('jalan.update', $jalan) }}">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      {{-- Nama Jalan --}}
      <div>
        <label class="block text-sm text-gray-700 mb-1" for="nama_jalan">Nama Jalan</label>
        <input
          id="nama_jalan"
          type="text"
          name="nama_jalan"
          value="{{ old('nama_jalan', $jalan->nama_jalan) }}"
          class="w-full p-3 border rounded @error('nama_jalan') border-red-500 @enderror"
          placeholder="Masukkan nama jalan"
          required>
        @error('nama_jalan')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Kabupaten/Kota --}}
      <div>
        <label class="block text-sm text-gray-700 mb-1" for="kabupaten_kota">Kabupaten/Kota</label>
        <input
          id="kabupaten_kota"
          type="text"
          name="kabupaten_kota"
          value="{{ old('kabupaten_kota', $jalan->kabupaten_kota) }}"
          class="w-full p-3 border rounded @error('kabupaten_kota') border-red-500 @enderror"
          placeholder="Masukkan kabupaten/kota">
        @error('kabupaten_kota')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Status --}}
      <div>
        <label class="text-sm">Status</label>
        <select name="status" class="w-full p-3 border rounded" required>
          <option value="">-- Pilih Status --</option>
          <option value="Aktif" {{ old('status', $jalan->status) == 'Aktif' ? 'selected' : '' }}>Aktif</option>
          <option value="Tidak Aktif" {{ old('status', $jalan->status) == 'Tidak Aktif' ? 'selected' : '' }}>Tidak Aktif/Selesai</option>
        </select>
      </div>

      {{-- Tanggal Input (span full row) --}}
      <div class="md:col-span-2">
        <label class="block text-sm text-gray-700 mb-1" for="tanggal_input">Panjang</label>

        <input
          id="panjang"
          type="date"
          name="panjang"
          class="w-60 p-3 border rounded @error('panjang') border-red-500 @enderror"
          value="{{ old('panjang') }}"
          required>

        <p class="text-sm text-gray-500 mt-1">Tanggal Input mm/dd/yyyy</p>

        @error('panjang')
          <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>
    </div> 

    <input type="hidden" name="q" value="{{ request('q') }}">
    {{-- ganti nama hidden agar tidak menimpa select status --}}
    <input type="hidden" name="filter_status" value="{{ request('status') }}">
    <input type="hidden" name="page" value="{{ request('page') }}">

    <div class="mt-4">
      <a href="{{ route('jalan.index') }}" class="inline-block mr-2 px-4 py-2 border rounded">Batal</a>
      <button type="submit" class="px-4 py-2 bg-blue-800 text-white rounded">Perbarui</button>
    </div>
  </form>
</div>
@endsection
