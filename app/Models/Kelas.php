<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'gedung_id');
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'kelas_id');
    }
}
