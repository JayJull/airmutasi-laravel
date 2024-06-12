<?php

namespace App\Http\Controllers\Rotasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Validation\Rule;

class PengajuanController extends Controller
{
    public function index()
    {
        $cabangs = Cabang::all();
        return view('rotasi.personal.index', ['cabangs' => $cabangs]);
    }

    public function pengajuanById($id)
    {
        $pengajuan = Pengajuan::find($id);
        if (!$pengajuan) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        $pengajuan->tanggal_pengajuan = Carbon::parse($pengajuan->created_at)->format('d-m-Y');
        $pengajuan->lokasi_awal = $pengajuan->lokasiAwal;
        $pengajuan->lokasi_tujuan = $pengajuan->lokasiTujuan;
        return response()->json($pengajuan);
    }

    public function register(Request $request)
    {
        $posisi = ['ATC (TWR)', 'ATC (APS)', 'ATC (ACS)', 'AC0', 'STAFF'];
        $request->validate([
            'lokasi_awal_id' => 'required',
            'lokasi_tujuan_id' => 'required',
            'nama_lengkap' => 'required',
            'nik' => 'required|numeric',
            'masa_kerja' => 'required',
            'jabatan' => 'required',
            'posisi_sekarang' => ['required', Rule::in($posisi)],
            'posisi_tujuan' => ['required', Rule::in($posisi)],
            'kompetensi' => 'required',
            'tujuan_rotasi' => 'required',
        ]);

        $pengajuan = $request->all();
        $pengajuan['status'] = 'diajukan';
        Pengajuan::create($pengajuan);

        return redirect()->route("rotasi.denah")->with('success', 'Data berhasil disimpan');
    }
}
