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
        $pengajuans = Pengajuan::where('status', 'selektif')->get()->map(function ($pengajuan) {
            $pengajuan->tanggal_pengajuan = Carbon::parse($pengajuan->created_at)->format('d-m-Y');
            return $pengajuan;
        });
        if ($id !== null) {
            $pengajuan = Pengajuan::find($id);
            if (!$pengajuan || $pengajuan->status !== 'selektif') {
                return redirect()->route('rotasi.selektif');
            }
            $pengajuan->tanggal_pengajuan = Carbon::parse($pengajuan->created_at)->format('d-m-Y');
            return view('rotasi.selektif.index', ['pengajuans' => $pengajuans, 'pengajuan' => $pengajuan]);
        }
        $pengajuan = $pengajuans->first();
        return view('rotasi.selektif.index', ['pengajuans' => $pengajuans, 'pengajuan' => $pengajuan]);
    }

    public function selektif($id, Request $request)
    {
        $request->validate([
            'status' => 'required|in:dapat,tidak'
        ]);
        $pengajuan = Pengajuan::find($id);
        if (!$pengajuan) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        if ($request->status == 'dapat') {
            $pengajuan->status = 'diterima';
            $pengajuan->save();
            return redirect()->back()->with('success', 'Data berhasil diupdate');
        } else if ($request->status == 'tidak') {
            $request->validate([
                'keterangan' => 'required',
                'rekomendasi' => 'required'
            ]);
            $pengajuan->status = 'ditolak';
            $pengajuan->save();
            return redirect()->back()->with('success', 'Data berhasil diupdate');
        }
        return redirect()->back();
    }
}
