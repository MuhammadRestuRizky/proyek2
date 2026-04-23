<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Foto extends Model
{
    protected $table = 'kost_fotos'; // 🔥 FIX DI SINI

    protected $fillable = ['kost_id', 'foto', 'is_primary'];

    public function kost()
    {
        return $this->belongsTo(Kost::class);
    }
}