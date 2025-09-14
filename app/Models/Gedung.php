<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gedung extends Model
{
    use HasFactory;

    protected $table = 'gedungs'; // pastikan sesuai nama tabel di DB
    protected $fillable = ['nama_gedung'];

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'id_gedung');
    }
}
