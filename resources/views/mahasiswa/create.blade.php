@extends('layouts.app')

@section('title','Data Mahasiswa')
@section('page-title','Data Mahasiswa CRUD')

@section('content')
<div class="bg-white p-6">
    <h2 class="text-lg font-semibold">Tambah Mahasiswa</h2>
    
    @if($errors->any())
        <div class="text-red-700 bg-red-100 p-3 text-sm">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('mahasiswa.store') }}" method="POST" class="grid md:grid-cols-2 gap-4">
        @csrf 
        <div>
            <label>Nama</label>
            <input type="text" name="nama" class="w-full p-3 border rounded" required>
        </div>
        <div>
            <label>NIM</label>
            <input type="text" name="nim" class="w-full p-3 border rounded" required>
        </div>
        <div>
            <label>Fakultas</label>
            <input type="text" name="fakultas" class="w-full p-3 border rounded" required>
        </div>
        <div>
            <label class="block">Status</label>
            <select name="status" class="w-1/2 p-3 border rounded" required>
                <option value="aktif">Aktif</option>
                <option value="cuti">Cuti</option>
                <option value="lulus">Lulus</option>
            </select>
        </div>
        <div>
            <label>Alamat</label>
            <textarea name="alamat" class="w-full p-3 border rounded"></textarea>
        </div>
        <div class="md:col-span-2">
            <a href="{{ route('mahasiswa.index') }}" class="p-3 border rounded">Batal</a>
            <button type="submit" class="px-4 py-2 bg-blue-800 text-white border rounded">Tambah</button>
        </div>
    </form>
</div>

@endsection