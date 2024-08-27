<?php

namespace App\Http\Controllers\Rotasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class CabangController extends Controller
{
    public function index()
    {
        $cabangs = Cabang::with([
            "inDapat",
            "outDapat",
            "inDiterima",
            "outDiterima",
            "inTidakDapat",
            "outTidakDapat",
            "inAll",
            "outAll",
        ])->get();
        return view('rotasi.denah.index', ['cabangs' => $cabangs]);
    }
    public function detail(Request $request, $id)
    {
        $cabang = Cabang::with([
            "inAll",
            "outAll",
            "in",
            "out",
            "inACO",
            "outACO",
            "inAIS",
            "outAIS",
            "inATFM",
            "outATFM",
            "inTAPOR",
            "outTAPOR",
            "inATSSystem",
            "outATSSystem",
            "personelPensiunATC",
            'personelPensiunACO',
            'personelPensiunAIS',
            'personelPensiunATFM',
            'personelPensiunTAPOR',
            'personelPensiunATSSystem',
            "kelases" => function ($query) {
                $query->with('kelas');
            }
        ])->find($id);
        return view('rotasi.denah.cabang', ['cabang' => $cabang, 'tab' => $request->tab]);
    }

    public function inputView()
    {
        $kelases = Kelas::all();
        return view('rotasi.denah.input', ['kelases' => $kelases]);
    }
    public function input(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'kelas' => 'required|array|min:1',
            'kelas.*' => 'required|numeric|exists:kelas,id',
            'jumlah_personel' => 'required|numeric',
            'formasi' => 'required|numeric',
            'frms' => 'required|numeric',
            'jumlah_personel_aco' => 'required|numeric',
            'formasi_aco' => 'required|numeric',
            // 'frms_aco' => 'required|numeric',
            'jumlah_personel_ais' => 'required|numeric',
            'formasi_ais' => 'required|numeric',
            // 'frms_ais' => 'required|numeric',
            'jumlah_personel_atfm' => 'required|numeric',
            'formasi_atfm' => 'required|numeric',
            // 'frms_atfm' => 'required|numeric',
            'jumlah_personel_tapor' => 'required|numeric',
            'formasi_tapor' => 'required|numeric',
            // 'frms_tapor' => 'required|numeric',
            'jumlah_personel_ats_system' => 'required|numeric',
            'formasi_ats_system' => 'required|numeric',
            // 'frms_ats_system' => 'required|numeric',
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
        // $cabang->frms_aco = $request->frms_aco;

        $cabang->jumlah_personel_ais = $request->jumlah_personel_ais;
        $cabang->formasi_ais = $request->formasi_ais;
        // $cabang->frms_ais = $request->frms_ais;

        $cabang->jumlah_personel_atfm = $request->jumlah_personel_atfm;
        $cabang->formasi_atfm = $request->formasi_atfm;
        // $cabang->frms_atfm = $request->frms_atfm;

        $cabang->jumlah_personel_tapor = $request->jumlah_personel_tapor;
        $cabang->formasi_tapor = $request->formasi_tapor;
        // $cabang->frms_tapor = $request->frms_tapor;

        $cabang->jumlah_personel_ats_system = $request->jumlah_personel_ats_system;
        $cabang->formasi_ats_system = $request->formasi_ats_system;
        // $cabang->frms_ats_system = $request->frms_ats_system;

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
        foreach ($request->kelas as $kelas) {
            $cabang->kelases()->create([
                'kelas_id' => $kelas,
            ]);
        }
        DB::commit();
        return redirect()->route("rotasi.denah")->with('success', 'Cabang berhasil ditambahkan');
    }

    public function updateView($id)
    {
        $kelases = Kelas::all();
        $cabang = Cabang::with(['coord', 'kelases'])->find($id);
        if (!$cabang) {
            return redirect()->back()->with('invalid', 'Cabang tidak ditemukan');
        }
        return view('rotasi.denah.update', ['cabang' => $cabang, 'kelases' => $kelases]);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'alamat' => 'required',
            'kelas' => 'required|array|min:1',
            'kelas.*' => 'required|numeric|exists:kelas,id',
            'jumlah_personel' => 'required|numeric',
            'formasi' => 'required|numeric',
            'frms' => 'required|numeric',
            'jumlah_personel_aco' => 'required|numeric',
            'formasi_aco' => 'required|numeric',
            'jumlah_personel_ais' => 'required|numeric',
            'formasi_ais' => 'required|numeric',
            'jumlah_personel_atfm' => 'required|numeric',
            'formasi_atfm' => 'required|numeric',
            'jumlah_personel_tapor' => 'required|numeric',
            'formasi_tapor' => 'required|numeric',
            'jumlah_personel_ats_system' => 'required|numeric',
            'formasi_ats_system' => 'required|numeric',
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
        // $cabang->frms_aco = $request->frms_aco;

        $cabang->jumlah_personel_ais = $request->jumlah_personel_ais;
        $cabang->formasi_ais = $request->formasi_ais;
        // $cabang->frms_ais = $request->frms_ais;

        $cabang->jumlah_personel_atfm = $request->jumlah_personel_atfm;
        $cabang->formasi_atfm = $request->formasi_atfm;
        // $cabang->frms_atfm = $request->frms_atfm;

        $cabang->jumlah_personel_tapor = $request->jumlah_personel_tapor;
        $cabang->formasi_tapor = $request->formasi_tapor;
        // $cabang->frms_tapor = $request->frms_tapor;

        $cabang->jumlah_personel_ats_system = $request->jumlah_personel_ats_system;
        $cabang->formasi_ats_system = $request->formasi_ats_system;
        // $cabang->frms_ats_system = $request->frms_ats_system;

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
        foreach ($cabang->kelases as $kelas) {
            $kelas->delete();
        }
        foreach ($request->kelas as $kelas) {
            $cabang->kelases()->create([
                'kelas_id' => $kelas,
            ]);
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
