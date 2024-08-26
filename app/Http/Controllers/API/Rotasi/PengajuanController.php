<?php

namespace App\Http\Controllers\API\Rotasi;

use App\Http\Controllers\Controller;
use App\Models\Pengajuan;
use Carbon\Carbon;

class PengajuanController extends Controller
{
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
}
