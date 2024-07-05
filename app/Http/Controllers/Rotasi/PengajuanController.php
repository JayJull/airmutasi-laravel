<?php

namespace App\Http\Controllers\Rotasi;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Cabang;
use App\Models\Pengajuan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

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

    public function inputView()
    {
        $cabangs = Cabang::all();
        return view('rotasi.personal.input', ['cabangs' => $cabangs]);
    }

    public function input(Request $request)
    {
        $posisi = ['ATC (TWR)', 'ATC (APS)', 'ATC (ACS)', 'ACO', 'AIS', 'ATFM', 'TAPOR', 'ATSSystem', 'STAFF'];
        $request->validate([
            'lokasi_awal_id' => 'required|numeric|exists:cabangs,id',
            'lokasi_tujuan_id' => 'required|numeric|exists:cabangs,id',
            'nama_lengkap' => 'required',
            'nik' => 'required|numeric',
            'masa_kerja' => 'required',
            'jabatan' => 'required',
            'posisi_sekarang' => ['required', Rule::in($posisi)],
            'posisi_tujuan' => ['required', Rule::in($posisi)],
            'kompetensi' => 'required|array',
            'kompetensi.*.nama' => 'required',
            'tujuan_rotasi' => 'required',
        ]);

        $pengajuan = $request->only([
            'lokasi_awal_id',
            'lokasi_tujuan_id',
            'nama_lengkap',
            'nik',
            'masa_kerja',
            'jabatan',
            'posisi_sekarang',
            'posisi_tujuan',
            'tujuan_rotasi',
            'keterangan',
        ]);
        if (!$request->has('abnormal')) {
            $cabangAwal = Cabang::with('kelases')->find($request->lokasi_awal_id);
            $cabangTujuan = Cabang::with('kelases')->find($request->lokasi_tujuan_id);
            $intersect = $cabangAwal->kelases->intersect($cabangTujuan->kelases);
            if ($intersect->isEmpty()) {
                return redirect()->back()->with('invalid', 'Cabang asal dan tujuan tidak memiliki kelas yang sama')->withInput();
            }
        }else{
            $request->validate([
                'keterangan' => 'required',
            ]);
        }
        $pengajuan['sk_mutasi_url'] = $request->sk_mutasi_url;
        $pengajuan['surat_persetujuan_url'] = $request->surat_persetujuan_url;
        DB::beginTransaction();
        $pengajuan['status'] = 'diajukan';
        $pengajuan = Pengajuan::create([
            'lokasi_awal_id' => $pengajuan['lokasi_awal_id'],
            'lokasi_tujuan_id' => $pengajuan['lokasi_tujuan_id'],
            'nama_lengkap' => $pengajuan['nama_lengkap'],
            'nik' => $pengajuan['nik'],
            'masa_kerja' => $pengajuan['masa_kerja'],
            'jabatan' => $pengajuan['jabatan'],
            'posisi_sekarang' => $pengajuan['posisi_sekarang'],
            'posisi_tujuan' => $pengajuan['posisi_tujuan'],
            'tujuan_rotasi' => $pengajuan['tujuan_rotasi'],
            'keterangan' => $pengajuan['keterangan'],
            'sk_mutasi_url' => $pengajuan['sk_mutasi_url'],
            'surat_persetujuan_url' => $pengajuan['surat_persetujuan_url'],
            'status' => $pengajuan['status'],
        ]);
        $kompetensi = array_map(function ($kom) {
            if (!(str_contains($kom["url"], "http://") || str_contains($kom["url"], "https://")) && $kom["url"] !== null) {
                $kom["url"] = "http://" . $kom["url"];
            }
            $kom["file_url"] = $kom["url"];
            return ['nama' => $kom["nama"], 'file_url' => $kom["file_url"]];
        }, $request->kompetensi);
        $pengajuan->kompetensis()->createMany($kompetensi);
        DB::commit();

        return redirect()->route("rotasi.denah")->with('success', 'Data berhasil disimpan');
    }

    public function updateView($id)
    {
        $cabangs = Cabang::all();
        $pengajuan = Pengajuan::with(['lokasiAwal', 'lokasiTujuan'])->find($id);
        if (!$pengajuan) {
            return response()->json(['message' => 'Data not found'], 404);
        }
        $pengajuan->tanggal_pengajuan = Carbon::parse($pengajuan->created_at)->format('d-m-Y');
        $pengajuan->lokasi_awal = $pengajuan->lokasiAwal;
        $pengajuan->lokasi_tujuan = $pengajuan->lokasiTujuan;
        return view('rotasi.personal.update', ['pengajuan' => $pengajuan, 'cabangs' => $cabangs]);
    }

    public function update(Request $request, $id)
    {
        $posisi = ['ATC (TWR)', 'ATC (APS)', 'ATC (ACS)', 'ACO', 'AIS', 'ATFM', 'TAPOR', 'ATSSystem',  'STAFF'];
        $request->validate([
            'lokasi_awal_id' => 'required',
            'lokasi_tujuan_id' => 'required',
            'nama_lengkap' => 'required',
            'nik' => 'required|numeric',
            'masa_kerja' => 'required',
            'jabatan' => 'required',
            'posisi_sekarang' => ['required', Rule::in($posisi)],
            'posisi_tujuan' => ['required', Rule::in($posisi)],
            'kompetensi' => 'required|array',
            'kompetensi.*.nama' => 'required',
            'tujuan_rotasi' => 'required',
            'keterangan' => 'required',
        ]);

        $pengajuanR = $request->only([
            'lokasi_awal_id',
            'lokasi_tujuan_id',
            'nama_lengkap',
            'nik',
            'masa_kerja',
            'jabatan',
            'posisi_sekarang',
            'posisi_tujuan',
            'tujuan_rotasi',
            'keterangan',
        ]);
        DB::beginTransaction();
        $pengajuan = Pengajuan::find($id);
        if ($request->sk_mutasi_url) {
            $pengajuanR['sk_mutasi_url'] = $request->sk_mutasi_url;
        } else {
            $pengajuanR['sk_mutasi_url'] = $pengajuan->sk_mutasi_url;
        }
        if ($request->surat_persetujuan_url) {
            $pengajuanR['surat_persetujuan_url'] = $request->surat_persetujuan_url;
        } else {
            $pengajuanR['surat_persetujuan_url'] = $pengajuan->surat_persetujuan_url;
        }
        $pengajuan->update([
            'lokasi_awal_id' => $pengajuanR['lokasi_awal_id'],
            'lokasi_tujuan_id' => $pengajuanR['lokasi_tujuan_id'],
            'nama_lengkap' => $pengajuanR['nama_lengkap'],
            'nik' => $pengajuanR['nik'],
            'masa_kerja' => $pengajuanR['masa_kerja'],
            'jabatan' => $pengajuanR['jabatan'],
            'posisi_sekarang' => $pengajuanR['posisi_sekarang'],
            'posisi_tujuan' => $pengajuanR['posisi_tujuan'],
            'tujuan_rotasi' => $pengajuanR['tujuan_rotasi'],
            'keterangan' => $pengajuanR['keterangan'],
            'sk_mutasi_url' => $pengajuanR['sk_mutasi_url'],
            'surat_persetujuan_url' => $pengajuanR['surat_persetujuan_url'],
        ]);
        $kompetensi = array_map(function ($kom) {
            if (isset($kom["file_url"])) {
                $kom["file_url"] = $kom["file_url"];
            }
            if (isset($kom["url"]) && $kom["url"] !== null) {
                if (!(str_contains($kom["url"], "http://") || str_contains($kom["url"], "https://"))) {
                    $kom["url"] = "http://" . $kom["url"];
                }
                $kom["file_url"] = $kom["url"];
            } else $kom["file_url"] = null;
            return ['nama' => $kom["nama"], 'file_url' => $kom["file_url"]];
        }, $request->kompetensi, array_keys($request->kompetensi));
        $pengajuan->kompetensis()->delete();
        $pengajuan->kompetensis()->createMany($kompetensi);
        DB::commit();

        return redirect()->route("rotasi.denah")->with('success', 'Data berhasil disimpan');
    }
}
