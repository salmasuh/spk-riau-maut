<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\SubKriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Schema;

class SubKriteriaController extends Controller
{
    /** Halaman daftar Sub Kriteria */
    public function index(Request $request)
    {
        $q = trim($request->input('q', ''));
        $kriteriaStatus = $request->input('kriteria_status');

        $kriteriaQuery = Kriteria::query()->orderBy('nama');

        if (in_array($kriteriaStatus, ['aktif', 'tidak_aktif'])) {
            $kriteriaQuery->where('status', $kriteriaStatus);
        }

        if (!empty($q)) {
            $like = "%{$q}%";
            $kriteriaQuery->where(function ($builder) use ($like) {
                $builder->where('nama', 'like', $like)
                    ->orWhereHas('subKriterias', function ($sub) use ($like) {
                        $sub->where('nama', 'like', $like)
                            ->orWhere('deskripsi', 'like', $like);
                    });
            });
        }

        $kriteriaList = $kriteriaQuery->with(['subKriterias' => function ($sub) {
            $sub->orderBy('nilai', 'desc');
        }])->get();

        return view('subkriteria.index', [
            'kriteriaList' => $kriteriaList,
            'q' => $q,
            'kriteriaStatus' => $kriteriaStatus,
        ]);
    }

    /** Form tambah */
    public function create(Request $request)    
    {
        $kriteriaList = Kriteria::where('status', 'aktif')->orderBy('nama')->get();
        $selectedKriteria = $request->input('kriteria_id');
        $selectedKriteriaName = null;
        $maxAllowed = 5;

        if ($selectedKriteria) {
            $selectedKriteriaName = Kriteria::find($selectedKriteria)?->nama;
        }

        // preserve filters agar kembali ke index dengan filter sama
    $preserve = $request->only(['q','kriteria_status','page']);

        return view('subkriteria.create', compact('kriteriaList', 'selectedKriteria', 'selectedKriteriaName', 'maxAllowed', 'preserve'));
    }

    /** Simpan data baru */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kriteria_id' => ['required', 'integer', 'exists:kriterias,id'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'nilai' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        // Cek jumlah subkriteria saat ini
        $count = SubKriteria::where('kriteria_id', $data['kriteria_id'])->count();
        if ($count >= 5) {
            return back()->withErrors(['kriteria_id' => 'Setiap kriteria hanya boleh memiliki maksimal 5 sub kriteria.'])->withInput();
        }

        // Pastikan nilai tidak duplikat dalam kriteria yang sama
        $exists = SubKriteria::where('kriteria_id', $data['kriteria_id'])
            ->where('nilai', $data['nilai'])
            ->exists();

        if ($exists) {
            return back()->withErrors(['nilai' => 'Nilai tersebut sudah digunakan pada sub kriteria lain dalam kriteria ini.'])->withInput();
        }

        // Tambahkan default status jika ada kolomnya
        if (Schema::hasColumn('sub_kriterias', 'status')) {
            $data['status'] = 'aktif';
        }

        // simpan
        SubKriteria::create($data);

        // ambil preserve dari request (hidden inputs)
        $preserve = $request->only(['q','kriteria_status','page']);

        // kirim success flash
        Session::flash('success', 'Sub-kriteria berhasil ditambahkan.');

        // redirect ke index dengan query params jika ada
        $preserve = array_filter($preserve, fn($v) => $v !== null && $v !== '');
        if (!empty($preserve)) {
            return redirect()->route('subkriteria.index', $preserve);
    }

    return redirect()->route('subkriteria.index');
    }

    /** Form edit */
    public function edit(SubKriteria $subkriteria)
    {
        $maxAllowed = 5;
        return view('subkriteria.edit', compact('subkriteria', 'maxAllowed'));
    }

    /** Update data */
    public function update(Request $request, SubKriteria $subkriteria)
    {
        $data = $request->validate([
            'kriteria_id' => ['required', 'integer', 'exists:kriterias,id'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'nilai' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        // Pastikan nilai tidak duplikat di kriteria yang sama, kecuali nilai lama
        $exists = SubKriteria::where('kriteria_id', $data['kriteria_id'])
            ->where('nilai', $data['nilai'])
            ->where('id', '!=', $subkriteria->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['nilai' => 'Nilai tersebut sudah digunakan pada sub kriteria lain dalam kriteria ini.'])->withInput();
        }

        $subkriteria->update($data);

        $preserve = $request->only(['q','kriteria_status','page']);
        Session::flash('success', 'Sub-kriteria berhasil diperbarui.');
        return redirect()->route('subkriteria.index', array_filter($preserve));
    }

    /** Hapus data */
    public function destroy(SubKriteria $subkriteria)
    {
        $kriteriaId = $subkriteria->kriteria_id;
        $subkriteria->delete();

        Session::flash('success', 'Sub-kriteria berhasil dihapus.');
        return redirect()->route('subkriteria.index');
    }
}