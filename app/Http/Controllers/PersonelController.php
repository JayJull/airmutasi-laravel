<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PersonelController extends Controller
{
    public function index()
    {
        $page = request()->get('page', 0);
        $limit = 100;
        $nik = request()->get('nik');
        $name = request()->get('nama');
        $cabang_id = request()->get('cabang_id');
        $cabang = request()->get('cabang');
        if ($nik == "" && $name == "" && $cabang == "") {
            $personels = Personel::limit($limit)->offset($page * $limit)->get();
            $cabangs = Cabang::all();
            if (!$cabangs) abort(404);
            return view('personel.index', [
                'personels' => $personels,
                'cabangs' => $cabangs,
                'page' => $page ?? 0,
                'search' => [
                    'nik' => $nik,
                    'name' => $name,
                    'cabang_id' => $cabang_id,
                    'cabang' => $cabang,
                ],
            ]);
        }
        $personels = Personel::where('nik', 'like', $nik . '%')->where('name', 'like', '%' . $name . '%');
        if ($cabang != "") {
            $personels = $personels->where('cabang_id', $cabang_id);
        }
        $personels = $personels->limit($limit)->offset($page * $limit)->get();
        $search = [
            'nik' => $nik,
            'name' => $name,
            'cabang_id' => $cabang_id,
            'cabang' => $cabang,
        ];

        if ($personels->count() === 0 && $page > 0) {
            return redirect()->back();
        }

        $cabangs = Cabang::all();
        if (!$cabangs) abort(404);
        return view('personel.index', [
            'personels' => $personels,
            'cabangs' => $cabangs,
            'page' => $page ?? 0,
            'search' => $search,
        ]);
    }

    public function search_by_nik(Request $request)
    {
        $nik = $request->nik;
        $personels = Personel::where('nik', 'like', $nik . '%')->get();
        return response()->json($personels);
    }

    public function cabang(Request $request, $id)
    {
        $page = request()->get('page', 0);
        $limit = 100;
        if ($request->tab === 'ACO') {
            $cabang = Cabang::with(['personels' => function ($query) use ($limit, $page) {
                $query->with(['kompetensis'])->where('posisi', 'ACO')->orWhere('posisi', 'AERONAUTICAL COMMUNICATION OFFICER')->limit($limit)->offset($page * $limit);
            }])->find($id);
        } else if ($request->tab === 'AIS') {
            $cabang = Cabang::with(['personels' => function ($query) use ($limit, $page) {
                $query->with(['kompetensis'])->where('posisi', 'AIS')->orWhere('posisi', 'AERONAUTICAL INFORMATION SERVICE')->orWhere('posisi', 'LIKE', 'AIS%')->limit($limit)->offset($page * $limit);
            }])->find($id);
        } else if ($request->tab === 'ATFM') {
            $cabang = Cabang::with(['personels' => function ($query) use ($limit, $page) {
                $query->with(['kompetensis'])->where('posisi', 'ATFM')->orWhere('posisi', 'AIR TRAFFIC FLOW MANAGEMENT')->orWhere('posisi', 'STAF ATFM')->limit($limit)->offset($page * $limit);
            }])->find($id);
        } else if ($request->tab === 'TAPOR') {
            $cabang = Cabang::with(['personels' => function ($query) use ($limit, $page) {
                $query->with(['kompetensis'])->where('posisi', 'TAPOR')->orWhere('posisi', 'STAF PELAPORAN DATA')->limit($limit)->offset($page * $limit);
            }])->find($id);
        } else if ($request->tab === 'ATSSystem') {
            $cabang = Cabang::with(['personels' => function ($query) use ($limit, $page) {
                $query->with(['kompetensis'])->where('posisi', 'ATSSystem')->orWhere('posisi', 'AIR TRAFFIC SERVICES SYSTEM')->orWhere('posisi', 'SPESIALIS ATS SYSTEM')->limit($limit)->offset($page * $limit);
            }])->find($id);
        } else if ($request->tab === 'ATC') {
            $cabang = Cabang::with(['personels' => function ($query) use ($limit, $page) {
                $query->with(['kompetensis'])->where('posisi', 'LIKE', 'ATC%')->orWhere('posisi', 'AIR TRAFFIC CONTROLLER')->limit($limit)->offset($page * $limit);
            }])->find($id);
        } else {
            $cabang = Cabang::with(['personels' => function ($query) use ($limit, $page) {
                $query->with(['kompetensis'])->whereNotIn('posisi', ['ATC (APS)', 'ACO', 'AIS', 'ATFM', 'TAPOR', 'ATSSystem', 'AERONAUTICAL COMMUNICATION OFFICER', 'AERONAUTICAL INFORMATION SERVICE', 'AIR TRAFFIC FLOW MANAGEMENT', 'TOWER APPROACH', 'AIR TRAFFIC SERVICES SYSTEM', 'AIR TRAFFIC CONTROLLER'])->whereNot('posisi', 'LIKE', 'ATC%')->whereNot('posisi', 'LIKE', 'AIS%')->limit($limit)->offset($page * $limit);
            }])->find($id);
        }
        if (!$cabang) abort(404);
        if ($cabang->nama === 'PUSAT INFORMASI AERONAUTIKA') {
            if ($request->tab != "AIS") $cabang->personels = [];
            else {
                $cabang = Cabang::with(['personels' => function ($query) use ($limit, $page) {
                    $query->limit($limit)->offset($page * $limit);
                }])->find($id);
            }
        }
        return view('personel.cabang', [
            'cabang' => $cabang,
            'tab' => $request->tab ?? 'ATC',
            'page' => $page ?? 0,
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

        $map_cabang = [
            "PELAYANAN INFORMASI AERONAUTIKA WILAYAH JAKARTA" => "KANTOR CABANG JATSC",
            "PELAYANAN INFORMASI AERONAUTIKA WILAYAH MAKASSAR" => "KANTOR CABANG MATSC",
            "PELAYANAN INFORMASI AERONAUTIKA WILAYAH DENPASAR" => "KANTOR CABANG DENPASAR",
            "PELAYANAN INFORMASI AERONAUTIKA WILAYAH SURABAYA" => "KANTOR CABANG SURABAYA",
            "PELAYANAN INFORMASI AERONAUTIKA WILAYAH MEDAN" => "KANTOR CABANG MEDAN",
            "PELAYANAN INFORMASI AERONAUTIKA WILAYAH BALIKPAPAN" => "KANTOR CABANG BALIKPAPAN",
            "PELAYANAN INFORMASI AERONAUTIKA WILAYAH PALEMBANG" => "KANTOR CABANG PALEMBANG",
            "PELAYANAN INFORMASI AERONAUTIKA WILAYAH MANADO" => "KANTOR CABANG MANADO",
            "PELAYANAN INFORMASI AERONAUTIKA WILAYAH SORONG" => "KANTOR CABANG SORONG",
            "PELAYANAN INFORMASI AERONAUTIKA WILAYAH SENTANI" => "KANTOR CABANG SENTANI",
        ];
        DB::beginTransaction();
        try {
            foreach ($data as $row) {
                $dataPersonel = array_combine($header, $row);
                if (array_key_exists($dataPersonel['lokasi_kedudukan'], $map_cabang)) {
                    $dataPersonel['lokasi_kedudukan'] = $map_cabang[$dataPersonel['lokasi_kedudukan']];
                }
                if (array_key_exists($dataPersonel['lokasi'], $map_cabang)) {
                    $dataPersonel['lokasi'] = $map_cabang[$dataPersonel['lokasi']];
                }
                if (array_key_exists($dataPersonel['lokasi_induk'], $map_cabang)) {
                    $dataPersonel['lokasi_induk'] = $map_cabang[$dataPersonel['lokasi_induk']];
                }
                if (array_key_exists('KANTOR ' . $dataPersonel['lokasi_kedudukan'], $cabangs) && array_key_exists('KANTOR ' . $dataPersonel['lokasi'], $cabangs) && array_key_exists('KANTOR ' . $dataPersonel['lokasi_induk'], $cabangs)) {
                    $dataPersonel['cabang_id'] = $cabangs["KANTOR " . $dataPersonel['lokasi_kedudukan']];
                    $dataPersonel['lokasi'] = $cabangs['KANTOR ' . $dataPersonel['lokasi']];
                    $dataPersonel['lokasi_induk'] = $cabangs['KANTOR ' . $dataPersonel['lokasi_induk']];
                } else if (array_key_exists($dataPersonel['lokasi_kedudukan'], $cabangs) && array_key_exists($dataPersonel['lokasi'], $cabangs) && array_key_exists($dataPersonel['lokasi_induk'], $cabangs)) {
                    $dataPersonel['cabang_id'] = $cabangs[$dataPersonel['lokasi_kedudukan']];
                    $dataPersonel['lokasi'] = $cabangs[$dataPersonel['lokasi']];
                    $dataPersonel['lokasi_induk'] = $cabangs[$dataPersonel['lokasi_induk']];
                } else {
                    continue;
                }
                $dataPersonel['posisi'] = $dataPersonel['jabatan'];
                $dataPersonel['jabatan'] = $dataPersonel['nama_level_jabatan'];
                $dataPersonel['nik'] = $dataPersonel['nik_airnav'];
                $dataPersonel['name'] = $dataPersonel['nama'];
                $dataPersonel['masa_kerja'] = $dataPersonel['masa_kerja_jabatan_th'];
                $dataPersonel['level_jabatan'] = $dataPersonel['nama_level_jabatan'];
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
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('personel')->with('error', 'Personel gagal diimport');
        }
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
