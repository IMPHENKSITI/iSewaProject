<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gas extends Model
{
    use HasFactory;

    protected $table = 'gas';

    protected $fillable = [
        'jenis_gas',
        'deskripsi',
        'harga_satuan',
        'stok',
        'status',
        'kategori', // Tambahkan jika ingin seperti penyewaan
        'foto',
        'foto_2',
        'foto_3',
        'lokasi',
        'satuan', // Tambahkan jika ingin seperti penyewaan
    ];

    protected $casts = [
        'harga_satuan' => 'integer',
    ];
}