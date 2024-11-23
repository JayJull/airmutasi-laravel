<?php

namespace App\Http\Controllers;

use App\Models\PersonelJabatanCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JabatanController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'jabatan' => 'required'
        ]);
        DB::beginTransaction();
        if (is_array($request->jabatan)) {
            foreach ($request->jabatan as $jabatan) {
                $personelJabatanCategory = new PersonelJabatanCategory();
                $personelJabatanCategory->category = $request->category;
                $personelJabatanCategory->jabatan = $jabatan;
                $personelJabatanCategory->save();
            }
        } else {
            $personelJabatanCategory = new PersonelJabatanCategory();
            $personelJabatanCategory->category = $request->category;
            $personelJabatanCategory->jabatan = $request->jabatan;
            $personelJabatanCategory->save();
        }
        DB::commit();
        return redirect()->back()->with('success', 'Data berhasil disimpan');
    }

    public function destroy($id)
    {
        $personelJabatanCategory = PersonelJabatanCategory::find($id);
        if(!$personelJabatanCategory) {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
        $personelJabatanCategory->delete();
        return redirect()->back()->with('success', 'Data berhasil dihapus');
    }
}
