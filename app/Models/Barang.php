<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';

    protected $fillable = [
        'nama_barang',
        'deskripsi',
        'harga_sewa',
        'stok',
        'status',
        'kategori',
        'foto',
        'foto_2',
        'foto_3',
        'lokasi',
        'satuan', 
    ];

    protected $casts = [
        'harga_sewa' => 'decimal:2',
    ];
}