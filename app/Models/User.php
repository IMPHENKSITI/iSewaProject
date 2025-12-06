<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
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
        'password',
        'phone',
        'address',
        'gender',
        'avatar',                  // Avatar profile photo
        'position',                // Jabatan/Position
        'status',
        'role',                    // ✅ TAMBAH INI
        'email_verified_at',       // ✅ TAMBAH INI (PENTING!)
        'otp_code',                // ✅ TAMBAH INI
        'otp_expires_at',          // ✅ TAMBAH INI
        'reset_token',            // ✅ TAMBAH INI
        'reset_token_expires_at',  // ✅ TAMBAH INI
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp_code',               // ✅ TAMBAH INI (jangan expose OTP)
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
            'otp_expires_at' => 'datetime',    // ✅ TAMBAH INI
            'reset_token_expires_at' => 'datetime', // ✅ TAMBAH INI
            'password' => 'hashed',
            'status' => 'string',
        ];
    }

    /**
     * Polymorphic relation to files (untuk avatar)
     */
    public function file()
    {
        return $this->morphOne(File::class, 'fileable');
    }
    
    // Relasi ke transaksi penyewaan
    public function rentalTransactions()
    {
        return $this->hasMany(RentalTransaction::class, 'user_id');
    }

    // Relasi ke transaksi gas
    public function gasTransactions()
    {
        return $this->hasMany(GasTransaction::class, 'user_id');
    }
}
