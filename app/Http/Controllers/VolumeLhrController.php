<?php

namespace App\Http\Controllers;

use App\Models\Jalan;
use App\Models\VolumeLhr;
use Illuminate\Http\Request;

class VolumeLhrController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        if($q){
            $jalans=Jalan::where('status','Aktif')
                ->where('nama_jalan','like','%'.$q.'%')
                ->with('volume_lhr')
                ->orderBy('nama_jalan','asc')
                ->get();
        }else{
            $jalans=Jalan::where('status','Aktif')
                ->with('volume_lhr')
                ->orderBy('nama_jalan','asc')
                ->get();
        }
        return view('volume_lhr.index',compact('jalans','q'));
    } 

    public function create($jalans)
    {
        $jalans = Jalan::where('id', $jalans)->first();

        return view('volume_lhr.create', compact('jalans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jalan_id' => 'required',
            'volume_lhr' => 'required|numeric|max:200000',
            'keterangan' => 'nullable'
        ]);

        VolumeLhr::create([
            'jalan_id' => $request->jalan_id,
            'volume_lhr' => $request->volume_lhr,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('volume_lhr.index')
            ->with('success','Data Ditambahkan');
    }

    public function edit(VolumeLhr $volume_lhr)
    {
        $jalans = Jalan::where('status','Aktif')->get();

        return view('volume_lhr.edit',compact('volume_lhr','jalans'));
    }

    public function update(VolumeLhr $volume_lhr, Request $request)
    {
        $request->validate([
            'jalan_id'  => 'required',
            'volume_lhr' => 'required|numeric|min:200000',
            'keterangan' => 'nullable'
        ]);

        $volume_lhr->update([
            'jalan_id'  => $request->jalan_id,
            'volume_lhr'=> $request->volume_lhr,
            'keterangan'=> $request->keterangan
        ]);

        return redirect()->route('volume_lhr.index')
            ->with('success','Data berhasil');
    }

    public function destroy(VolumeLhr $volume_lhr)
    {
        $volume_lhr->delete();

        return redirect()->route('volume_lhr.index')
            ->with('success','Berhasil');
    }
}