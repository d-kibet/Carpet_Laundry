<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmsPreference extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone_number',
        'receive_promotional',
        'receive_reminders',
        'receive_notifications',
        'opted_out',
        'opted_out_at',
        'notes',
    ];

    protected $casts = [
        'receive_promotional' => 'boolean',
        'receive_reminders' => 'boolean',
        'receive_notifications' => 'boolean',
        'opted_out' => 'boolean',
        'opted_out_at' => 'datetime',
    ];

    /**
     * Check if customer has opted out
     */
    public function hasOptedOut()
    {
        return $this->opted_out;
    }

    /**
     * Check if customer can receive specific type of SMS
     */
    public function canReceive($type)
    {
        if ($this->opted_out) {
            return false;
        }

        switch ($type) {
            case 'promotional':
                return $this->receive_promotional;
            case 'reminder':
                return $this->receive_reminders;
            case 'notification':
                return $this->receive_notifications;
            default:
                return true;
        }
    }
}
