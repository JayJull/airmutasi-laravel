<?php

namespace App\Http\Controllers\Rotasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
{
    public function index()
    {
        $cabangs = Cabang::all();
        return view('rotasi.denah.index', ['cabangs' => $cabangs]);
    }
    public function cabang(Request $request, $id)
    {
        $cabang = Cabang::with(["inAll", "outAll", "in", "out", "inACO", "outACO"])->find($id);
        return view('rotasi.denah.cabang', ['cabang' => $cabang, 'tab' => $request->tab]);
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

    public function inputView()
    {
        return view('rotasi.denah.input');
    }
    public function input(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'jumlah_personel' => 'required|numeric',
            'formasi' => 'required|numeric',
            'frms' => 'required|numeric',
            'jumlah_personel_aco' => 'required|numeric',
            'formasi_aco' => 'required|numeric',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        DB::beginTransaction();
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

        $cabang->jumlah_personel_aco = $request->jumlah_personel_aco;
        $cabang->formasi_aco = $request->formasi_aco;

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
        DB::commit();
        return redirect()->route("rotasi.denah")->with('success', 'Cabang berhasil ditambahkan');
    }

    public function updateView($id)
    {
        $cabang = Cabang::find($id);
        if (!$cabang) {
            return redirect()->back()->with('invalid', 'Cabang tidak ditemukan');
        }
        return view('rotasi.denah.update', ['cabang' => $cabang]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'jumlah_personel' => 'required|numeric',
            'formasi' => 'required|numeric',
            'frms' => 'required|numeric',
            'jumlah_personel_aco' => 'required|numeric',
            'formasi_aco' => 'required|numeric',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);
        DB::beginTransaction();
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

        $cabang->jumlah_personel_aco = $request->jumlah_personel_aco;
        $cabang->formasi_aco = $request->formasi_aco;

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
        DB::commit();
        return redirect()->route("rotasi.denah")->with('success', 'Cabang berhasil diupdate');
    }

    public function delete($id)
    {
        $cabang = Cabang::find($id);
        if (!$cabang) {
            return redirect()->back()->with('invalid', 'Cabang tidak ditemukan');
        }
        $cabang->delete();
        return redirect()->route("rotasi.denah")->with('success', 'Cabang berhasil dihapus');
    }
}