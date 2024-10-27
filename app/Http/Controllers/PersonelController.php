<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonelController extends Controller
{
    public function index()
    {
        $personels = Personel::all();
        $cabang = Cabang::all();

        if (!$cabang) abort(404);
        return view('personel.index', [
            'personels' => $personels,
            'cabang' => $cabang,
        ]);
    }

    public function cabang(Request $request, $id)
    {
        if ($request->tab === 'ACO') {
            $cabang = Cabang::with(['personels' => function ($query) {
                $query->with(['kompetensis'])->where('posisi', 'ACO');
            }])->find($id);
        } else if ($request->tab === 'AIS') {
            $cabang = Cabang::with(['personels' => function ($query) {
                $query->with(['kompetensis'])->where('posisi', 'AIS');
            }])->find($id);
        } else if ($request->tab === 'ATFM') {
            $cabang = Cabang::with(['personels' => function ($query) {
                $query->with(['kompetensis'])->where('posisi', 'ATFM');
            }])->find($id);
        } else if ($request->tab === 'TAPOR') {
            $cabang = Cabang::with(['personels' => function ($query) {
                $query->with(['kompetensis'])->where('posisi', 'TAPOR');
            }])->find($id);
        } else if ($request->tab === 'ATSSystem') {
            $cabang = Cabang::with(['personels' => function ($query) {
                $query->with(['kompetensis'])->where('posisi', 'ATSSystem');
            }])->find($id);
        } else {
            $cabang = Cabang::with(['personels' => function ($query) {
                $query->with(['kompetensis'])->whereNotIn('posisi', ['ACO', 'AIS', 'ATFM', 'TAPOR', 'ATSSystem']);
            }])->find($id);
        }
        if (!$cabang) abort(404);
        return view('personel.cabang', [
            'cabang' => $cabang,
            'tab' => $request->tab ?? 'ATC',
        ]);
    }

    public function inputView()
    {
        $cabangs = Cabang::all();
        return view('personel.input', [
            'cabangs' => $cabangs,
        ]);
    }

    public function importAllWithCsv(Request $request)
    {
        $request->validate([
            'sheet' => 'required|mimes:csv,txt',
        ]);
        $file = $request->file('sheet');
        $cabangs = Cabang::pluck('id', 'nama')->toArray();
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);
        DB::beginTransaction();
        foreach ($data as $row) {
            $dataPersonel = array_combine($header, $row);
            if (array_key_exists('KANTOR ' . $dataPersonel['lokasi_kedudukan'], $cabangs) && array_key_exists('KANTOR ' . $dataPersonel['lokasi'], $cabangs) && array_key_exists('KANTOR ' . $dataPersonel['lokasi_induk'], $cabangs)) {
                $dataPersonel['cabang_id'] = $cabangs["KANTOR " . $dataPersonel['lokasi_kedudukan']];
                $dataPersonel['lokasi'] = $cabangs['KANTOR ' . $dataPersonel['lokasi']];
                $dataPersonel['lokasi_induk'] = $cabangs['KANTOR ' . $dataPersonel['lokasi_induk']];
            } else {
                continue;
            }
            $dataPersonel['nik'] = $dataPersonel['nik_airnav'];
            $dataPersonel['name'] = $dataPersonel['nama'];
            $dataPersonel['jabatan'] = "";
            $dataPersonel['masa_kerja'] = $dataPersonel['masa_kerja_jabatan_th'];
            $dataPersonel['level_jabatan'] = $dataPersonel['nama_level_jabatan'];
            $dataPersonel['posisi'] = $dataPersonel['jabatan'];
            $dataPersonel['pensiun'] = $dataPersonel['sts_karyawan'] === 'Pensiun';
            $dataPersonel['kontak'] = $dataPersonel['kontak'] ?? "-";

            $dataPersonel["tgl_lahir"] = $dataPersonel["tgl_lahir"] ? date('Y-m-d', strtotime($dataPersonel["tgl_lahir"])) : "2000-01-01";
            $dataPersonel["tmt_kerja_airnav"] = $dataPersonel["tmt_kerja_airnav"] ? date('Y-m-d', strtotime($dataPersonel["tmt_kerja_airnav"])) : "2000-01-01";
            $dataPersonel["tmt_kerja_golongan"] = $dataPersonel["tmt_kerja_golongan"] ? date('Y-m-d', strtotime($dataPersonel["tmt_kerja_golongan"])) : "2000-01-01";
            $dataPersonel["tmt_pensiun"] = $dataPersonel["tmt_pensiun"] ? date('Y-m-d', strtotime($dataPersonel["tmt_pensiun"])) : "2000-01-01";
            $dataPersonel["tmt_jabatan"] = $dataPersonel["tmt_jabatan"] ? date('Y-m-d', strtotime($dataPersonel["tmt_jabatan"])) : "2000-01-01";
            $dataPersonel["tmt_level_jabatan"] = $dataPersonel["tmt_level_jabatan"] ? date('Y-m-d', strtotime($dataPersonel["tmt_level_jabatan"])) : "2000-01-01";

            Personel::updateOrCreate(["nik" => $dataPersonel["nik"]], $dataPersonel);
        }
        DB::commit();
        return redirect()->route('personel')->with('success', 'Personel berhasil diimport');
    }

    public function importCsv(Request $request)
    {
        $request->validate([
            'sheet' => 'required|mimes:csv,txt',
            'cabang_id' => 'required',
            'posisi' => 'required',
        ]);
        $file = $request->file('sheet');
        $path = $file->getRealPath();
        $data = array_map('str_getcsv', file($path));
        $header = array_shift($data);
        $dataPersonels = [];
        foreach ($data as $row) {
            $dataPersonel = array_combine($header, $row);
            $dataPersonel['nik'] = $dataPersonel['nik_airnav'];
            $dataPersonel['cabang_id'] = $request->cabang_id;
            $dataPersonel['posisi'] = $request->posisi;
            $dataPersonels[] = $dataPersonel;
        }
        DB::beginTransaction();
        foreach ($dataPersonels as $dataPersonel) {
            $personel = Personel::create($dataPersonel);
            $personel->kompetensis()->createMany(array_map(function ($kompetensi) {
                return ['kompetensi' => $kompetensi];
            }, explode(',', $dataPersonel['kompetensi'])));
        }
        DB::commit();
        return redirect()->route('personel.index', ['id' => $request->cabang_id])->with('success', 'Personel berhasil diimport');
    }

    public function input(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:personels,nik',
            'name' => 'required',
            'jabatan' => 'required',
            'masa_kerja' => 'required|numeric',
            'level_jabatan' => 'required',
            'kontak' => 'required',
            'cabang_id' => 'required',
            'posisi' => 'required',
            'kompetensi' => 'required|array',
        ]);
        $dataPersonel = $request->only([
            'nik',
            'name',
            'jabatan',
            'masa_kerja',
            'level_jabatan',
            'kontak',
            'cabang_id',
            'posisi',
            'pensiun'
        ]);
        $dataPersonel["pensiun"] = $request->pensiun === 'on';
        DB::beginTransaction();
        $personel = Personel::create($dataPersonel);
        $personel->kompetensis()->createMany(array_map(function ($kompetensi) {
            return ['kompetensi' => $kompetensi];
        }, $request->kompetensi));
        DB::commit();
        return redirect()->route('personel.index', ['id' => $request->cabang_id])->with('success', 'Personel berhasil ditambahkan');
    }

    public function delete($id)
    {
        $personel = Personel::find($id);
        if (!$personel) abort(404);
        $cabang_id = $personel->cabang_id;
        $personel->delete();
        return redirect()->route('personel.index', ['id' => $cabang_id])->with('success', 'Personel berhasil dihapus');
    }

    public function togglePensiun($id)
    {
        $personel = Personel::find($id);
        if (!$personel) abort(404);
        $personel->update([
            'pensiun' => !$personel->pensiun
        ]);
        return redirect()->route('personel.index', ['id' => $personel->cabang_id])->with('success', 'Status pensiun personel berhasil diubah');
    }
}
