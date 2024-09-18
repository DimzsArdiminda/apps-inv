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
            'jumlah_satuan' => 50,
            'jumlah_pack' => 2,
            'pengisian_terakhir' => 2,
            'jumlah_pack_asli' => 1,
            'jumlah_satuan_asli' => 25,
        ]);
        inv::create([
            'nama' => 'ID CARD',
            'jumlah_satuan' => 50,
            'jumlah_pack' => 2,
            'pengisian_terakhir' => 2,
            'jumlah_pack_asli' => 1,
            'jumlah_satuan_asli' => 25,
        ]);
        inv::create([
            'nama' => 'HOLDER',
            'jumlah_satuan' => 50,
            'jumlah_pack' => 2,
            'pengisian_terakhir' => 2,
            'jumlah_pack_asli' => 1,
            'jumlah_satuan_asli' => 25,
        ]);
        inv::create([
            'nama' => 'KERTAS',
            'jumlah_satuan' => 50,
            'jumlah_pack' => 2,
            'pengisian_terakhir' => 2,
            'jumlah_pack_asli' => 1,
            'jumlah_satuan_asli' => 25,
        ]);
        inv::create([
            'nama' => 'STOPPER',
            'jumlah_satuan' => 50,
            'jumlah_pack' => 2,
            'pengisian_terakhir' => 2,
            'jumlah_pack_asli' => 1,
            'jumlah_satuan_asli' => 25,
        ]);
        inv::create([
            'nama' => 'KAIL',
            'jumlah_satuan' => 50,
            'jumlah_pack' => 2,
            'pengisian_terakhir' => 2,
            'jumlah_pack_asli' => 1,
            'jumlah_satuan_asli' => 25,
        ]);
        inv::create([
            'nama' => 'Baju',
            'jumlah_satuan' => 50,
            'jumlah_pack' => 2,
            'pengisian_terakhir' => 2,
            'jumlah_pack_asli' => 1,
            'jumlah_satuan_asli' => 25,
        ]);
    }
}
