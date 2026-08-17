@extends('layouts.app')

@section('title','Tambah Volume LHR')
@section('page-title','Tambah Volume LHR')

@section('content')
<div class="bg-white p-6">
    <h2 class="font-semibold text-lg mb-4">Data segitiga</h2>
    <div class="grid md:grid-cols-2 gap-4">
        <div class="border rounded p-4">
            <h2 class="text-sm font-semibold text-center">Gambar</h2>
            <img src="{{ asset('logo_pupr.jpg') }}" alt="logo" class="mx-auto h-36">
        </div>
        <div class="border rounded p-4">
            @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            <form action="{{ route('sikusiku.hitung') }}" method="POST">
                @csrf
                <label>Sisi Tegak</label>
                <input type="number" name="sisitegak" class="w-full p-2 border rounded mb-4" value="{{ $sisitegak ?? '' }}">
                <label>Alas</label>
                <input type="number" name="alas" class="w-full p-2 border rounded mb-4" value="{{ $alas ?? '' }}">
                <button type="submit" class="py-2 px-3 text-white border rounded bg-blue-700">Hitung</button>
            </form>
            @if(isset($luas))
            <div>hasilnya adalah {{ $luas }}</div>
            @endif
        </div>
    </div>
</div>
@endsection