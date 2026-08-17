@extends('layouts.app')

@section('title','Edit Kriteria')
@section('page-title','Edit Kriteria')

@section('content')
    <div class="bg-white p-6">
        <h2 class="font-semibold text-lg mb-4">Edit Mobil</h2>
        
        @if($errors->any())
            <div class="bg-red-100 text-red-700 text-sm p-2">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach    
                </ul>
            </div>
        @endif

        <form action="{{ route ('mobil.update', $mobil->id) }}" method="POST" class="grid md:grid-cols-2 gap-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div>
                <label>Gambar</label>
                <input type="file" name="gambar" value="{{ old('gambar',$mobil->gambar) }}" class="w-full p-3 border rounded">
            </div>
            <div>
                <label>Nama</label>
                <input type="text" name="nama" value="{{ old('nama',$mobil->nama) }}" class="w-full p-3 border rounded">
            </div>
            <div class="md:col-span-2">
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="w-full p-3 border rounded">{{ old('$eskripsi',$mobil->deskripsi) }}</textarea>
            </div>
            <div>
                <label>Stok</label>
                <input type="number" name="stok" value="{{ old('stok',$mobil->stok) }}" class="w-full p-3 border rounded">
            </div>
            <div>
                <label>Harga</label>
                <input type="number" name="harga" value="{{ old('harga',$mobil->harga) }}" class="w-full p-3 border rounded">
            </div>
            <div>
                <button type="submit" class="py-2 px-3 border rounded bg-blue-700 text-white">Simpan</button>
                <a href="{{ route('mobil.index') }}" class="py-2 px-3 border rounded">Kembali</a>
            </div>
        </form>
    </div>
@endsection