<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledSms extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'type',
        'recipients',
        'message',
        'category',
        'scheduled_for',
        'status',
        'total_recipients',
        'sent_count',
        'failed_count',
        'started_at',
        'completed_at',
        'notes',
    ];

    protected $casts = [
        'recipients' => 'array',
        'scheduled_for' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user who created the scheduled SMS
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope for pending SMS
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for due SMS (should be sent now)
     */
    public function scopeDue($query)
    {
        return $query->where('status', 'pending')
                     ->where('scheduled_for', '<=', now());
    }

    /**
     * Check if SMS is ready to send
     */
    public function isReadyToSend()
    {
        return $this->status === 'pending' && $this->scheduled_for <= now();
    }

    /**
     * Mark as processing
     */
    public function markAsProcessing()
    {
        $this->update([
            'status' => 'processing',
            'started_at' => now(),
        ]);
    }

    /**
     * Mark as completed
     */
    public function markAsCompleted()
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
