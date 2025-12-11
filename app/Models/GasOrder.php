<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GasOrder extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'order_number',
        'user_id',
        'gas_id',
        'item_name',
        'quantity',
        'price',
        'order_date',
        'delivery_method',
        'payment_method',
        'address',
        'full_name',
        'email',
        'notes',
        'status',
        'rejection_reason',
        'proof_of_payment',
        'delivery_time',
        'arrival_time',
        'completion_time',
        'delivery_proof_image',
        'confirmed_at',
        'cancellation_reason_user',
        'cancellation_requested_at',
        'cancellation_status',
        'admin_cancellation_response',
        'receipt_path',
    ];

    protected $casts = [
        'order_date' => 'date',
        'delivery_time' => 'datetime',
        'arrival_time' => 'datetime',
        'completion_time' => 'datetime',
        'cancellation_requested_at' => 'datetime',
        'confirmed_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    /**
     * Ambil pengguna yang membuat pesanan
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ambil produk gas
     */
    public function gas()
    {
        return $this->belongsTo(Gas::class);
    }

    /**
     * Ambil total harga terformat
     */
    public function getFormattedTotalAttribute()
    {
        return 'Rp. ' . number_format($this->price * $this->quantity, 0, ',', '.');
    }

    /**
     * Buat nomor pesanan unik
     */
    public static function generateOrderNumber()
    {
        do {
            $orderNumber = strtoupper(substr(md5(uniqid(rand(), true)), 0, 13));
        } while (self::where('order_number', $orderNumber)->exists());
        
        return $orderNumber;
    }

    /**
     * Periksa jika ada permintaan pembatalan
     */
    public function hasCancellationRequest()
    {
        return $this->cancellation_status === 'pending';
    }

    /**
     * Periksa jika pesanan bisa dibatalkan
     */
    public function canBeCancelled()
    {
        return !in_array($this->status, ['completed', 'cancelled']) && !$this->hasCancellationRequest();
    }
}
