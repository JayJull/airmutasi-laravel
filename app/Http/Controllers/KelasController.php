<?php

namespace App\Http\Controllers;

use App\Models\Cabang;
use App\Models\Kelas;
use App\Models\KelasCabang;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        $kelases = Kelas::with(["cabang"])->get();
        $cabangs = Cabang::all();
        return view('kelas.index', ['kelases' => $kelases, 'cabangs' => $cabangs]);
    }

    public function input(Request $request)
    {
        $request->validate([
            'kelas' => 'required',
            'cabang' => 'required'
        ]);

        $kelas = Kelas::find($request->kelas);
        if (!$kelas) {
            return redirect()->route('kelas');
        }

        if (is_array($request->cabang)) {
            $cabangs = Cabang::whereIn('id', $request->cabang)->get();
            foreach ($cabangs as $cabang) {
                $kelasCabang = new KelasCabang();
                $kelasCabang->kelas_id = $kelas->id;
                $kelasCabang->cabang_id = $cabang->id;
                $kelasCabang->save();
            }
            return redirect()->route('kelas');
        }

        $cabang = Cabang::find($request->cabang);
        if (!$cabang) {
            return redirect()->route('kelas');
        }

        $kelasCabang = new KelasCabang();
        $kelasCabang->kelas_id = $kelas->id;
        $kelasCabang->cabang_id = $cabang->id;
        $kelasCabang->save();

        return redirect()->route('kelas');
    }

    public function destroy($cabang_id, $kelas_id)
    {
        $kelas = KelasCabang::where('cabang_id', $cabang_id)->where('kelas_id', $kelas_id)->first();
        if (!$kelas) {
            return redirect()->route('kelas');
        }
        $kelas->delete();

        return redirect()->route('kelas');
    }
}
