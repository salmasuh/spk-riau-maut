<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mobil;
use Illuminate\Support\Facades\Storage;

class MobilController extends Controller
{
    public function index()
    {
        $mobils = Mobil::orderBy('nama','desc')->get();
        
        return view ('mobil.index', compact('mobils'));
    }

    public function create()
    {
        return view('mobil.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama' => 'required|min:5',
            'deskripsi' => 'required|min:10',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        $gambar = $request->file('gambar');
        $gambar->storeAs('public/mobil', $gambar->hashName());

        Mobil::create([
            'gambar' => $gambar->hashName(),
            'nama'   => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok'  => $request->stok
        ]);
        
        return redirect()->route('mobil.index')
                        ->with('success','Data Berhasil Disimpan!');
    }

    public function show(Mobil $mobil)
    {
        return view('mobil.show', compact('mobil'));
    }

    public function edit(Mobil $mobil)
    {
        return view('mobil.edit', compact('mobil'));
    }

    public function update(Request $request, Mobil $mobil)
    {
        $request->validate([
            'gambar' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'nama' => 'required|min:5',
            'deskripsi' => 'required|min:10',
            'harga' => 'required|numeric',
            'stok' => 'required|numeric'
        ]);

        if($request->hasFile('gambar')) {
        
            $gambar = $request->file('gambar');
            $gambar->storeAs('public/mobil', $gambar->hashName());

            $mobil->update([
            'gambar' => $gambar->hashName(),
            'nama'   => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok'  => $request->stok
        ]);
        }else {

            $mobil->update([
            'nama'   => $request->nama,
            'deskripsi' => $request->deskripsi,
            'harga' => $request->harga,
            'stok'  => $request->stok
        ]);
        }
        
        return redirect()->route('mobil.index')->with('success','Data berhasil diubah');
    }

    public function destroy(Mobil $mobil)
    {
        Storage::delete('mobil/' . $mobil->gambar);
        $mobil->delete();

        return redirect()->route('mobil.index')->with('success','data berhasil dihapus');
    }
}