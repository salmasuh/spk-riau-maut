<?php

namespace App\Http\Controllers;

use App\Models\Jalan;
use App\Models\Kriteria;
use App\Models\Penilaian;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use PDF;

class HasilController extends Controller
{
    protected function computeMautForSubmitted(): \Illuminate\Support\Collection
    {
        // 1) Ambil kriteria aktif dengan bobot yang sudah ditentukan
        $kriterias = Kriteria::where('status', 'aktif')->orderBy('id')->get();
        if ($kriterias->isEmpty()) return collect();

        // 2) Ambil penilaian dengan status submitted dan jalan yang masih aktif
        $penilaians = Penilaian::whereRaw('LOWER(status) = ?', ['submitted'])
            ->whereNotNull('jalan_id')
            ->whereHas('jalan', function($query) {
                $query->where('status', 'aktif'); // Hanya ambil jalan yang aktif
            })
            ->orderByDesc('created_at')
            ->get();

        if ($penilaians->isEmpty()) return collect();

        // 3) Ambil penilaian terbaru per jalan
        $penilaianByJalan = [];
        foreach ($penilaians as $p) {
            $jid = $p->jalan_id;
            if (!isset($penilaianByJalan[$jid])) {
                $penilaianByJalan[$jid] = $p;
            }
        }

        $jalanIds = array_keys($penilaianByJalan);
        
        // Ambil hanya jalan yang aktif
        $jalans = Jalan::whereIn('id', $jalanIds)
            ->where('status', 'aktif') // Pastikan hanya jalan aktif
            ->get()
            ->keyBy('id');

        // 4) Jika ada jalan yang tidak aktif, hapus dari penilaian
        foreach ($penilaianByJalan as $jid => $p) {
            if (!isset($jalans[$jid])) {
                unset($penilaianByJalan[$jid]);
            }
        }

        // Jika setelah filter tidak ada data, return collection kosong
        if (empty($penilaianByJalan)) return collect();

        // 5) Membuat matriks keputusan (X)
        $X = [];
        foreach ($penilaianByJalan as $jid => $p) {
            $rawJson = $p->nilai_kriteria;
            if (is_string($rawJson)) {
                $decoded = json_decode($rawJson, true);
                $nilai_kriteria = is_array($decoded) ? $decoded : [];
            } elseif (is_array($rawJson)) {
                $nilai_kriteria = $rawJson;
            } else {
                $nilai_kriteria = [];
            }

            $X[$jid] = [];
            foreach ($kriterias as $k) {
                $kidStr = (string)$k->id;
                $raw = null;
                
                // Cari nilai berdasarkan berbagai kemungkinan key
                if (array_key_exists($kidStr, $nilai_kriteria)) {
                    $raw = $nilai_kriteria[$kidStr];
                } elseif (array_key_exists((int)$kidStr, $nilai_kriteria)) {
                    $raw = $nilai_kriteria[(int)$kidStr];
                } elseif (array_key_exists($k->nama, $nilai_kriteria)) {
                    $raw = $nilai_kriteria[$k->nama];
                }

                $val = null;
                if ($raw !== null && $raw !== '') {
                    // Jika nilai adalah ID subkriteria, ambil nilai subkriteria
                    if (is_numeric($raw) && SubKriteria::where('id', (int)$raw)->exists()) {
                        $sub = SubKriteria::find((int)$raw);
                        $val = $sub ? (float)$sub->nilai : null;
                    } else {
                        // Jika nilai langsung numeric
                        $val = is_numeric($raw) ? (float)$raw : null;
                        
                        // Handle untuk kriteria jenis permukaan (aspal, beton, tanah)
                        if ($val === null && is_string($raw)) {
                            $val = $this->convertJenisPermukaanToNumeric($raw);
                        }
                    }
                }
                $X[$jid][$k->id] = $val;
            }
        }

        // 6) Hitung nilai min dan max per kriteria
        $min = [];
        $max = [];
        foreach ($kriterias as $k) {
            $vals = [];
            foreach ($X as $row) {
                $v = $row[$k->id] ?? null;
                if ($v !== null) {
                    $vals[] = (float)$v;
                }
            }
            $min[$k->id] = count($vals) > 0 ? min($vals) : 0;
            $max[$k->id] = count($vals) > 0 ? max($vals) : 1;
        }

        // 7) Normalisasi matriks (R) sesuai rumus MAUT
        $R = [];
        foreach ($X as $jid => $row) {
            $R[$jid] = [];
            foreach ($kriterias as $k) {
                $x_ij = $row[$k->id] ?? null;
                $x_min = $min[$k->id];
                $x_max = $max[$k->id];

                if ($x_ij === null) {
                    $r_ij = 0.0;
                } elseif (abs($x_max - $x_min) < 1e-12) {
                    // Hindari division by zero
                    $r_ij = 1.0;
                } else {
                    $tipe = strtolower(trim($k->tipe ?? 'benefit'));
                    
                    if ($tipe === 'cost') {
                        // Rumus untuk kriteria cost: r_ij = 1 + (min - x_ij) / (max - min)
                        $r_ij = 1.0 + (($x_min - $x_ij) / ($x_max - $x_min));
                    } else {
                        // Rumus untuk kriteria benefit: r_ij = (x_ij - min) / (max - min)
                        $r_ij = ($x_ij - $x_min) / ($x_max - $x_min);
                    }
                }

                // Pastikan nilai antara 0 dan 1
                $R[$jid][$k->id] = max(0.0, min(1.0, round($r_ij, 8)));
            }
        }

        // 8) Gunakan bobot dari database (sesuai dengan data kriteria Anda)
        $W = [];
        $totalBobot = 0.0;
        
        foreach ($kriterias as $k) {
            // Gunakan bobot langsung dari database
            $bobot = (float)($k->bobot ?? 0);
            $W[$k->id] = $bobot;
            $totalBobot += $bobot;
        }

        // Debug: Cek total bobot
        \Log::info("Total Bobot Kriteria: " . $totalBobot);
        foreach ($kriterias as $k) {
            \Log::info("Kriteria: {$k->nama}, Bobot: {$k->bobot}, Tipe: {$k->tipe}");
        }

        // 9) Hitung matriks utilitas (U) dan utilitas akhir
        $U = [];
        $nilaiAkhir = [];
        
        foreach ($R as $jid => $rowR) {
            $U[$jid] = [];
            $totalUtility = 0.0;
            
            foreach ($kriterias as $k) {
                $r_ij = $rowR[$k->id] ?? 0;
                $w_i = $W[$k->id] ?? 0;
                
                $u_ij = $r_ij * $w_i;
                $U[$jid][$k->id] = round($u_ij, 8);
                $totalUtility += $u_ij;
            }
            
            $nilaiAkhir[$jid] = round($totalUtility, 8);
        }

        // 10) Susun hasil dan urutkan berdasarkan nilai akhir (descending)
        $rows = [];
        foreach ($penilaianByJalan as $jid => $p) {
            // Pastikan jalan masih ada dan aktif
            if (isset($jalans[$jid])) {
                $rows[] = (object)[
                    'jalan' => $jalans[$jid],
                    'penilaian' => $p,
                    'X' => $X[$jid] ?? [],
                    'R' => $R[$jid] ?? [],
                    'U' => $U[$jid] ?? [],
                    'nilai_akhir' => $nilaiAkhir[$jid] ?? 0.0,
                    'kriterias' => $kriterias, // Tambahkan kriteria untuk view
                    'bobot' => $W, // Tambahkan bobot untuk view
                ];
            }
        }

        // Urutkan berdasarkan nilai akhir tertinggi ke terendah
        $collection = collect($rows)->sortByDesc('nilai_akhir')->values();

        // Tambahkan peringkat
        return $collection->map(function($item, $index) {
            $item->rank = $index + 1;
            return $item;
        });
    }

    /**
     * Konversi jenis permukaan jalan ke nilai numerik
     */
    private function convertJenisPermukaanToNumeric(string $jenis): float
    {
        $jenis = strtolower(trim($jenis));
        
        $nilaiMapping = [
            'aspal' => 3,
            'beton' => 2, 
            'tanah' => 1,
            'kerikil' => 1,
        ];
        
        return $nilaiMapping[$jenis] ?? 1;
    }

    /**
     * Konversi kondisi jalan ke nilai numerik  
     */
    private function convertKondisiJalanToNumeric(string $kondisi): float
    {
        $kondisi = strtolower(trim($kondisi));
        
        $nilaiMapping = [
            'baik' => 1,
            'sedang' => 2,
            'rusak ringan' => 3,
            'rusak berat' => 4,
        ];
        
        return $nilaiMapping[$kondisi] ?? 1;
    }

    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));
        $collection = $this->computeMautForSubmitted();

        // Filter berdasarkan pencarian
        if ($q !== '') {
            $collection = $collection->filter(function($item) use ($q) {
                $jalan = $item->jalan;
                return $jalan && (
                    stripos($jalan->nama_jalan, $q) !== false ||
                    stripos($jalan->kabupaten_kota ?? '', $q) !== false
                );
            })->values();
        }

        return view('hasil.index', [
            'collection' => $collection,
            'q' => $q,
        ]);
    }

    public function exportPdf(Request $request)
    {
        $q = trim($request->input('q', ''));
        $collection = $this->computeMautForSubmitted();

        // Filter berdasarkan pencarian
        if ($q !== '') {
            $collection = $collection->filter(function($item) use ($q) {
                $jalan = $item->jalan;
                return $jalan && (
                    stripos($jalan->nama_jalan, $q) !== false ||
                    stripos($jalan->kabupaten_kota ?? '', $q) !== false
                );
            })->values();
        }

        $pdf = PDF::loadView('hasil.pdf', ['collection' => $collection])
            ->setPaper('a4', 'portrait');
            
        return $pdf->download('hasil_prioritas_' . date('Ymd_His') . '.pdf');
    }

    /**
     * Method untuk debugging perhitungan
     */
    public function debugPerhitungan(Request $request)
    {
        $collection = $this->computeMautForSubmitted();
        
        // Ambil satu contoh untuk debug
        $contoh = $collection->first();
        
        $debugInfo = [
            'total_data' => $collection->count(),
            'contoh_perhitungan' => null,
        ];
        
        if ($contoh) {
            $debugInfo['contoh_perhitungan'] = [
                'jalan' => $contoh->jalan->nama_jalan ?? 'N/A',
                'nilai_akhir' => $contoh->nilai_akhir,
                'matriks_keputusan_X' => $contoh->X,
                'matriks_normalisasi_R' => $contoh->R,
                'matriks_utilitas_U' => $contoh->U,
            ];
        }
        
        return response()->json($debugInfo);
    }
}