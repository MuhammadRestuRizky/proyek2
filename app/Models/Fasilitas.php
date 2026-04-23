<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fasilitas extends Model
{
    protected $table = 'fasilitas';

    public function kosts()
    {
        return $this->belongsToMany(Kost::class, 'fasilitas_kost');
    }
}