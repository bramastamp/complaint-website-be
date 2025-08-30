<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_gedung');
    }

    public function getNamaAttribute()
    {
        return $this->nama_kelas;
    }
}
