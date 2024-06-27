<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    use HasFactory;
    protected $fillable = [
        'nama',
        'alamat',
        'thumbnail',
        'jumlah_personel',
        'formasi',
        'frms',
        'jumlah_personel_aco',
        'formasi_aco',
        'frms_aco'
    ];

    public function coord()
    {
        return $this->hasOne(CabangCoord::class);
    }

    public function inAll()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_tujuan_id');
    }
    public function outAll()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_awal_id');
    }

    public function in()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_tujuan_id')->where('status', '=', 'dapat')->where('posisi_tujuan', '<>', 'ACO');
    }
    
    public function out()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_awal_id')->where('status', '=', 'dapat')->where('posisi_sekarang', '<>', 'ACO');
    }

    public function inACO()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_tujuan_id')->where('status', '=', 'dapat')->where('posisi_tujuan', '=', 'ACO');
    }

    public function outACO()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_awal_id')->where('status', '=', 'dapat')->where('posisi_sekarang', '=', 'ACO');
    }
}
