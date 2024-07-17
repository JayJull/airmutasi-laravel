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
        'secondary_pengajuan_id',
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
    public function keteranganPenolakan()
    {
        return $this->hasOne(Catatan::class)->where('tipe', 'keterangan_penolakan');
    }
    public function rekomendasi()
    {
        return $this->hasOne(Catatan::class)->where('tipe', 'rekomendasi');
    }
    public function secondary()
    {
        return $this->belongsTo(Pengajuan::class, "secondary_pengajuan_id");
    }
    public function primary()
    {
        return $this->hasOne(Pengajuan::class, "secondary_pengajuan_id");
    }
}
