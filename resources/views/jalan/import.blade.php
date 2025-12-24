@extends('layouts.app')

@section('title','Import CSV Jalan')
@section('page-title','Import CSV Jalan')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
  <h2 class="text-lg font-semibold mb-4">Import Data Jalan (CSV)</h2>

  @if ($errors->any())
    <div class="mb-3 text-red-600 text-sm">
      {{ $errors->first() }}
    </div>
  @endif

  <form action="{{ route('jalan.import') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-4">
      <label class="block text-sm mb-1">File CSV</label>
      <input type="file" name="file" required class="w-full border p-2 rounded">
    </div>

    <div class="text-sm text-gray-500 mb-4">
      Kolom wajib:
      <ul class="list-disc ml-5">
        <li>NAMA RUAS</li>
        <li>KABUPATEN/KOTA YANG DILALUI</li>
      </ul>
    </div>

    <div class="flex justify-end gap-2">
      <a href="{{ route('jalan.index') }}" class="px-4 py-2 border rounded">Batal</a>
      <button class="px-4 py-2 bg-blue-800 text-white rounded">
        Import
      </button>
    </div>
  </form>
</div>
@endsection