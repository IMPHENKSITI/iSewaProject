<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'gas_id',
        'resident_id',
        'quantity',
        'total_price',
        'status',
    ];

    public function gas()
    {
        return $this->belongsTo(Gas::class);
    }

    public function resident()
    {
        return $this->belongsTo(User::class, 'resident_id');
    }
}