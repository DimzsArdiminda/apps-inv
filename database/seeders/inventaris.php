<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\inv;

class inventaris extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        inv::create([
            'nama' => 'TALI',
            'jumlah_satuan' => 100,
            'jumlah_pack' => 50,
            'pengisian_terakhir' => 50,
        ]);
        inv::create([
            'nama' => 'KERTAS',
            'jumlah_satuan' => 100,
            'jumlah_pack' => 50,
            'pengisian_terakhir' => 50,
        ]);
        inv::create([
            'nama' => 'STOPPER',
            'jumlah_satuan' => 100,
            'jumlah_pack' => 50,
            'pengisian_terakhir' => 50,
        ]);
        inv::create([
            'nama' => 'KAIL',
            'jumlah_satuan' => 100,
            'jumlah_pack' => 50,
            'pengisian_terakhir' => 50,
        ]);
    }
}
