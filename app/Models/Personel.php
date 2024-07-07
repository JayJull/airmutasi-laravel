<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personel extends Model
{
    use HasFactory;

    protected $fillable = [
        'nik',
        'name',
        'jabatan',
        'masa_kerja',
        'level_jabatan',
        'kontak',
        'cabang_id',
        'posisi',
    ];

    public function kompetensis()
    {
        return $this->hasMany(PersonelKompetensi::class);
    }
}
