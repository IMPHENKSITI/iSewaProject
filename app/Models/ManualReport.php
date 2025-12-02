<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'name',
        'description',
        'amount',
        'quantity',
        'payment_method',
        'transaction_date',
        'created_by'
    ];

    protected $casts = [
        'transaction_date' => 'date',
        'amount' => 'decimal:2',
        'quantity' => 'integer'
    ];

    /**
     * Relationship: Manual report belongs to a user (creator)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope: Filter by category
     */
    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Scope: Filter by date range
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('transaction_date', [$startDate, $endDate]);
    }

    /**
     * Scope: Filter by current year
     */
    public function scopeCurrentYear($query)
    {
        return $query->whereYear('transaction_date', date('Y'));
    }

    /**
     * Accessor: Get formatted amount
     */
    public function getFormattedAmountAttribute()
    {
        return 'Rp ' . number_format($this->amount, 0, ',', '.');
    }

    /**
     * Accessor: Get total (amount * quantity)
     */
    public function getTotalAttribute()
    {
        return $this->amount * $this->quantity;
    }

    /**
     * Accessor: Get formatted total
     */
    public function getFormattedTotalAttribute()
    {
        return 'Rp ' . number_format($this->total, 0, ',', '.');
    }

    /**
     * Accessor: Get category badge color
     */
    public function getCategoryBadgeAttribute()
    {
        $badges = [
            'penyewaan' => 'warning',
            'gas' => 'danger',
            'lainnya' => 'info'
        ];

        return $badges[$this->category] ?? 'secondary';
    }

    /**
     * Accessor: Get category label
     */
    public function getCategoryLabelAttribute()
    {
        $labels = [
            'penyewaan' => 'Penyewaan Alat',
            'gas' => 'Penjualan Gas',
            'lainnya' => 'Lainnya'
        ];

        return $labels[$this->category] ?? $this->category;
    }
}
