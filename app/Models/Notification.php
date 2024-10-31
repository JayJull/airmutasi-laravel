<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        "is_read",
        "status",
        "to",
        "cabang_asal_id",
        "cabang_tujuan_id",
        "pengajuan_id",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pengajuan()
    {
        return $this->belongsTo(Pengajuan::class);
    }

    public function notread()
    {
        return $this->where("is_read", false)->get();
    }
}
