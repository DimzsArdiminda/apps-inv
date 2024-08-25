<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Invoice;
class dataInvoice extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Invoice::create([
            'nama' => 'Rizky',
            'no_hp' => '08123456789',
            'email' => 'Rizky@mail.com',
            'alamat' => 'Jl. Raya',
            'invoice_number' => 'INV-001',
            'nama_barang' => 'Laptop',
            'jumlah_barang' => 1,
            'harga_barang' => 10000000,
            'total_harga' => 10000000,
            'status' => 'dp',
        ]);
        Invoice::create([
            'nama' => 'Rizky',
            'no_hp' => '08123456789',
            'email' => 'Rizky@mail.com',
            'alamat' => 'Jl. Raya',
            'invoice_number' => 'INV-001',
            'nama_barang' => 'BUKU',
            'jumlah_barang' => 1,
            'harga_barang' => 10000000,
            'total_harga' => 10000000,
            'status' => 'dp',
        ]);
        Invoice::create([
            'nama' => 'Rizky',
            'no_hp' => '08123456789',
            'email' => 'Rizky@mail.com',
            'alamat' => 'Jl. Raya',
            'invoice_number' => 'INV-001',
            'nama_barang' => 'BUKU',
            'jumlah_barang' => 1,
            'harga_barang' => 10000000,
            'total_harga' => 10000000,
            'status' => 'dp',
        ]);
    }
}
