<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_log';

    protected $fillable = [
        'action',
        'description',
        'user_id',
        'ip_address', // Assuming you might have this or add it later
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
