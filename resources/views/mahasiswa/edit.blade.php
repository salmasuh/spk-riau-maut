@extends('layouts.app')

@section('title','Data Mahasiswa')
@section('page-title','Data Mahasiswa CRUD')

@section('content')
<div class="bg-white p-6">
    <h2 class="font-semibold text-lg">Edit Mahasiswa</h2>

    @if($errors->any())
        <div class="text-red-700 bg-red-100 rounded p-3">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <form action="{{ route('mahasiswa.update',$mahasiswa->id) }}" method="POST" class="grid md:grid-cols-2 gap-3">
        @csrf
        @method('PUT')
        <div>
            <label>Nama</label>
            <input type="text" name="nama" value="{{$mahasiswa->nama}}" class="w-full border rounded p-3">
        </div>
        <div>
            <label>NIM</label>
            <input type="text" name="nim" value="{{$mahasiswa->nim}}" class="w-full p-3 border rounded">
        </div>
        <div>
            <label>Fakultas</label>
            <input type="text" name="fakultas" value="{{$mahasiswa->fakultas}}" class="w-full p-3 border rounded">
        </div>
        <div>
            <label>Status</label>
            <select name="status" class="w-full p-3 border rounded">
                <option value="aktif" @if(old('status',$mahasiswa->status) == 'aktif') selected @endif>Aktif</option>
                <option value="cuti" @if(old('status',$mahasiswa->status) == 'cuti') selected @endif>Cuti</option>
                <option value="lulus" @if(old('status',$mahasiswa->status) == 'lulus') selected @endif>Lulus</option>
            </select>
        </div>
        <div class="md:col-span-2 gap-4">
            <a href="{{ route('mahasiswa.index') }}" class="px-4 py-2 border rounded">Batal</a>
            <button type="submit" class="px-4 py-2 border rounded bg-blue-700 text-white">Simpan</button>
        </div>
    </form>
</div>

@endsection