<?php

namespace App\Notifications;

use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class PaymentReminderSms extends Notification implements ShouldQueue
{
    use Queueable;

    protected $item;
    protected $type; // 'carpet' or 'laundry'

    public function __construct($item, $type)
    {
        $this->item = $item;
        $this->type = $type;
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
        $template = config('sms.templates.payment_reminder');

        $uniqueId = $this->type === 'carpet' ? $this->item->uniqueid : $this->item->unique_id;
        $name = $this->item->name ?? 'Customer';
        $service = ucfirst($this->type);
        $amount = $this->type === 'carpet' ? $this->item->price : $this->item->total;

        $message = str_replace(
            [':name', ':amount', ':service', ':uniqueid'],
            [$name, number_format($amount), $service, $uniqueId],
            $template
        );

        return $message;
    }

    /**
     * Get unique identifier for SMS tracking
     */
    public function getUniqueIdentifier()
    {
        return $this->type . '_payment_reminder_' . $this->item->id;
    }
}
