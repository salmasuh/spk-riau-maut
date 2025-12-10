<?php

namespace App\Http\Controllers;

use App\Models\Jalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Str;

class JalanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->input('q');
        $status = $request->input('status');

        $query = Jalan::query()->orderBy('nama_jalan');

        if ($q) {
            $query->where(function($w) use ($q) {
                $w->where('nama_jalan', 'like', "%{$q}%")
                ->orWhere('kabupaten_kota', 'like', "%{$q}%");
            });
        }

        // kalau status diset dan bukan string kosong, lakukan pencocokan case-insensitive dan trim
        if (!is_null($status) && trim($status) !== '') {
            $statusNormalized = Str::lower(trim($status));
            // bandingkan lower(status) di DB dengan nilai normalisasi
            $query->whereRaw('LOWER(`status`) = ?', [$statusNormalized]);
        }

        $jalans = $query->paginate(10)->withQueryString();
        $totalJalan = Jalan::count();

        return view('jalan.index', compact('jalans', 'q', 'status', 'totalJalan'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jalan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $validated = $request->validate([
            'nama_jalan' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_input' => 'required|date|before_or_equal:today',
        ]);

        $validated['tanggal_input'] = Carbon::now(); // otomatis tanggal saat ini

        Jalan::create($validated);

        return redirect()->route('jalan.index')->with('success', 'Data Jalan berhasil ditambahkan!');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jalan $jalan)
    {
        return view('jalan.edit', compact('jalan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jalan $jalan)
    {
        $data = $request->validate([
            'nama_jalan' => 'required|string|max:255',
            'kabupaten_kota' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_input' => 'required|date|before_or_equal:today',
        ]);

        if (empty($data['tanggal_input'])) {
            $data['tanggal_input'] = now()->toDateString();
        }

        $jalan->update($data);

        Session::flash('success', 'Data jalan berhasil diperbarui.');

       // Ambil nilai filter yang kita simpan di hidden field filter_status
        $preserve = [
            'q' => $request->input('q'),
            // map filter_status menjadi query param 'status' saat redirect
            'status' => $request->input('filter_status'),
            'page' => $request->input('page'),
        ];

        // hapus elemen kosong supaya url tidak penuh param kosong
        $preserve = array_filter($preserve, fn($v) => $v !== null && $v !== '');

        if (!empty($preserve)) {
            return redirect()->route('jalan.index', $preserve);
        }

        return redirect()->route('jalan.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jalan $jalan)
    {
        $jalan->delete();

        Session::flash('success', 'Data jalan berhasil dihapus.');
        return redirect()->route('jalan.index');
    }
}