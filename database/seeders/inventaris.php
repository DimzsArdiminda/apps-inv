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
            'nama' => 'ID CARD',
            'jumlah_satuan' => 100,
            'jumlah_pack' => 50,
            'pengisian_terakhir' => 50,
        ]);
        inv::create([
            'nama' => 'tali lanyard',
            'jumlah_satuan' => 100,
            'jumlah_pack' => 50,
            'pengisian_terakhir' => 50,
        ]);
        inv::create([
            'nama' => 'stopper',
            'jumlah_satuan' => 100,
            'jumlah_pack' => 50,
            'pengisian_terakhir' => 50,
        ]);
    }
}
