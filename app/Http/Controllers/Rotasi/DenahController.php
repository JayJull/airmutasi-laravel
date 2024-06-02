<?php

namespace App\Http\Controllers\Rotasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;

class DenahController extends Controller
{
    public function index()
    {
        $cabangs = Cabang::all();
        return view('rotasi.denah.index', ['cabangs' => $cabangs]);
    }
    public function cabang($id)
    {
        $cabang = Cabang::find($id);
        return view('rotasi.denah.cabang', ['cabang' => $cabang]);
    }

    public function cabangSearch(Request $request)
    {
        $search = $request->search;

        $cabangs = Cabang::whereRaw('UPPER(nama) LIKE ?', ['%'.strtoupper($search).'%'])->get();
        return response()->json($cabangs);
    }
    public function cabangSummary($id)
    {
        $cabang = Cabang::select('id', 'nama', 'alamat', 'thumbnail')->where('id', $id)->first();
        return response()->json($cabang);
    }
    public function listCabangInduk()
    {
        $cabang = Cabang::has("coord")->get()->map(function ($cabang) {
            return [
                'id' => $cabang->id,
                'nama' => $cabang->nama,
                'alamat' => $cabang->alamat,
                'thumbnail' => $cabang->thumbnail,
                'latitude' => $cabang->coord->latitude,
                'longitude' => $cabang->coord->longitude,
            ];
        });
        return response()->json($cabang);
    }
}
