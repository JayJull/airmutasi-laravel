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
        'frms_aco',
        'jumlah_personel_ais',
        'formasi_ais',
        'frms_ais',
        'jumlah_personel_atfm',
        'formasi_atfm',
        'frms_atfm',
        'jumlah_personel_tapor',
        'formasi_tapor',
        'frms_tapor',
        'jumlah_personel_ats_system',
        'formasi_ats_system',
        'frms_ats_system',
    ];

    public function coord()
    {
        return $this->hasOne(CabangCoord::class);
    }

    public function personels()
    {
        return $this->hasMany(Personel::class);
    }

    public function kelases()
    {
        return $this->hasMany(KelasCabang::class);
    }

    public function inAll()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_tujuan_id')->where('status', '=', 'dapat');
    }
    public function outAll()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_awal_id')->where('status', '=', 'dapat');
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

    public function inAIS()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_tujuan_id')->where('status', '=', 'dapat')->where('posisi_tujuan', '=', 'AIS');
    }

    public function outAIS()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_awal_id')->where('status', '=', 'dapat')->where('posisi_sekarang', '=', 'AIS');
    }

    public function inATFM()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_tujuan_id')->where('status', '=', 'dapat')->where('posisi_tujuan', '=', 'ATFM');
    }

    public function outATFM()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_awal_id')->where('status', '=', 'dapat')->where('posisi_sekarang', '=', 'ATFM');
    }

    public function inTAPOR()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_tujuan_id')->where('status', '=', 'dapat')->where('posisi_tujuan', '=', 'TAPOR');
    }

    public function outTAPOR()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_awal_id')->where('status', '=', 'dapat')->where('posisi_sekarang', '=', 'TAPOR');
    }

    public function inATSSystem()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_tujuan_id')->where('status', '=', 'dapat')->where('posisi_tujuan', '=', 'ATSSystem');
    }

    public function outATSSystem()
    {
        return $this->hasMany(Pengajuan::class, 'lokasi_awal_id')->where('status', '=', 'dapat')->where('posisi_sekarang', '=', 'ATSSystem');
    }
}
