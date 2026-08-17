@extends('layouts.app')

@section('title','Data Mahasiswa')
@section('page-title','Data Mahasiswa CRUD')

@section('content')
<div class="bg-white p-6">
    <div class="flex justify-between">
        <div>
            <h2 class="font-semibold text-lg">Data Mahasiswa</h2>
            <p class="text-gray-500 text-sm mb-2">CRUD DATA</p>
        </div>
        <div class=" flex items-end">
            <a href="{{ route('mahasiswa.create') }}" class="bg-blue-600 text-white rounded p-2">+ Tambah Mahasiswa</a>
        </div>
    </div>

    @if($errors->any())
        <div class="text-red-700 bg-red-100 rounded text-sm">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <table class="w-full">
        <thead class="border-b text-sm text-gray-500">
            <tr>
                <th class="px-3 py-4">Nama</th>
                <th class="px-3 py-4">NIM</th>
                <th class="px-3 py-4">Fakultas</th>
                <th class="px-3 py-4">Status</th>
                <th class="px-3 py-4">Alamat</th>
                <th class="px-3 py-4 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="border-b text-sm">
            @if(count($mahasiswas) > 0)
                @foreach($mahasiswas as $m)
                    <tr>
                        <td class="px-3 py-4">{{ $m->nama }}</td>
                        <td class="px-3 py-4">{{ $m->nim }}</td>
                        <td class="px-3 py-4">{{ $m->fakultas }}</td>
                        <td class="px-3 py-4">{{ $m->status }}</td>
                        <td class="px-3 py-4">{{ $m->alamat }}</td>
                        <td class="px-3 py-4 text-right flex justify-end">
                            <a href="{{ route('mahasiswa.edit', $m->id) }}" class="mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" d="M5 12.24L.5 13.5L1.76 9L10 .8a1 1 0 0 1 1.43 0l1.77 1.78a1 1 0 0 1 0 1.42z" stroke-width="1"/></svg>
                            </a>
                            <form action="{{ route('mahasiswa.destroy', $m->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"><path fill="#f40d0d" d="M7 3h2a1 1 0 0 0-2 0M6 3a2 2 0 1 1 4 0h4a.5.5 0 0 1 0 1h-.564l-1.205 8.838A2.5 2.5 0 0 1 9.754 15H6.246a2.5 2.5 0 0 1-2.477-2.162L2.564 4H2a.5.5 0 0 1 0-1zm1 3.5a.5.5 0 0 0-1 0v5a.5.5 0 0 0 1 0zM9.5 6a.5.5 0 0 1 .5.5v5a.5.5 0 0 1-1 0v-5a.5.5 0 0 1 .5-.5m-4.74 6.703A1.5 1.5 0 0 0 6.246 14h3.508a1.5 1.5 0 0 0 1.487-1.297L12.427 4H3.573z"/></svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="6" class="py-4 text-center text-gray-600">Tidak ada data</td>
                </tr>
            @endif
        </tbody>
    </table>
</div>

@endsection