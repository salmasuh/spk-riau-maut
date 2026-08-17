@extends('layouts.app')

@section('title','Data Mobil')
@section('page-title','Data Mobil')

@section('content')
 <div class="bg-white p-3">
    <div class="flex justify-between">
        <div>
            <h2 class="text-lg font-semibold">Data Mobil</h2>
            <p class="text-sm text-gray-500 mb-4">Mobil yang dijual</p>
        </div>
        <div class="flex items-end mb-4">
            <a href="{{ route('mobil.create') }}" class="bg-blue-600 text-white rounded py-2 px-3">+ Tambah Mobil</a>
        </div>
    </div>

    @if(session('success'))
        <div class="text-green-700 bg-green-100 text-sm p-3 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('kriteria.index') }}" method="GET" class="flex gap-2 mb-4">
        <input type="text" name="q" class="w-full p-3 border rounded">
        <button type="submit" class="px-4 border rounded">Cari</button>
    </form>

    <table class="w-full text-left">
        <thead class="text-sm text-gray-500 border-b">
            <tr>
                <th class="py-3 px-4">Nama</th>
                <th class="py-3 px-4">Gambar</th>
                <th class="py-3 px-4">Deskripsi</th>
                <th class="py-3 px-4">Harga</th>
                <th class="py-3 px-4">Stok</th>
                <th class="py-3 px-6">Aksi</th>
            </tr>
        </thead>
        <tbody class="text-sm">
            @if(count($mobils) > 0)
                @foreach($mobils as $m)
                    <tr>
                        <td class="py-3 px-4">{{ $m->nama }}</td>
                        <td>
                        <img src="{{ asset('storage/mobil/'.$m->gambar) }}" width="100">
                        </td>
                        <td class="py-3 px-4">{{ $m->deskripsi }}</td>
                        <td class="py-3 px-4">{{ $m->harga }}</td>
                        <td class="py-3 px-4">{{ $m->stok }}</td>
                        <td class="py-3 px-6">
                            <a href="{{ route ('mobil.show', $m->id) }}" class="text-sm py-1 px-1 border rounded">Show</a>
                            <a href="{{ route ('mobil.edit', $m->id) }}" class="text-sm py-1 px-1 border rounded">Edit</a>
                            <form action="{{ route ('mobil.destroy', $m->id) }}" method="POST" onsubmit="return confirm('Hapus?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm py-1 px-1 border rounded">Hapus</button>
                            </form>
                        </td>
                        
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" class="text-gray-500 text-center py-4">Tidak ada.</td>
                </tr>
            @endif
        </tbody>
    </table>
 </div>
@endsection