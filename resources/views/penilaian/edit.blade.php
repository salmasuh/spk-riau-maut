@extends('layouts.app')

@section('page-title', $penilaian->exists ? 'Edit Penilaian' : 'Buat Penilaian')

@section('content')
<div class="w-full bg-white p-6 rounded-lg shadow-sm">

  <h3 class="text-lg font-semibold mb-4">{{ $penilaian->exists ? 'Edit Penilaian' : 'Buat Penilaian' }}</h3>

  @if($errors->any())
    <div class="mb-3 text-sm text-red-700 bg-red-50 p-3 rounded">
      <ul class="list-disc pl-4">
        @foreach($errors->all() as $err) <li>{{ $err }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form id="penilaianForm" method="POST" action="{{ $penilaian->exists ? route('penilaian.update', $penilaian->id) : route('penilaian.store') }}">
    @csrf
    @if($penilaian->exists) @method('PUT') @endif

    <input type="hidden" name="jalan_id" value="{{ $jalan->id }}">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
      <div>
        <label class="block text-sm text-gray-700 mb-1">Nama Jalan</label>
        <input type="text" value="{{ $jalan->nama_jalan }}" class="w-full border rounded px-3 py-2 bg-gray-50" readonly>
      </div>
    </div>

    <h4 class="text-sm font-medium mb-2">Nilai Kriteria</h4>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mb-6">
      @foreach($kriterias as $k)
        @php
          // nilai saat ini pada penilaian: bisa berupa subkriteria_id tersimpan
          $current = $penilaian->nilai_kriteria[$k->id] ?? null;
          // old input support (nilai_kriteria[kriteria_id])
          $old = old('nilai_kriteria.'.$k->id, $current);
        @endphp

        <div>
          <label class="block text-xs text-gray-600 mb-1">{{ $k->nama }}</label>
          <select name="nilai_kriteria[{{ $k->id }}]" class="w-full border rounded px-3 py-2 text-sm select-subkriteria">
            <option value="">-- Pilih {{ $k->nama }} --</option>
            @foreach($k->subKriterias as $sub)
              <option value="{{ $sub->id }}" {{ (string)$sub->id === (string)$old ? 'selected' : '' }}>
                {{ $sub->nama }} ({{ number_format($sub->nilai,0) }})
              </option>
            @endforeach
          </select>
        </div>
      @endforeach
    </div>

    <div class="mb-6">
      <label class="block text-sm text-gray-700 mb-1">Status</label>
      <select id="statusSelect" name="status" class="border rounded px-3 py-2">
        <option value="draft" {{ old('status', $penilaian->status) == 'draft' ? 'selected' : '' }}>Draft</option>
        <option value="submitted" {{ old('status', $penilaian->status) == 'submitted' ? 'selected' : '' }}>Submitted</option>
      </select>
      <p id="statusNote" class="text-xs text-red-600 mt-2 hidden">Untuk menyimpan, pilih "Submitted".</p>
    </div>

    <div class="flex gap-2">
      <a href="{{ route('penilaian.index') }}" class="px-4 py-2 bg-gray-300 rounded text-sm">Batal</a>

      <button id="submitBtn" type="submit" class="px-4 py-2 bg-blue-600 text-white rounded text-sm">
        {{ $penilaian->exists ? 'Perbarui' : 'Simpan' }}
      </button>
    </div>
  </form>
</div>

@push('scripts')
<script>
  (function(){
    const form = document.getElementById('penilaianForm');
    const statusSelect = document.getElementById('statusSelect');
    const submitBtn = document.getElementById('submitBtn');
    const selects = Array.from(document.querySelectorAll('.select-subkriteria'));
    const statusNote = document.getElementById('statusNote');

    function allSelected(){
      // pastikan semua kriteria telah dipilih (tidak kosong)
      return selects.every(s => s.value && s.value !== '');
    }

    function updateSubmitState(){
      const status = statusSelect.value;
      // tombol aktif hanya jika status == 'submitted' AND semua selects dipilih
      const enabled = (status === 'submitted') && allSelected();
      submitBtn.disabled = !enabled;
      submitBtn.classList.toggle('opacity-60', !enabled);
      // tampilkan catatan jika belum submitted
      statusNote.classList.toggle('hidden', status === 'submitted' && allSelected());
      if(!enabled){
        // show note if status not submitted
        if(status !== 'submitted'){
          statusNote.textContent = 'Untuk menyimpan, pilih "Submitted".';
          statusNote.classList.remove('hidden');
        } else if(!allSelected()){
          statusNote.textContent = 'Mohon pilih semua sub-kriteria sebelum menyimpan.';
          statusNote.classList.remove('hidden');
        }
      }
    }

    // attach events
    statusSelect.addEventListener('change', updateSubmitState);
    selects.forEach(s => s.addEventListener('change', updateSubmitState));

    // awal cek
    updateSubmitState();

    // prevent submit via keyboard if disabled
    form.addEventListener('submit', function(e){
      if(submitBtn.disabled){
        e.preventDefault();
      }
    });
  })();
</script>
@endpush

@endsection