@extends('layouts.app')

@section('title','Data Sub Kriteria')
@section('page-title','Data Sub Kriteria')

@section('content')
<div class="space-y-6">
  @if(session('success'))
    <div class="mb-4 text-sm text-green-700 bg-green-100 p-3 rounded">
      {{ session('success') }}
    </div>
  @endif

  <div class="card bg-white p-4 mb-4">
    <form method="GET" action="{{ route('subkriteria.index') }}" class="flex gap-3 items-center">
      <input type="text"
             name="q"
             placeholder="Cari nama atau deskripsi sub kriteria..."
             value="{{ old('q', $q ?? '') }}"
             class="flex-1 p-2 border rounded" />

      <select name="kriteria_status" class="p-2 border rounded" onchange="this.form.submit()">
        <option value="" {{ empty($kriteriaStatus) ? 'selected' : '' }}>Semua Status</option>
        <option value="aktif" {{ (isset($kriteriaStatus) && $kriteriaStatus=='aktif') ? 'selected' : '' }}>aktif</option>
        <option value="tidak_aktif" {{ (isset($kriteriaStatus) && $kriteriaStatus=='tidak_aktif') ? 'selected' : '' }}>tidak aktif</option>
      </select>

      <button class="px-4 py-2 bg-blue-800 text-white rounded">Cari</button>
    </form>
  </div>

  @if($kriteriaList->isEmpty())
    <div class="card bg-white p-6">
      <p>Tidak ada kriteria aktif. Silakan tambahkan atau aktifkan kriteria di halaman Data Kriteria.</p>
    </div>
  @else

    {{-- siapkan preserve params sekali --}}
    @php
      $preserve = request()->only(['q','kriteria_status','page']);
      // hapus yang kosong supaya tidak muncul di query string
      $preserve = array_filter($preserve, fn($v) => $v !== null && $v !== '');
    @endphp

    @foreach($kriteriaList as $k)
      @php
        // URL create membawa kriteria_id + preserve params
        $createQsArr = array_merge(['kriteria_id' => $k->id], $preserve);
        $createQs = http_build_query(array_filter($createQsArr, fn($v) => $v !== null && $v !== ''));
        $createUrl = route('subkriteria.create') . ($createQs ? ('?'.$createQs) : '');
      @endphp

      <div class="card bg-white p-4">
        <div class="flex items-center justify-between">
          <div>
            <div class="font-semibold">{{ $k->nama }}</div>
            <div class="text-sm text-gray-500">Total {{ $k->subKriterias->count() }} sub kriteria</div>
          </div>

          <div class="flex items-center gap-3">
            <a href="{{ $createUrl }}" class="px-3 py-2 bg-blue-800 text-white rounded">+ Tambah Sub Kriteria</a>
          </div>
        </div>

        @if($k->subKriterias->isNotEmpty())
          <div class="mt-4 overflow-x-auto">
            <table class="w-full text-left">
              <thead class="text-sm text-gray-500 border-b">
                <tr>
                  <th class="py-3 px-4">Nama Sub Kriteria</th>
                  <th class="py-3 px-4">Deskripsi</th>
                  <th class="py-3 px-4">Nilai (Ranking)</th>
                  <th class="py-3 px-4 text-right">Aksi</th>
                </tr>
              </thead>
              <tbody class="text-sm">
                @foreach($k->subKriterias as $s)
                  @php
                    // build edit url dengan preserve params
                    $editQsArr = $preserve;
                    $editQs = http_build_query(array_filter($editQsArr, fn($v) => $v !== null && $v !== ''));
                    $editUrl = route('subkriteria.edit', $s) . ($editQs ? ('?'.$editQs) : '');
                  @endphp

                  <tr class="border-b">
                    <td class="py-4 px-4">{{ $s->nama }}</td>
                    <td class="py-4 px-4">{{ $s->deskripsi }}</td>
                    <td class="py-4 px-4 font-semibold">{{ $s->nilai }}</td>
                    <td class="py-4 px-4 text-right">
                      <!-- Edit -->
                      <a href="{{ $editUrl }}" class="inline-block mr-2" title="Edit">
                        <svg class="h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536M3 21v-3.586a1 1 0 01.293-.707l11-11a1 1 0 011.414 0l3.586 3.586a1 1 0 010 1.414l-11 11A1 1 0 08.414 21H3z" stroke-width="1.5"/></svg>
                      </a>

                      <!-- Hapus -->
                      <form action="{{ route('subkriteria.destroy', $s) }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus sub kriteria ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600" title="Hapus">
                          <svg class="h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7L5 7M10 11v6M14 11v6M6 7l1 12a2 2 0 002 2h6a2 2 0 002-2l1-12" stroke-width="1.5"/></svg>
                        </button>
                      </form>
                    </td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endif
      </div>
    @endforeach
  @endif
</div>
@endsection