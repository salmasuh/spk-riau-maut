@extends('layouts.app')

@section('title','Tambah Kriteria')
@section('page-title','Tambah Kriteria')

@section('content')
<div class="card bg-white p-6">
  <h2 class="text-lg font-semibold mb-4">Tambah Kriteria</h2>

  @if ($errors->any())
    <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('kriteria.store') }}" id="form-kriteria">
    @csrf

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
      <div>
        <label class="block text-sm text-gray-700 mb-1">Nama Kriteria</label>
        <input name="nama" value="{{ old('nama') }}" class="w-full p-3 border rounded" required placeholder="Nama kriteria">
      </div>

      <div>
        <label class="block text-sm text-gray-700 mb-1">Tipe</label>
        <select name="tipe" class="w-full p-3 border rounded" required>
          <option value="benefit" {{ old('tipe')=='benefit' ? 'selected' : '' }}>benefit</option>
          <option value="cost" {{ old('tipe')=='cost' ? 'selected' : '' }}>cost</option>
        </select>
      </div>

      <div class="md:col-span-2">
        <label class="block text-sm text-gray-700 mb-1">Deskripsi</label>
        <textarea name="deskripsi" class="w-full p-3 border rounded" placeholder="Deskripsi (opsional)">{{ old('deskripsi') }}</textarea>
      </div>

      <div>
        <label class="block text-sm text-gray-700 mb-1">Bobot (0.0000 - 1.0000)</label>
        <input id="bobot" name="bobot" type="number" step="0.0001" min="0" max="1" value="{{ old('bobot','0.0000') }}" class="w-full p-3 border rounded" required>
      </div>

      <div>
        <label class="block text-sm text-gray-700 mb-1">Status</label>
        <select id="status" name="status" class="w-full p-3 border rounded" required>
          <option value="aktif" {{ old('status')=='aktif' ? 'selected' : '' }}>aktif</option>
          <option value="tidak_aktif" {{ old('status')=='tidak_aktif' ? 'selected' : '' }}>tidak aktif</option>
        </select>
      </div>

      <div class="md:col-span-2">
        <p>Total bobot kriteria aktif saat ini: {{ number_format($totalBobotAktif ?? 0, 4) }}</p>
        <p>Sisa bobot yang masih dapat digunakan: {{ number_format($sisaBobot ?? 1, 4) }}</p>

        {{-- element untuk JS --}}
        <span id="current-total" class="hidden">{{ number_format($totalBobotAktif ?? 0, 4) }}</span>
        <p id="bobot-error" class="text-sm text-red-600 hidden">Jumlah bobot aktif melebihi 1.0000</p>
      </div>
    </div>

    <div class="mt-4">
      <a href="{{ route('kriteria.index') }}" class="inline-block mr-2 px-4 py-2 border rounded">Batal</a>
      <button id="submit-btn" type="submit" class="px-4 py-2 bg-blue-800 text-white rounded">Simpan</button>
    </div>
  </form>
</div>

@push('scripts')
<script>
  (function(){
    const bobotInput = document.getElementById('bobot');
    const statusInput = document.getElementById('status');
    const currentTotalEl = document.getElementById('current-total');
    const errorEl = document.getElementById('bobot-error');
    const submitBtn = document.getElementById('submit-btn');

    // Ambil total bobot aktif saat ini dari server (dituliskan di currentTotal)
    let currentTotal = parseFloat(currentTotalEl.textContent.replace(',','.')) || 0;

    function checkTotal() {
      const b = parseFloat(bobotInput.value) || 0;
      const status = statusInput.value;
      // jika status aktif -> total = currentTotal + b, else total = currentTotal
      const newTotal = (status === 'aktif') ? (currentTotal + b) : currentTotal;
      const exceeds = (newTotal - 1.0) > 0.0000001; // toleransi floating
      if (exceeds) {
        errorEl.classList.remove('hidden');
        bobotInput.classList.add('border-red-500');
        submitBtn.disabled = true;
      } else {
        errorEl.classList.add('hidden');
        bobotInput.classList.remove('border-red-500');
        submitBtn.disabled = false;
      }
    }

    bobotInput.addEventListener('input', checkTotal);
    statusInput.addEventListener('change', checkTotal);

    // check initial
    checkTotal();
  })();
</script>
@endpush
@endsection