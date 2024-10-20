<?php

namespace App\Http\Controllers\Rotasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Pengajuan;
use App\Models\Personel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SelektifAdminController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->id;
        $tab = $request->tab === null ? 'diajukan' : $request->tab;
        // get semua pengajuan
        $pengajuans = Pengajuan::with(["lokasiAwal", "lokasiTujuan"])->where('status', $tab)->get()->map(function ($pengajuan) {
            $pengajuan->tanggal_pengajuan = Carbon::parse($pengajuan->created_at)->format('d-m-Y');
            return $pengajuan;
        });
        $query = "";
        // filter pengajuan
        if ($request->search_nama) {
            $query .= "&search_nama=" . $request->search_nama;
            $pengajuans = $pengajuans->filter(function ($pengajuan) use ($request) {
                return str_contains(strtolower($pengajuan->nama_lengkap), strtolower($request->search_nama));
            });
        }
        if ($request->nik) {
            $query .= "&nik=" . $request->nik;
            $pengajuans = $pengajuans->filter(function ($pengajuan) use ($request) {
                return $pengajuan->nik === $request->nik;
            });
        }
        if ($request->lokasi_awal) {
            $query .= "&lokasi_awal=" . $request->lokasi_awal;
            $pengajuans = $pengajuans->filter(function ($pengajuan) use ($request) {
                return $pengajuan->lokasiAwal->nama === $request->lokasi_awal;
            });
        }
        if ($request->lokasi_tujuan) {
            $query .= "&lokasi_tujuan=" . $request->lokasi_tujuan;
            $pengajuans = $pengajuans->filter(function ($pengajuan) use ($request) {
                return $pengajuan->lokasiTujuan->nama === $request->lokasi_tujuan;
            });
        }
        // get pengajuan yang dipilih
        if ($id !== null) {
            $pengajuan = Pengajuan::find($id);
            if (!$pengajuan || $pengajuan->status !== $tab) {
                return redirect()->route('rotasi.selektif');
            }
            $pengajuan->tanggal_pengajuan = Carbon::parse($pengajuan->created_at)->format('d-m-Y');
        } else {
            $pengajuan = $pengajuans->first();
        }
        return view('rotasi.selektif.index', ['pengajuans' => $pengajuans, 'pengajuan' => $pengajuan, 'query' => $query, 'tab' => $tab, 'cabangs' => Cabang::all(), 'request' => $request]);
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
            DB::beginTransaction();
            $personel = Personel::where('nik', $pengajuan->nik)->first();
            if (!$personel) {
                $personel = new Personel();
                $personel->nik = $pengajuan->nik;
                $personel->name = $pengajuan->nama_lengkap;
                $personel->jabatan = $pengajuan->jabatan;
                $personel->masa_kerja = $pengajuan->masa_kerja;
                $personel->level_jabatan = '';
                $personel->kontak = '';
                $personel->cabang_id = $pengajuan->lokasi_tujuan_id;
                $personel->posisi = $pengajuan->posisi_tujuan;
                $personel->pensiun = 0;
                $personel->save();
            } else {
                if ($personel->name != $pengajuan->nama_lengkap) {
                    return redirect()->back()->with('invalid', 'Nama lengkap tidak sesuai');
                }
                $personel->cabang_id = $pengajuan->lokasi_tujuan_id;
                $personel->posisi = $pengajuan->posisi_tujuan;
                $personel->save();
            }

            if ($pengajuan->primary) {
                $pengajuan->primary->status = 'tidak_dapat';
                $pengajuan->primary->save();
            }
            if ($pengajuan->primary->secondary) {
                $pengajuan->primary->secondary->status = 'tidak_dapat';
                $pengajuan->primary->secondary->save();
            }
            if ($pengajuan->primary->th3) {
                $pengajuan->primary->th3->status = 'tidak_dapat';
                $pengajuan->primary->th3->save();
            }
            $pengajuan->status = 'dapat';
            $pengajuan->save();
            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil diupdate');
        } else if ($request->status == 'tidak') {
            $request->validate([
                'keterangan' => 'required',
                'rekomendasi' => 'required'
            ]);
            DB::beginTransaction();
            $pengajuan->status = 'tidak_dapat';
            $pengajuan->keteranganPenolakan()->create([
                'tipe' => 'keterangan_penolakan',
                'catatan' => $request->keterangan
            ]);
            $pengajuan->rekomendasi()->create([
                'tipe' => 'rekomendasi',
                'catatan' => $request->rekomendasi
            ]);
            $pengajuan->save();
            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil diupdate');
        } else if ($request->status == 'diterima') {
            DB::beginTransaction();
            $pengajuan->status = 'diterima';
            if ($pengajuan->posisi_sekarang == "ACO") {
                $pengajuan->lokasiAwal->jumlah_personel_aco -= 1;
            } else if ($pengajuan->posisi_sekarang == "AIS") {
                $pengajuan->lokasiAwal->jumlah_personel_ais -= 1;
            } else if ($pengajuan->posisi_sekarang == "ATFM") {
                $pengajuan->lokasiAwal->jumlah_personel_atfm -= 1;
            } else if ($pengajuan->posisi_sekarang == "TAPOR") {
                $pengajuan->lokasiAwal->jumlah_personel_tapor -= 1;
            } else if ($pengajuan->posisi_sekarang == "ATSSystem") {
                $pengajuan->lokasiAwal->jumlah_personel_ats_system -= 1;
            } else {
                $pengajuan->lokasiAwal->jumlah_personel -= 1;
            }

            if ($pengajuan->posisi_tujuan == "ACO") {
                $pengajuan->lokasiTujuan->jumlah_personel_aco += 1;
            } else if ($pengajuan->posisi_tujuan == "AIS") {
                $pengajuan->lokasiTujuan->jumlah_personel_ais -= 1;
            } else if ($pengajuan->posisi_tujuan == "ATFM") {
                $pengajuan->lokasiTujuan->jumlah_personel_atfm -= 1;
            } else if ($pengajuan->posisi_tujuan == "TAPOR") {
                $pengajuan->lokasiTujuan->jumlah_personel_tapor -= 1;
            } else if ($pengajuan->posisi_tujuan == "ATSSystem") {
                $pengajuan->lokasiTujuan->jumlah_personel_ats_system -= 1;
            } else {
                $pengajuan->lokasiTujuan->jumlah_personel += 1;
            }
            $pengajuan->lokasiAwal->save();
            $pengajuan->lokasiTujuan->save();
            $pengajuan->save();
            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil diupdate');
        }
        return redirect()->back();
    }
}
