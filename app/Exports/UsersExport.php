<?php

namespace App\Exports;

use App\Models\inv;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class UsersExport implements FromCollection, withHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return inv::select('nama', 'jumlah_satuan', 'jumlah_pack')->get();
    }

    public function headings(): array
    {
        return [
            'nama',
            'jumlah_satuan',
            'jumlah_pack',
        ];
    }
}
