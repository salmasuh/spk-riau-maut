<?php

namespace App\Http\Controllers;

use App\Models\Jalan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

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

        $jalans = $query->get();
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
        $request->validate([
            'nama_jalan' => [
            'required',
            'string',
            'max:255',
            Rule::unique('jalans', 'nama_jalan_lower'),
        ],
            'kabupaten_kota' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_input' => 'required|date|before_or_equal:today',
        ]);

        $namaJalan = Str::title(Str::lower(trim($request->nama_jalan)));

        Jalan::create([
            'nama_jalan'     => $namaJalan,
            'kabupaten_kota' => Str::title(Str::lower($request->kabupaten_kota)),
            'status'         => $request->status,
            'tanggal_input'  => $request->tanggal_input,
        ]);

        return redirect()
            ->route('jalan.index')
            ->with('success', 'Data jalan berhasil ditambahkan.');
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
        $request->validate([
            'nama_jalan' => [
            'required',
            'string',
            'max:255',
            Rule::unique('jalans', 'nama_jalan_lower')->ignore($jalan->id),
        ],
            'kabupaten_kota' => 'required|string|max:255',
            'status' => 'required|in:Aktif,Tidak Aktif',
            'tanggal_input' => 'required|date|before_or_equal:today',
        ]);

        $jalan->update([
            'nama_jalan'     => Str::title(Str::lower(trim($request->nama_jalan))),
            'kabupaten_kota' => Str::title(Str::lower($request->kabupaten_kota)),
            'status'         => $request->status,
            'tanggal_input'  => $request->tanggal_input,
        ]);

        return redirect()
            ->route('jalan.index', request()->only(['q','status','page']))
            ->with('success', 'Data jalan berhasil diperbarui.');
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
    public function importForm()
    {
        return view('jalan.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);

        $handle = fopen($request->file('file')->getRealPath(), 'r');

        $inserted = 0;
        $skipped  = 0;

        while (($row = fgetcsv($handle, 0, ';')) !== false) {

            /*
            Struktur CSV laporan:
            [0] NOMOR RUAS
            [1] NAMA RUAS
            [2] STATUS
            [3] PANJANG
            [4] KABUPATEN/KOTA YANG DILALUI
            */

            $nomor     = trim($row[0] ?? '');
            $namaRuas  = Str::title(Str::lower(trim($row[4] ?? '')));
            $kabupaten = Str::title(Str::lower(trim($row[5] ?? '')));

            // SKIP HEADER & BARIS TIDAK VALID
            if (
                !is_numeric($nomor) ||   // header & catatan pasti bukan angka
                empty($namaRuas) ||             // nama tidak boleh kosong
                is_numeric($namaRuas) ||        // nama TIDAK boleh angka
                strlen($namaRuas) < 5
            ) {
                continue;
            }

            // CEK DUPLIKAT
            $exists = Jalan::whereRaw(
                'LOWER(nama_jalan) = ?',
                [Str::lower($namaRuas)]
            )->exists();

            if ($exists) {
                $skipped++;
                continue;
            }

            Jalan::create([
                'nama_jalan'     => $namaRuas,
                'kabupaten_kota' => $kabupaten ?: '-',
                'status'         => 'Aktif',
                'tanggal_input'  => now(),
            ]);

            $inserted++;
        }

        fclose($handle);

        return redirect()
            ->route('jalan.index')
            ->with('success', "{$inserted} data jalan berhasil diimport dari file laporan.")
            ->with('warning', $skipped > 0
                ? "{$skipped} data dilewati karena nama jalan sudah ada."
                : null
            );
    }
}