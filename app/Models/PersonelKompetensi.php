<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonelKompetensi extends Model
{
    use HasFactory;

    protected $fillable = [
        'personel_id',
        'kompetensi',
    ];
}
