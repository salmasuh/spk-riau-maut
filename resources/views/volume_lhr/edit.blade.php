@extends('layouts.app')

@section('title','Edit Volume LHR')
@section('page-title', 'Edit Volume')

@section('content')
    <div class="bg-white p-6">
        <h2 class="font-semibold text-lg mb-2">Edit</h2>
        <form action="{{ route('volume_lhr.update',$volume_lhr->id) }}" method="POST" class="grid md:grid-cols-2 p-3 gap-4">
            @csrf
            @method('PUT')
            <div>
                <label>Nama Jalan</label>
                <input type="text" value="{{ $volume_lhr->jalan->nama_jalan }}" class="w-full p-3 border rounded bg-gray-100" readonly>
                <input type="hidden" name="jalan_id" value="{{ $volume_lhr->jalan_id }}">
            </div>
            <div>
                <label>Volume LHR</label>
                <input type="number" name="volume_lhr" class="w-full p-3 border rounded" value="{{ $volume_lhr->volume_lhr }}">
            </div>
            <div class="grid md:col-span-2">
                <label>Keterangan</label>
                <textarea name="keterangan" class="w-1/2 p-3 border rounded">{{ $volume_lhr->keterangan }}</textarea>
            </div>
            <div>
                <button type="submit" class="py-2 px-3 text-white bg-blue-700 border rounded">Simpan</button>
                <a href="{{ route('volume_lhr.index') }}" class="py-2 px-3 border rounded">Batal</a>
            </div>
        </form>
    </div>
@endsection