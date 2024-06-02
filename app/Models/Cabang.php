<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;

    public function coord()
    {
        return $this->hasOne(CabangCoord::class);
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
