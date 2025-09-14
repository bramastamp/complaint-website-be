<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kelas;

class KelasSeeder extends Seeder
{
    public function run(): void
    {
        $kelas = [
            [
                'id_gedung' => 5,
                'nama_kelas' => 'E.301',
                'pic' => 'Instruktur 1',
                'layout' => 'Layout U',
                'standar_operasional' => '5S'
            ],
            [
                'id_gedung' => 5,
                'nama_kelas' => 'E.302',
                'pic' => 'Instruktur 2',
                'layout' => 'Layout Banjar',
                'standar_operasional' => '5S'
            ],
            [
                'id_gedung' => 5,
                'nama_kelas' => 'E.303',
                'pic' => 'Instruktur 3',
                'layout' => 'Layout Theater',
                'standar_operasional' => '5S'
            ],
            [
                'id_gedung' => 5,
                'nama_kelas' => 'E.304',
                'pic' => 'Instruktur 4',
                'layout' => 'Layout Kelas Standar',
                'standar_operasional' => '5S'
            ],
        ];

        foreach ($kelas as $k) {
            Kelas::create($k);
        }
    }
}
