<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas'
    ];

    public function cabang()
    {
        return $this->hasManyThrough(Cabang::class, KelasCabang::class, 'kelas_id', 'id', 'id', 'cabang_id');
    }
}
