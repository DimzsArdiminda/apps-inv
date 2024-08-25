<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class inv extends Model
{
    use HasFactory;
    protected $table = 'inventaris';
    // protected $fillable = ['nama_barang', 'sisa_barang', 'jumlah_pack'];
    protected $guarded = [];
}
