@extends('layouts.app')

@section('title','Data Mobil')
@section('page-title','Data Mobil')

@section('content')
<div class="bg-white p-6">
    <h2 class="text-lg font-semibold mb-6">Tambah Mobil</h2>
    @if($errors->any())
        <div class="text-red-500 bg-red-200 text-sm rounded p-2">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('mobil.store') }}" class="grid md:grid-cols-2 gap-4" enctype="multipart/form-data">
        @csrf

        <div>
            <label>Gambar</label>
            <input type="file" name="gambar" class="w-full p-3 border rounded">
        </div>
        <div>
            <label>Nama</label>
            <input type="text" name="nama" class="w-full p-3 border rounded">
        </div>
        <div class="md:col-span-2">
            <label>Deskripsi</label>
            <textarea name="deskripsi" class="w-full p-3 border rounded"></textarea>
        </div>
        <div>
            <label>Harga</label>
            <input type="number" name="harga" class="w-full p-3 border rounded">
        </div>
        <div>
            <label>Stok</label>
            <input type="number" name="stok" class="w-full p-3 border rounded">
        </div>
        <div>
             <button type="submit" class="bg-blue-700 text-white border rounded px-4 py-2">Simpan</button>
            <a href="{{ route('mobil.index') }}" class="px-4 py-2 border rounded">Kembali</a>
        </div>
       
    </form>
</div>
@endsection