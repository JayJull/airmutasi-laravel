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

        $cabangs = Cabang::whereRaw('UPPER(nama) LIKE ?', ['%' . strtoupper($search) . '%'])->get();
        return response()->json($cabangs);
    }
    public function cabangSummary($id)
    {
        $cabang = Cabang::select('id', 'nama', 'alamat', 'thumbnail_url')->where('id', $id)->first();
        return response()->json($cabang);
    }
    public function listCabangInduk()
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

    public function inputCabangView()
    {
        return view('rotasi.denah.input');
    }
    public function inputCabang(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'jumlah_personel' => 'required|numeric',
            'formasi' => 'required|numeric',
            'frms' => 'required|numeric',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $cabang = new Cabang();
        $cabang->nama = $request->nama;
        $cabang->alamat = $request->alamat;
        if ($request->has('thumbnail')) {
            $cabang->thumbnail_url = '/storage/' . $request->thumbnail->store('cabang', 'public');
        } else {
            $cabang->thumbnail_url = $request->thumbnail_url;
        }
        $cabang->jumlah_personel = $request->jumlah_personel;
        $cabang->formasi = $request->formasi;
        $cabang->frms = $request->frms;

        if ($request->has('induk')) {
            $request->validate([
                'latitude' => 'required',
                'longitude' => 'required',
            ]);
            $cabang->save();
            $cabang->coord()->create([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        } else {
            $cabang->save();
        }
        return redirect()->route("rotasi.denah")->with('success', 'Cabang berhasil ditambahkan');
    }

    public function updateCabangView($id)
    {
        $cabang = Cabang::find($id);
        if (!$cabang) {
            return redirect()->back()->with('invalid', 'Cabang tidak ditemukan');
        }
        return view('rotasi.denah.update', ['cabang' => $cabang]);
    }
    public function updateCabang(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'jumlah_personel' => 'required|numeric',
            'formasi' => 'required|numeric',
            'frms' => 'required|numeric',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        $cabang = Cabang::find($id);
        $cabang->nama = $request->nama;
        $cabang->alamat = $request->alamat;
        if ($request->has('thumbnail')) {
            $cabang->thumbnail_url = '/storage/' . $request->thumbnail->store('cabang', 'public');
        } else {
            $cabang->thumbnail_url = $request->thumbnail_url;
        }
        $cabang->jumlah_personel = $request->jumlah_personel;
        $cabang->formasi = $request->formasi;
        $cabang->frms = $request->frms;

        if ($request->has('induk')) {
            $request->validate([
                'latitude' => 'required',
                'longitude' => 'required',
            ]);
            $cabang->save();
            $cabang->coord()->update([
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]);
        } else {
            if ($cabang->coord()->exists())
                $cabang->coord()->delete();
            $cabang->save();
        }
        return redirect()->route("rotasi.denah")->with('success', 'Cabang berhasil diupdate');
    }

    public function deleteCabang($id)
    {
        $cabang = Cabang::find($id);
        if (!$cabang) {
            return redirect()->back()->with('invalid', 'Cabang tidak ditemukan');
        }
        $cabang->delete();
        return redirect()->route("rotasi.denah")->with('success', 'Cabang berhasil dihapus');
    }
}
