<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SikusikuController extends Controller
{
    public function index()
    {
        return view('sikusiku.index');
    }
    public function hitung(Request $request)
    {
        $request->validate([
            'alas' => 'required|numeric',
            'sisitegak' => 'required|numeric'
        ]);

        $alas=$request->alas;
        $sisitegak=$request->sisitegak;

        $luas= 1/2 * $alas * $sisitegak;

        return view('sikusiku.index',compact('alas','sisitegak','luas'));
    }
}
