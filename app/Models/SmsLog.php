<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'phone_number',
        'message',
        'type',
        'category',
        'status',
        'delivery_status',
        'network_status',
        'unique_identifier',
        'response_data',
        'related_type',
        'related_id',
        'sent_at',
        'delivered_at',
        'error_message',
        'delivery_report',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
        'delivered_at' => 'datetime',
    ];

    /**
     * Get the user who sent the SMS
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related model (Carpet or Laundry)
     */
    public function related()
    {
        return $this->morphTo();
    }

    /**
     * Scope for successful SMS
     */
    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    /**
     * Scope for failed SMS
     */
    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    /**
     * Scope for specific type
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }
}
