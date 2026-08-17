<?php

namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class MahasiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mahasiswas = Mahasiswa::orderBy('nama','asc')->get();
        return view('mahasiswa.index',compact('mahasiswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('mahasiswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            'nim'=>'required|unique:mahasiswas',
            'fakultas'=>'required',
            'status'=>'required',
            'alamat'=>'nullable',
        ]);

        Mahasiswa::create([
        'nama' => $request->nama,
        'nim' => $request->nim,
        'fakultas' => $request->fakultas,
        'status' => $request->status,
        'alamat' => $request->alamat,
    ]);
        return redirect()->route('mahasiswa.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Mahasiswa $mahasiswa)
    {
        return view('mahasiswa.edit',compact('mahasiswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mahasiswa $mahasiswa)
    {
        $request->validate([
            'nama'=>'required',
            'nim'=>'required|unique:mahasiswas,nim,'.$mahasiswa->id,
            'fakultas'=>'required',
            'status'=>'required',
            'alamat'=>'nullable',
        ]);

        $mahasiswa->update($request->all());
        return redirect()->route('mahasiswa.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mahasiswa $mahasiswa)
    {
        $mahasiswa->delete();
        return redirect()->route('mahasiswa.index');
    }
}
