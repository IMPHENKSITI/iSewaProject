<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RentalBooking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'barang_id',
        'delivery_method',
        'quantity',
        'start_date',
        'end_date',
        'days_count',
        'recipient_name',
        'delivery_address',
        'latitude',
        'longitude',
        'payment_method',
        'payment_proof',
        'total_amount',
        'status',
        'admin_notes',
        'confirmed_at',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'confirmed_at' => 'datetime',
        'total_amount' => 'decimal:2',
        'latitude' => 'decimal:7',
        'longitude' => 'decimal:7',
    ];

    /**
     * Get the user that made the booking
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the rental item (barang)
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    /**
     * Get formatted total amount
     */
    public function getFormattedTotalAttribute()
    {
        return 'Rp. ' . number_format($this->total_amount, 0, ',', '.');
    }

    /**
     * Get formatted start date
     */
    public function getFormattedStartDateAttribute()
    {
        return $this->start_date->format('d/m/Y');
    }

    /**
     * Get formatted end date
     */
    public function getFormattedEndDateAttribute()
    {
        return $this->end_date->format('d/m/Y');
    }

    /**
     * Check if booking is for delivery (antar)
     */
    public function isDelivery()
    {
        return $this->delivery_method === 'antar';
    }

    /**
     * Check if booking is for pickup (jemput)
     */
    public function isPickup()
    {
        return $this->delivery_method === 'jemput';
    }

    /**
     * Check if payment is via transfer
     */
    public function isTransfer()
    {
        return $this->payment_method === 'transfer';
    }

    /**
     * Check if payment is cash (tunai)
     */
    public function isCash()
    {
        return $this->payment_method === 'tunai';
    }
}
