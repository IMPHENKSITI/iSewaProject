<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gas extends Model
{
    use HasFactory;

    // Tentukan nama tabel secara eksplisit
    protected $table = 'gas';

    protected $fillable = [
        'user_id',
        'jenis_gas',
        'harga_satuan',
        'jumlah_tabung',
        'harga_total',
        'stok',
        'status',
        'foto',
    ];
}