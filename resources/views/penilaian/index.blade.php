@extends('layouts.app')

@section('page-title','Data Penilaian')

@section('content')
<div class="bg-white p-6 card">
  <div class="flex items-start justify-between mb-4">
    <div>
      <h3 class="text-lg font-semibold">Data Penilaian</h3>
      <p class="text-sm text-gray-500">Kelola penilaian infrastruktur jalan</p>
    </div>
  </div>

  {{-- Search --}}
  <div class="mb-4">
    <form method="GET" action="{{ route('penilaian.index') }}">
      <div class="flex gap-3">
        <input type="text" name="q" value="{{ $q ?? '' }}"
          placeholder="Cari nama jalan atau penilai..."
          class="w-full p-3 border rounded bg-gray-50">
        <button type="submit" class="px-4 py-2 bg-white border rounded">
          Cari
        </button>
      </div>
    </form>
  </div>

  @if(session('success'))
    <div class="mb-4 text-sm text-green-700 bg-green-50 p-3 rounded">
      {{ session('success') }}
    </div>
  @endif

  <div class="overflow-x-auto">
    <table id="penilaianTable" class="w-full text-sm divide-y">
      <thead class="text-left text-xs text-gray-600">
        <tr>
          <th class="py-3 px-3 w-72">Nama Jalan</th>
          @foreach($kriterias as $k)
            <th class="py-3 px-3 text-center">{{ $k->nama }}</th>
          @endforeach
          <th class="py-3 px-3 text-center w-32">Status</th>
          <th class="py-3 px-3 text-right w-28">Kelola Penilaian</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y">
        @forelse($jalans as $jalan)
          @php $p = $penilaians[$jalan->id] ?? null; @endphp
          <tr class="hover:bg-gray-50">
            <td class="py-3 px-3">{{ $jalan->nama_jalan }}</td>

            @foreach($kriterias as $k)
              @php
                $subId = $p ? ($p->nilai_kriteria[$k->id] ?? null) : null;
                $sub = $subKriterias[$subId] ?? null;
                $display = $sub ? number_format($sub->nilai, 2) : '-';
              @endphp
              <td class="py-3 px-3 text-center">{{ $display }}</td>
            @endforeach

            <td class="py-3 px-3 text-center">
              @if($p)
                @if($p->status === 'submitted')
                  <span class="inline-block px-2 py-1 rounded-full text-xs bg-blue-100 text-blue-700">Submitted</span>
                @elseif($p->status === 'draft')
                  <span class="inline-block px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700">Draft</span>
                @else
                  <span class="inline-block px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-700">{{ $p->status }}</span>
                @endif
              @else
                <span class="inline-block px-2 py-1 rounded-full text-xs bg-gray-100 text-gray-600">Draft</span>
              @endif
            </td>
          
            <td class="py-3 px-3 text-right">
              <a href="{{ route('penilaian.manage', $jalan) }}" 
                class="text-blue-600 inline-block mr-2" title="Edit">
                <svg class="h-5 w-5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path d="M15.232 5.232l3.536 3.536M3 21v-3.586a1 1 0 01.293-.707l11-11a1 1 0 011.414 0l3.586 3.586a1 1 0 010 1.414l-11 11A1 1 0 08.414 21H3z"
                    stroke-width="1.5"/>
                </svg>
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="{{ 4 + $kriterias->count() }}" class="py-6 text-center text-gray-500">Belum ada data jalan.</td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@push('scripts')
<script>
  (function(){
    const input = document.getElementById('tableSearch');
    const clearBtn = document.getElementById('clearSearch');
    const tbody = document.querySelector('#penilaianTable tbody');

    function normalize(s){ return (s||'').toString().toLowerCase().trim(); }

    function filterRows(){
      const q = normalize(input.value);
      const rows = Array.from(tbody.querySelectorAll('tr'));
      rows.forEach(row=>{
        // ignore header/empty rows if they have colspan
        if (row.querySelector('td') === null) return;
        const text = normalize(row.innerText);
        row.style.display = q === '' || text.indexOf(q) !== -1 ? '' : 'none';
      });
    }

    input.addEventListener('input', filterRows);
    clearBtn.addEventListener('click', ()=>{ input.value=''; input.focus(); filterRows(); });

    // focus search on '/'
    document.addEventListener('keydown', function(e){
      if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
        e.preventDefault(); input.focus();
      }
    });
  })();
</script>
@endpush

@endsection