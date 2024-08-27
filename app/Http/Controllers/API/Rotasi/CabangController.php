<?php

namespace App\Http\Controllers\API\Rotasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;

class CabangController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->search;

        $cabangs = Cabang::whereRaw('UPPER(nama) LIKE ?', ['%' . strtoupper($search) . '%'])->get();
        return response()->json($cabangs);
    }
    public function summary($id)
    {
        $cabang = Cabang::select('id', 'nama', 'alamat', 'thumbnail_url')->where('id', $id)->first();
        return response()->json($cabang);
    }
    public function inKelas($kelas)
    {
        $cabangs = Cabang::whereHas('kelases', function ($query) use ($kelas) {
            $query->where('kelas_id', $kelas);
        })->get();
        return response()->json($cabangs);
    }
    public function inSameKelas($id)
    {
        $cabang = Cabang::with('kelases')->find($id);
        if ($cabang && $cabang->kelases) {
            $cabangs = Cabang::whereHas('kelases', function ($query) use ($cabang) {
                $query->whereIn('kelas_id', $cabang->kelases->pluck('kelas_id'));
            })->get();
            return response()->json($cabangs);
        }
        return response()->json([]);
    }
    public function all()
    {
        $cabangs = Cabang::all();
        return response()->json($cabangs);
    }
    public function listInduk()
    {
        $cabang = Cabang::has("coord")->get()->map(function ($cabang) {
            return [
                'id' => $cabang->id,
                'nama' => $cabang->nama,
                'alamat' => $cabang->alamat,
                'thumbnail_url' => $cabang->thumbnail_url,
                'latitude' => $cabang->coord->latitude,
                'longitude' => $cabang->coord->longitude,
            ];
        });
        return response()->json($cabang);
    }
}
