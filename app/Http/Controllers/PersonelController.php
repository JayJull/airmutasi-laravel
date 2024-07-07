<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonelController extends Controller
{
    public function index(Request $request, $id)
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
        return view('personel.index', [
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

    public function delete($id) {
        $personel = Personel::find($id);
        if (!$personel) abort(404);
        $cabang_id = $personel->cabang_id;
        $personel->delete();
        return redirect()->route('personel.index', ['id' => $cabang_id])->with('success', 'Personel berhasil dihapus');
    }

    public function togglePensiun($id) {
        $personel = Personel::find($id);
        if (!$personel) abort(404);
        $personel->update([
            'pensiun' => !$personel->pensiun
        ]);
        return redirect()->route('personel.index', ['id' => $personel->cabang_id])->with('success', 'Status pensiun personel berhasil diubah');
    }
}
