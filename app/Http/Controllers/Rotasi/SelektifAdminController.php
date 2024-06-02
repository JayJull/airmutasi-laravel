<?php

namespace App\Http\Controllers\Rotasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Carbon\Carbon;

class SelektifAdminController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $tab = $request->tab;
        $pengajuans = Pengajuan::where('status', $tab === "dapat" ? 'dapat' : ($tab === "tidak_dapat" ? "tidak_dapat" : 'diajukan'))->get()->map(function ($pengajuan) {
            $pengajuan->tanggal_pengajuan = Carbon::parse($pengajuan->created_at)->format('d-m-Y');
            return $pengajuan;
        });
        if ($id !== null) {
            $pengajuan = Pengajuan::find($id);
            if (!$pengajuan || $pengajuan->status !== ($tab === "dapat" ? "dapat" : ($tab === "tidak_dapat" ? "tidak_dapat" : 'diajukan'))) {
                return redirect()->route('rotasi.selektif');
            }
            $pengajuan->tanggal_pengajuan = Carbon::parse($pengajuan->created_at)->format('d-m-Y');
        }else{
            $pengajuan = $pengajuans->first();
        }
        return view('rotasi.selektif.index', ['pengajuans' => $pengajuans, 'pengajuan' => $pengajuan, 'tab' => $tab]);
    }

    public function selektif($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:dapat,tidak,diterima'
        ]);
        $pengajuan = Pengajuan::find($id);
        if (!$pengajuan) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        if ($request->status == 'dapat') {
            $pengajuan->status = 'dapat';
            $pengajuan->save();
            return redirect()->back()->with('success', 'Data berhasil diupdate');
        } else if ($request->status == 'tidak') {
            $request->validate([
                'keterangan' => 'required',
                'rekomendasi' => 'required'
            ]);
            $pengajuan->status = 'tidak_dapat';
            $pengajuan->save();
            return redirect()->back()->with('success', 'Data berhasil diupdate');
        } else if ($request->status == 'diterima') {
            $pengajuan->status = 'diterima';
            $pengajuan->save();
            $pengajuan->lokasiAwal->jumlah_personel -= 1;
            $pengajuan->lokasiAwal->save();
            $pengajuan->lokasiTujuan->jumlah_personel += 1;
            $pengajuan->lokasiTujuan->save();
            return redirect()->back()->with('success', 'Data berhasil diupdate');
        }
        return redirect()->back();
    }
}
