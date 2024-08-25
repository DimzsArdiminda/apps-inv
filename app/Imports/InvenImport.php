<?php

namespace App\Imports;

use App\Models\inv;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class InvenImport implements ToModel, WithHeadingRow ,WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new inv([
            'nama' => $row['Nama'],
            'jumlah_satuan' => $row['Jumlah Satuan'],
            'jumlah_pack' => $row['Jumlah Pack'],
        ]);
    }
}
