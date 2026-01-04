<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //
    protected $fillable = [
        'nama_barang',
        'merk',
        'jumlah',
        'kondisi',
        'lokasi',
    ];
}
