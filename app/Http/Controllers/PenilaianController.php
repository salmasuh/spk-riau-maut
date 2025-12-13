<?php

namespace App\Http\Controllers;

use App\Models\Penilaian;
use App\Models\Jalan;
use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        // Filter jalan aktif + search
        $jalans = Jalan::where('status', 'aktif')
            ->when($q, function ($query) use ($q) {
                $query->where('nama_jalan', 'LIKE', "%{$q}%");
            })
            ->orderBy('nama_jalan')
            ->get();

        // Filter penilaian berdasarkan jalan aktif + search
        $penilaians = Penilaian::whereHas('jalan', function($query) use ($q){
            $query->where('status', 'aktif');

            if ($q) {
                $query->where('nama_jalan', 'LIKE', "%{$q}%");
            }
        })
        ->with('jalan')
        ->get()
        ->keyBy('jalan_id');

        $kriterias = Kriteria::where('status','aktif')
            ->with(['subKriterias' => function($q){
                $q->orderBy('nilai','desc');
            }])
            ->orderBy('nama')
            ->get();

        // Ambil subkriteria yang sedang dipakai
        $subIds = collect($penilaians)->flatMap(function($p){
            return is_array($p->nilai_kriteria) ? array_values($p->nilai_kriteria) : [];
        })->unique()->filter()->all();

        $subKriterias = SubKriteria::whereIn('id', $subIds)->get()->keyBy('id');

        // Tambahan hitung total data jalan submitted
        $totalSubmitted = Penilaian::where('status', 'submitted')
            ->whereHas('jalan', function($query) use ($q){
                $query->where('status', 'aktif');

                if ($q) {
                    $query->where('nama_jalan', 'LIKE', "%{$q}%");
                }
            })
            ->count();
        $totalJalan = Jalan::where('status', 'aktif')->count();
        return view('penilaian.index', compact('jalans', 'penilaians', 'kriterias', 'subKriterias', 'q', 'totalSubmitted', 'totalJalan'));
    }

    public function manageByJalan(Jalan $jalan)
    {
        $penilaian = Penilaian::where('jalan_id', $jalan->id)->first();

        // Jika penilaian ada dan jalannya baru saja diaktifkan kembali,
        // reset agar wajib input ulang
        if ($penilaian && $jalan->status === 'aktif') {

            // Reset data
            $penilaian->update([
                'nilai_kriteria' => [],
                'status' => 'draft'
            ]);

            // Reload setelah reset
            $penilaian->refresh();
        }

        // Jika belum ada penilaian, buat object kosong
        if (! $penilaian) {
            $penilaian = new Penilaian();
            $penilaian->jalan_id = $jalan->id;
            $penilaian->status = 'draft';
            $penilaian->nilai_kriteria = [];
        } else {
            $penilaian->load('jalan');
        }

        $kriterias = Kriteria::where('status', 'aktif')
            ->with(['subKriterias' => function($q){ $q->orderBy('nilai','desc'); }])
            ->orderBy('nama')->get();

        return view('penilaian.edit', compact('penilaian','jalan','kriterias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'jalan_id' => 'required|exists:jalans,id',
            'nilai_kriteria' => 'required|array',
            'nilai_kriteria.*' => 'nullable|exists:sub_kriterias,id',
            'status' => 'required|in:draft,submitted',
        ],[
            'nilai_kriteria.*.exists' => 'Salah satu pilihan sub-kriteria tidak valid.',
            'status.in' => 'Status yang dipilih tidak valid.',
        ]);

        Penilaian::create([
            'jalan_id' => $data['jalan_id'],
            'nilai_kriteria' => $data['nilai_kriteria'],
            'status' => $data['status'],
        ]);

        return redirect()->route('penilaian.index')->with('success','Penilaian berhasil dibuat.');
    }

    public function update(Request $request, Penilaian $penilaian)
    {
        $data = $request->validate([
            'nilai_kriteria' => 'required|array',
            'nilai_kriteria.*' => 'nullable|exists:sub_kriterias,id',
            'status' => 'required|string|in:draft,submitted',
        ],[
            'nilai_kriteria.*.exists' => 'Salah satu pilihan sub-kriteria tidak valid.',
            'status.in' => 'Status yang dipilih tidak valid.',
        ]);

        $penilaian->update([
            'nilai_kriteria' => $data['nilai_kriteria'],
            'status' => $data['status'],
        ]);

        return redirect()->route('penilaian.index')->with('success', 'Data penilaian berhasil diperbarui.');
    }
    public function destroy(Penilaian $penilaian)
    {
        $penilaian->delete();
        
        return redirect()->route('penilaian.index')->with('success', 'Data penilaian berhasil dihapus.');
    }
}