<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class KriteriaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        $query = Kriteria::query()->orderBy('nama');

        if ($q) {
            $query->where(function($w) use ($q) {
                $w->where('nama', 'like', "%{$q}%")
                  ->orWhere('deskripsi', 'like', "%{$q}%");
            });
        }

        $kriterias = $query->paginate(10)->withQueryString();

        // total bobot untuk kriteria aktif (sum bobot active)
        $totalBobotAktif = (float) Kriteria::where('status','aktif')->sum('bobot');

        // sisa yang masih kurang supaya total jadi 1.0000 (bila <0 jadi 0)
        $sisaBobot = 1.0 - $totalBobotAktif;
        if ($sisaBobot < 0) $sisaBobot = 0.0;

        return view('kriteria.index', compact('kriterias','q','totalBobotAktif','sisaBobot'));
    }

    public function create()
    {
        $totalBobotAktif = round(
            (float) Kriteria::where('status','aktif')->sum('bobot'),
            2
        );

        $sisaBobot = max(0, round(1 - $totalBobotAktif, 2));

        return view('kriteria.create', compact('totalBobotAktif','sisaBobot'));
    }

    public function store(Request $request)
    {
        $totalAktifSaatIni = round(
            (float) Kriteria::where('status','aktif')->sum('bobot'),
            2
        );

        // JIKA TOTAL SUDAH 1.00 → TOLAK TOTAL
        if ($totalAktifSaatIni >= 1.00) {
            return redirect()->back()
                ->withErrors([
                    'bobot' => 'Total bobot kriteria sudah mencapai 1.00. Tidak dapat menambahkan kriteria baru.'
                ])
                ->withInput();
        }
        
        // Validasi dasar
        $rules = [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bobot' => 'required|numeric|gt:0|lte:1',
            'tipe' => ['required', Rule::in(['benefit','cost'])],
            'status' => ['required', Rule::in(['aktif','tidak_aktif'])],
        ];

        $validator = Validator::make($request->all(), $rules);

        // jika validasi field gagal, balikkan
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Periksa total bobot (server-side) - keamanan
        $bobotBaru = round((float) $request->input('bobot'), 2);
        $statusBaru = $request->input('status');

        // Hitung total bobot aktif saat ini
        $totalAktifSaatIni = (float) Kriteria::where('status','aktif')->sum('bobot');

        // Jika status baru aktif, maka cek apakah total + bobotBaru > 1
        if ($statusBaru === 'aktif' && bcadd((string)$totalAktifSaatIni, (string)$bobotBaru, 4) > 1.0000) {
            // kembalikan error
            return redirect()->back()
                ->withErrors(['bobot' => 'Jumlah total bobot kriteria aktif tidak boleh melebihi 1. (Total saat ini: '.number_format($totalAktifSaatIni,4).')'])
                ->withInput();
        }

        Kriteria::create([
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
            'bobot' => $bobotBaru,
            'tipe' => $request->input('tipe'),
            'status' => $statusBaru,
        ]);

        Session::flash('success','Kriteria berhasil ditambahkan.');
        return redirect()->route('kriteria.index');
    }

    public function edit(Kriteria $kriteria)
    {
        // total aktif selain kriteria ini
        $totalAktifLainnya = (float) Kriteria::where('status','aktif')
                                ->where('id','!=',$kriteria->id)
                                ->sum('bobot');

        $sisaTanpaItemIni = 1.0 - $totalAktifLainnya;
        if ($sisaTanpaItemIni < 0) $sisaTanpaItemIni = 0.0;

         // total aktif saat ini termasuk item ini (opsional, untuk tampilan)
        $totalAktifTermasukIni = (float) Kriteria::where('status','aktif')->sum('bobot');

        return view('kriteria.edit', [
            'kriteria' => $kriteria,
            'totalAktifLainnya' => $totalAktifLainnya,
            'sisaBobot' => $sisaTanpaItemIni,
            'totalAktifTermasukIni' => $totalAktifTermasukIni
        ]);
    }

    public function update(Request $request, Kriteria $kriteria)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'bobot' => 'required|numeric|between:0,1',
            'tipe' => ['required', Rule::in(['benefit','cost'])],
            'status' => ['required', Rule::in(['aktif','tidak_aktif'])],
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $bobotBaru = round((float) $request->input('bobot'), 2);
        $statusBaru = $request->input('status');

        $totalAktifLainnya = (float) Kriteria::where('status','aktif')
                                ->where('id','!=',$kriteria->id)
                                ->sum('bobot');

        // Jika statusBaru aktif, total = totalAktifLainnya + bobotBaru must <= 1
        if ($statusBaru === 'aktif' && bcadd((string)$totalAktifLainnya, (string)$bobotBaru, 4) > 1.0000) {
            return redirect()->back()
                ->withErrors(['bobot' => 'Jumlah total bobot kriteria aktif tidak boleh melebihi 1. (Total saat ini tanpa item ini: '.number_format($totalAktifLainnya,4).')'])
                ->withInput();
        }

        $kriteria->update([
            'nama' => $request->input('nama'),
            'deskripsi' => $request->input('deskripsi'),
            'bobot' => $bobotBaru,
            'tipe' => $request->input('tipe'),
            'status' => $statusBaru,
        ]);

        Session::flash('success','Kriteria berhasil diperbarui.');
        return redirect()->route('kriteria.index');
    }

    public function destroy(Kriteria $kriteria)
    {
        $kriteria->delete();
        Session::flash('success','Kriteria berhasil dihapus.');
        return redirect()->route('kriteria.index');
    }
}