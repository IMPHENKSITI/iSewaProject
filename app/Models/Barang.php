<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang'; // Sesuaikan dengan nama tabel di database Anda

    protected $fillable = [
        'nama_barang',
        'deskripsi',
        'harga_sewa',
        'stok',
        'status',
        'kategori',
        'foto', // Asumsikan kolom ini menyimpan path gambar utama
        'foto_2', // Kolom untuk gambar kedua
        'foto_3', // Kolom untuk gambar ketiga
        'lokasi',
    ];

    // Relasi jika diperlukan
    public function transaksiSewa()
    {
        return $this->hasMany(TransaksiSewa::class, 'barang_id');
    }
}