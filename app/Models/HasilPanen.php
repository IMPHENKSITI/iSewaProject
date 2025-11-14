<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilPanen extends Model
{
    use HasFactory;

    protected $table = 'hasil_panen'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'user_id',
        'jenis_hasil_panen',
        'jumlah',
        'satuan',
        'harga_jual',
        'tanggal_panen',
        'lokasi_lahan',
        'status',
        'foto',
    ];

    // Relasi jika diperlukan
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}