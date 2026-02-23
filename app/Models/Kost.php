<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Kost extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_kost',
        'alamat',
        'deskripsi',
        'harga',
        'tipe',
        'kamar_mandi',
        'foto',
        'status'
    ];

    /**
     * Relasi: 1 kost dimiliki oleh 1 user (pemilik)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
