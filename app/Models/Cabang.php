<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    public function induk()
    {
        return $this->belongsTo(Cabang::class, 'cabang_induk_id');
    }

    public function anak()
    {
        return $this->hasMany(Cabang::class, 'cabang_induk_id');
    }

    public function in()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_tujuan_id');
    }
    
    public function out()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_awal_id');
    }
}
