<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index()
    {
        $akun = auth()->user();
        return view('account.index', ['akun' => $akun]);
    }

    public function inputView()
    {
        return view('account.input');
    }

    public function input(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'nik' => 'required',
            'masa_kerja' => 'required',
            'jabatan' => 'required',
            'password' => 'required|min:8'
        ]);
        DB::beginTransaction();
        $akun = new User();
        $akun->name = $request->name;
        $akun->email = $request->email;
        $akun->password = bcrypt($request->password);
        $akun->role_id = Role::where('name', 'personel')->first()->id;
        $akun->save();
        if (!$akun->profile) {
            $akun->profile = new Profile();
            $akun->profile->user_id = $akun->id;
        }
        $akun->profile->nik = $request->nik;
        $akun->profile->masa_kerja = $request->masa_kerja;
        $akun->profile->jabatan = $request->jabatan;
        $akun->profile->save();
        DB::commit();
        return redirect()->route('akun')->with('success', 'Akun berhasil ditambahkan');
    }

    public function updateView()
    {
        $akun = auth()->user();
        return view('account.update', ['akun' => $akun]);
    }

    public function update(Request $request)
    {
        DB::beginTransaction();
        $akun = User::find(Auth::user()->id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $akun->id,
            'nik' => 'required',
            'masa_kerja' => 'required',
            'jabatan' => 'required',
        ]);
        $akun->name = $request->name;
        $akun->email = $request->email;
        $akun->save();
        if (!$akun->profile) {
            $akun->profile = new Profile();
            $akun->profile->user_id = $akun->id;
        }
        $akun->profile->user_id = $akun->id;
        $akun->profile->nik = $request->nik;
        $akun->profile->masa_kerja = $request->masa_kerja;
        $akun->profile->jabatan = $request->jabatan;
        if ($request->password) {
            $request->validate([
                'password' => 'required|min:8'
            ]);
            $akun->password = bcrypt($request->password);
        }
        $akun->profile->save();
        DB::commit();
        return redirect()->route('akun')->with('success', 'Akun berhasil diubah');
    }
}
