<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanDetail extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi mass assignment
     */
    protected $fillable = [
        'peminjaman_id',
        'inventory_id',
        'jumlah',
    ];

    /**
     * Relasi ke peminjaman
     * Banyak detail → 1 peminjaman
     */
    public function peminjaman()
    {
        return $this->belongsTo(Peminjaman::class);
    }

    /**
     * Relasi ke inventory
     * Banyak detail → 1 barang
     */
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
