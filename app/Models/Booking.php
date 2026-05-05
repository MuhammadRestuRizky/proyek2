<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kost;
use App\Models\User;

class Booking extends Model
{
    protected $fillable = [
        'user_id',
        'kost_id',
        'nama',
        'no_telp',
        'tanggal_masuk',
        'durasi',
        'metode',
        'total',
        'status'
    ];

    // relasi ke kost
    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }

    // 🔥 relasi langsung ke pemilik lewat kost
    public function pemilik()
    {
        return $this->hasOneThrough(
            User::class,   // tujuan akhir (pemilik)
            Kost::class,   // perantara
            'id',          // FK di kost
            'id',          // FK di user
            'kost_id',     // FK di booking
            'user_id'      // FK di kost (pemilik)
        );
    }
}