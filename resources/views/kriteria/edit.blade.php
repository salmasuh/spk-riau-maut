@extends('layouts.app')

@section('title','Edit Kriteria')
@section('page-title','Edit Kriteria')

@section('content')

@php
    // =========================
    // PRE-CALC (ANTI FLOAT BUG)
    // =========================
    $bobotItem = ($kriteria->status === 'aktif') ? (float) $kriteria->bobot : 0;
    $totalIncluding = round($totalAktifLainnya + $bobotItem, 2);
    $sisaJikaBaru   = round(1 - $totalIncluding, 2);
@endphp

<div class="card bg-white p-6">
  <h2 class="text-lg font-semibold mb-4">Edit Kriteria</h2>

  @if ($errors->any())
    <div class="mb-4 text-sm text-red-700 bg-red-100 p-3 rounded">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('kriteria.update', $kriteria) }}">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

      <div>
        <label class="block text-sm text-gray-700 mb-1">Nama Kriteria</label>
        <input
          type="text"
          name="nama"
          value="{{ old('nama', $kriteria->nama) }}"
          class="w-full p-3 border rounded"
          required
        >
      </div>

      <div>
        <label class="block text-sm text-gray-700 mb-1">Tipe</label>
        <select name="tipe" class="w-full p-3 border rounded" required>
          <option value="benefit" {{ old('tipe',$kriteria->tipe)=='benefit' ? 'selected' : '' }}>benefit</option>
          <option value="cost" {{ old('tipe',$kriteria->tipe)=='cost' ? 'selected' : '' }}>cost</option>
        </select>
      </div>

      <div class="md:col-span-2">
        <label class="block text-sm text-gray-700 mb-1">Deskripsi</label>
        <textarea name="deskripsi" class="w-full p-3 border rounded">{{ old('deskripsi',$kriteria->deskripsi) }}</textarea>
      </div>

      <div>
        <label class="block text-sm text-gray-700 mb-1">Bobot (0.00 – 1.00)</label>
        <input
          id="bobot"
          name="bobot"
          type="number"
          step="0.01"
          min="0"
          max="1"
          value="{{ old('bobot', number_format($kriteria->bobot,2,'.','')) }}"
          class="w-full p-3 border rounded"
          required
        >
      </div>

      <div>
        <label class="block text-sm text-gray-700 mb-1">Status</label>
        <select id="status" name="status" class="w-full p-3 border rounded" required>
          <option value="aktif" {{ old('status',$kriteria->status)=='aktif' ? 'selected' : '' }}>aktif</option>
          <option value="tidak_aktif" {{ old('status',$kriteria->status)=='tidak_aktif' ? 'selected' : '' }}>tidak aktif</option>
        </select>
      </div>

      {{-- ================= INFO TOTAL ================= --}}
      <div class="md:col-span-2">
        <p>
          Total bobot kriteria aktif saat ini (termasuk item ini jika aktif):
          <strong id="total-including">{{ number_format($totalIncluding, 2) }}</strong>
        </p>

        <p>
          Sisa bobot jika memasukkan bobot baru:
          <strong id="sisa-if-new">{{ number_format(max($sisaJikaBaru, 0), 2) }}</strong>
        </p>

        {{-- hidden values for JS --}}
        <span id="js-total-aktif-lainnya" class="hidden">
          {{ number_format($totalAktifLainnya, 2, '.', '') }}
        </span>

        <span id="js-old-bobot" class="hidden">
          {{ number_format($kriteria->bobot, 2, '.', '') }}
        </span>

        <span id="js-is-active" class="hidden">
          {{ $kriteria->status === 'aktif' ? '1' : '0' }}
        </span>

        <p id="bobot-error" class="text-sm text-red-600 hidden">
          Jumlah bobot aktif melebihi 1.00
        </p>
      </div>
    </div>

    <div class="mt-4">
      <a href="{{ route('kriteria.index') }}" class="inline-block mr-2 px-4 py-2 border rounded">
        Batal
      </a>
      <button id="submit-btn" type="submit" class="px-4 py-2 bg-blue-800 text-white rounded">
        Perbarui
      </button>
    </div>
  </form>
</div>

@push('scripts')
<script>
(function () {

  const bobotInput = document.getElementById('bobot');
  const statusInput = document.getElementById('status');
  const submitBtn = document.getElementById('submit-btn');

  const totalIncludingEl = document.getElementById('total-including');
  const sisaIfNewEl = document.getElementById('sisa-if-new');
  const errorEl = document.getElementById('bobot-error');

  const totalAktifLainnya =
    parseFloat(document.getElementById('js-total-aktif-lainnya')?.textContent) || 0;

  function fmt2(n) {
    return (Math.round((n + Number.EPSILON) * 100) / 100).toFixed(2);
  }

  function computeAndRender() {
    const bobot = parseFloat(bobotInput.value) || 0;
    const status = statusInput.value;

    const totalIncluding =
      status === 'aktif'
        ? totalAktifLainnya + bobot
        : totalAktifLainnya;

    const totalRounded = Math.round(totalIncluding * 100) / 100;
    const sisa = Math.max(0, Math.round((1 - totalRounded) * 100) / 100);

    totalIncludingEl.textContent = fmt2(totalRounded);
    sisaIfNewEl.textContent = fmt2(sisa);

    if (totalRounded > 1) {
      errorEl.classList.remove('hidden');
      bobotInput.classList.add('border-red-500');
      submitBtn.disabled = true;
    } else {
      errorEl.classList.add('hidden');
      bobotInput.classList.remove('border-red-500');
      submitBtn.disabled = false;
    }
  }

  bobotInput.addEventListener('input', computeAndRender);
  statusInput.addEventListener('change', computeAndRender);

  computeAndRender();
})();
</script>
@endpush

@endsection