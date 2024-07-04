<?php

namespace Database\Seeders;

use App\Models\Kelas;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KelasSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kelas::create([
            'nama_kelas' => 'Kelas A',
        ]);
        Kelas::create([
            'nama_kelas' => 'Kelas B',
        ]);
        Kelas::create([
            'nama_kelas' => 'Kelas C1',
        ]);
        Kelas::create([
            'nama_kelas' => 'Kelas 1',
        ]);
        Kelas::create([
            'nama_kelas' => 'Kelas 2',
        ]);
        Kelas::create([
            'nama_kelas' => 'Kelas 3',
        ]);
        Kelas::create([
            'nama_kelas' => 'Kelas 4',
        ]);
        Kelas::create([
            'nama_kelas' => 'Kelas 5',
        ]);
        Kelas::create([
            'nama_kelas' => 'Kelas 6',
        ]);
        Kelas::create([
            'nama_kelas' => 'Kelas 7',
        ]);
        Kelas::create([
            'nama_kelas' => 'Kelas 8',
        ]);
    }
}
