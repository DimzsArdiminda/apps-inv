<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\pemasukan_pengeluaran;

class pemasukan extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        pemasukan_pengeluaran::create([
            'jenis' => 'pemasukan',
            'jumlah' => 1000000,
            'keterangan' => 'Pemasukan Pertama',
            'tanggal' => '2024-09-01',
        ]);
        pemasukan_pengeluaran::create([
            'jenis' => 'pengeluaran',
            'jumlah' => 1000000,
            'keterangan' => 'Pemasukan Pertama',
            'tanggal' => '2024-09-01',
        ]);
        pemasukan_pengeluaran::create([
            'jenis' => 'pemasukan',
            'jumlah' => 2000000,
            'keterangan' => 'Pemasukan Pertama',
            'tanggal' => '2024-10-01',
        ]);
        pemasukan_pengeluaran::create([
            'jenis' => 'pemasukan',
            'jumlah' => 2000000,
            'keterangan' => 'Pemasukan Pertama',
            'tanggal' => '2024-10-01',
        ]);
        pemasukan_pengeluaran::create([
            'jenis' => 'pengeluaran',
            'jumlah' => 1000000,
            'keterangan' => 'Pemasukan Pertama',
            'tanggal' => '2024-10-01',
        ]);
        
    }
}
