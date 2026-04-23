<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Fasilitas;

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
        'status',
        'maps'
    ];

    // 🔥 RELASI FOTO
    public function fotos()
    {
        return $this->hasMany(KostFoto::class);
    }

    // 🔥 RELASI FASILITAS (INI YANG HILANG TADI)
    public function fasilitas()
    {
        return $this->belongsToMany(Fasilitas::class, 'fasilitas_kost');
    }
}