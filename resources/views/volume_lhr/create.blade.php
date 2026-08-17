@extends('layouts.app')

@section('title','Tambah Volume LHR')
@section('page-title','Tambah Volume LHR')

@section('content')
    <div class="bg-white p-6">
        <h2 class="font-semibold text-lg mb-4">Tambah Data</h2>
        
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-3 text-sm">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form action="{{ route('volume_lhr.store') }}" method="POST" class="grid md:grid-cols-2 gap-4">
            @csrf
            <div>
                <label>Nama Jalan</label>
                <input type="text"
       value="{{ $jalans->nama_jalan }}"
       class="w-full p-3 border rounded bg-gray-100"
       readonly>

<input type="hidden" name="jalan_id" value="{{ $jalans->id }}">
            </div>
            <div>
                <label>Volume LHR</label>
                <input type="number" name="volume_lhr" max="200000" value="{{ old('volume_lhr') }}" class="w-full p-3 border rounded">
            </div>
            <div class="grid md:col-span-2">
                <label>Keterangan</label>
                <textarea name="keterangan" class="w-1/2 p-3 border rounded">{{ old('keterangan') }}</textarea>
            </div>
            <div>
                <button type="submit" class="py-3 px-2 border rounded bg-blue-700 text-white">Simpan</button>
                <a href="{{ route('volume_lhr.index') }}" class="py-3 px-2 border rounded">Kembali</a>
            </div>
        </form>
    </div>
@endsection