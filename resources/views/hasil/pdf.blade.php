<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size:12px; }
    table { width:100%; border-collapse: collapse; }
    th, td { padding:6px 8px; border:1px solid #ddd; }
    th { background:#f6f6f6; }
    .text-right { text-align:right; }
  </style>
</head>
<body>
  <h3>Daftar Lengkap Prioritas</h3>
  <p>Diunduh: {{ date('Y-m-d H:i') }}</p>

  <table>
    <thead>
      <tr>
        <th style="width:60px">Ranking</th>
        <th>Nama Jalan</th>
        <th>Lokasi</th>
        <th style="width:140px" class="text-right">Nilai Utilitas Akhir</th>
      </tr>
    </thead>
    <tbody>
      @forelse($collection as $row)
        <tr>
          <td>#{{ $row->rank }}</td>
          <td>{{ $row->jalan->nama_jalan }}</td>
          <td>{{ $row->jalan->kabupaten_kota }}</td>
          <td class="text-right">{{ number_format($row->nilai_akhir, 6, '.', ',') }}</td>
        </tr>
      @empty
        <tr>
          <td colspan="4" class="text-center">Tidak ada data.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</body>
</html>