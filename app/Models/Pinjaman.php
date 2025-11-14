<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjaman'; // Pastikan nama tabel sesuai

    protected $fillable = [
        'user_id',
        'nama_peminjam',
        'jenis_usaha',
        'jumlah_pinjaman',
        'bunga',
        'lama_angsuran',
        'angsuran_bulanan',
        'status',
        'tanggal_pengajuan',
        'tanggal_mulai',
        'tanggal_lunas',
        'keterangan',
    ];

    // Relasi jika diperlukan
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}