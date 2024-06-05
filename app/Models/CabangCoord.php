<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CabangCoord extends Model
{
    use HasFactory;
    protected $fillable = [
        'cabang_id',
        'latitude',
        'longitude',
    ];
}
