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
        DB::beginTransaction();
        $personel = Personel::create($request->only([
            'nik',
            'name',
            'jabatan',
            'masa_kerja',
            'level_jabatan',
            'kontak',
            'cabang_id',
            'posisi',
        ]));
        $personel->kompetensis()->createMany(array_map(function ($kompetensi) {
            return ['kompetensi' => $kompetensi];
        }, $request->kompetensi));
        DB::commit();
        return redirect()->route('personel.index', ['id' => $request->cabang_id])->with('success', 'Personel berhasil ditambahkan');
    }
}
