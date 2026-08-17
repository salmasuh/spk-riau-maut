@extends('layouts.app')

@section('title','Data Mobil')
@section('page-title','Data Mobil')

@section('content')
    <div class="bg-white p-6 rounded shadow">
        <h2 class="font-bold">Detail Mobil</h2>
        <div class="flex justify-between gap-3">
            <div>
                <img src="{{ asset('storage/mobil/'.$mobil->gambar) }}" width="100">
            </div>
            <div>
                <h2 class="font-semibold text-sm mb-3">{{ $mobil -> nama }}</h2>
                <p class="text-sm mb-2 text-gray-500">Rp {{ number_format($mobil->harga,0,',','.') }}</p>
                <p class="text-sm mb-2 text-gray-500"><strong>Stock :</strong> {{ $mobil -> stok }}</p>
                <p class="text-sm mb-4 text-gray-500">{{ $mobil-> deskripsi }}</p>
                <a href="{{ route ('mobil.index') }}" class="border rounded px-3 py-2">Kembali</a>
            </div>
        </div>
    </div>
@endsection