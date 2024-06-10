<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Role;
use App\Models\User;

class AccountController extends Controller
{
    public function index()
    {
        $akun = auth()->user();
        return view('account.index', ['akun' => $akun]);
    }

    public function addView()
    {
        return view('account.add');
    }

    public function add(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'nik' => 'required',
            'masa_kerja' => 'required',
            'jabatan' => 'required',
            'password' => 'required|min:8'
        ]);
        $akun = new User();
        $akun->name = $request->name;
        $akun->email = $request->email;
        $akun->password = bcrypt($request->password);
        $akun->role_id = Role::where('name', 'personel')->first()->id;
        $akun->save();
        if(!$akun->profile) {
            $akun->profile = new Profile();
            $akun->profile->user_id = $akun->id;
        }
        $akun->profile->nik = $request->nik;
        $akun->profile->masa_kerja = $request->masa_kerja;
        $akun->profile->jabatan = $request->jabatan;
        $akun->profile->save();
        return redirect()->route('akun')->with('success', 'Akun berhasil ditambahkan');
    }

    public function editView()
    {
        $akun = auth()->user();
        return view('account.edit', ['akun' => $akun]);
    }

    public function edit(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'nik' => 'required',
            'masa_kerja' => 'required',
            'jabatan' => 'required',
        ]);
        $akun = User::find(Auth::user()->id);
        $akun->name = $request->name;
        $akun->email = $request->email;
        if(!$akun->profile) {
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
        $akun->save();
        return redirect()->route('akun')->with('success', 'Akun berhasil diubah');
    }
}
