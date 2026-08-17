@extends('layouts.app')

@section('title','Volume LHR')
@section('page-title', 'Volume LHR Jalan')

@section('content')
    <div class="bg-white p-6">
        <div class="flex justify-between mb-5">
            <div>
                <h2 class="font-semibold text-lg">Daftar Jalan</h2>
                <p class="text-sm text-gray-500">Volume LHR tiap jalan</p>
            </div>
        </div>
        <form method="GET" action="{{ route('volume_lhr.index') }}" class="flex gap-2">
            <input type="text" name="q" value="{{ $q }}" placeholder="Cari...." class="w-full p-3 border rounded">
            <button type="submit" class="px-4 border rounded">Cari</button>
        </form>

        @if(session('success'))
        <div class="text-sm text-green-700 bg-green-200 p-3">{{ session('success') }}</div>
        @endif
        <div class="mt-3">
            <table class="w-full text-left">
                <thead class="text-sm text-gray-500 border-b">
                    <tr>
                        <th class="px-4 py-3">Nama Jalan</th>
                        <th>Volume LHR</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @if(count($jalans) > 0)
                        @foreach($jalans as $jalan)
                            <tr>
                                <td class="px-4 py-3">{{ $jalan->nama_jalan }}</td>
                                <td>{{ $jalan->volume_lhr->volume_lhr ?? '-' }} </td>
                                <td> {{ $jalan->volume_lhr->keterangan ?? '-' }}</td>
                                <td>
                                    @if($jalan->volume_lhr)
                                        <a href="{{ route('volume_lhr.edit',$jalan->volume_lhr->id) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Edit</a>
                                        <form action="{{ route('volume_lhr.destroy',$jalan->volume_lhr->id) }}" method="POST" class="inline-flex">
                                            @csrf
                                            @method('DELETE')
                                                <button type="submit" class="py-1 px-3 border rounded" onclick="return confirm('Hapus data?')">Hapus</button>
                                        </form>
                                    @else
                                        <a href="{{ route('volume_lhr.create',  $jalan->id) }}" class="inline-flex items-center bg-blue-700 text-white px-3 py-1 border rounded">+ Tambah Volume LHR</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <td colspan="4">Tidak ada</td>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection