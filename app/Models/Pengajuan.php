<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengajuan extends Model
{
    use HasFactory;
    protected $fillable = [
        'lokasi_awal_id',
        'lokasi_tujuan_id',
        'nama_lengkap',
        'nik',
        'masa_kerja',
        'jabatan',
        'posisi_sekarang',
        'posisi_tujuan',
        'kompetensi',
        'tujuan_rotasi',
        'keterangan',
        'sk_mutasi_url',
        'surat_persetujuan_url',
        'status'
    ];

    public function lokasiAwal()
    {
        return $this->belongsTo(Cabang::class, 'lokasi_awal_id');
    }
    public function lokasiTujuan()
    {
        return $this->belongsTo(Cabang::class, 'lokasi_tujuan_id');
    }
    public function kompetensis()
    {
        return $this->hasMany(Kompetensi::class);
    }
}
