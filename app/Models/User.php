<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // Tetap gunakan ini untuk login
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password', // Harus bisa diisi saat register
        'phone',
        'address',
        'gender',
        'status', // Tambahkan status ke fillable
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'string', // Pastikan status di-cast ke string
        ];
    }

    // Relasi ke transaksi penyewaan (contoh)
    public function rentalTransactions()
    {
        return $this->hasMany(RentalTransaction::class, 'user_id');
    }

    // Relasi ke transaksi gas (contoh)
    public function gasTransactions()
    {
        return $this->hasMany(GasTransaction::class, 'user_id');
    }
}