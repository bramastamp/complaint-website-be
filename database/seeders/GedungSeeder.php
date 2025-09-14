<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Gedung;

class GedungSeeder extends Seeder
{
    public function run(): void
    {
        $gedungs = [
            ['nama_gedung' => 'Gedung A'],
            ['nama_gedung' => 'Gedung B'],
            ['nama_gedung' => 'Gedung C'],
            ['nama_gedung' => 'Gedung D'],
            ['nama_gedung' => 'Gedung E'],
            ['nama_gedung' => 'Gedung F'],
            ['nama_gedung' => 'Gedung G'],
        ];

        foreach ($gedungs as $gedung) {
            Gedung::create($gedung);
        }
    }
}
