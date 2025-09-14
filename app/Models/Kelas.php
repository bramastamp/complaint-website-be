<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas'; // sesuai di DB
    protected $fillable = ['id_gedung', 'nama_kelas', 'pic', 'layout', 'standar_operasional'];

    public function gedung()
    {
        return $this->belongsTo(Gedung::class, 'id_gedung');
    }

    public function pengaduan()
    {
        return $this->hasMany(Pengaduan::class, 'kelas_id');
    }
}
