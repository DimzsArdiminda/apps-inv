<?php

namespace App\Exports;

use App\Models\pemasukan_pengeluaran;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AnggaranExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function collection()
    {
        return pemasukan_pengeluaran::whereRaw('DATE_FORMAT(tanggal, "%Y-%m") = ?', [$this->bulan])
            ->selectRaw('DATE_FORMAT(tanggal, "%Y-%m") as bulan, jenis, SUM(jumlah) as jumlah, keterangan')
            ->groupBy('jenis', 'keterangan')
            ->orderBy('bulan')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Bulan',
            'Jenis',
            'Jumlah',
            'Keterangan'
        ];
    }
}


