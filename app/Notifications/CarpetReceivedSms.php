<?php

namespace App\Notifications;

use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class CarpetReceivedSms extends Notification implements ShouldQueue
{
    use Queueable;

    protected $carpet;

    public function __construct($carpet)
    {
        $this->carpet = $carpet;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }

    /**
     * Get the SMS representation of the notification.
     */
    public function toSms($notifiable)
    {
        $template = config('sms.templates.carpet_received');

        // Get expected delivery date (3 days from receipt)
        $expectedDate = \Carbon\Carbon::parse($this->carpet->date_received)->addDays(3)->format('d/m/Y');

        $message = str_replace(
            [':name', ':uniqueid', ':date', ':company'],
            [
                $this->carpet->name ?? 'Customer',
                $this->carpet->uniqueid,
                $expectedDate,
                config('sms.business.name')
            ],
            $template
        );

        return $message;
    }

    /**
     * Get unique identifier for SMS tracking
     */
    public function getUniqueIdentifier()
    {
        return 'carpet_received_' . $this->carpet->id;
    }
}
