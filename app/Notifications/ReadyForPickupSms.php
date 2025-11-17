<?php

namespace App\Notifications;

use App\Notifications\Channels\SmsChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReadyForPickupSms extends Notification implements ShouldQueue
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
        $template = config('sms.templates.ready_for_pickup');

        $uniqueId = $this->type === 'carpet' ? $this->item->uniqueid : $this->item->unique_id;
        $name = $this->item->name ?? 'Customer';
        $service = ucfirst($this->type);
        $location = $this->item->location ?? config('sms.business.location');

        $message = str_replace(
            [':name', ':service', ':uniqueid', ':location'],
            [$name, $service, $uniqueId, $location],
            $template
        );

        return $message;
    }

    /**
     * Get unique identifier for SMS tracking
     */
    public function getUniqueIdentifier()
    {
        return $this->type . '_ready_' . $this->item->id;
    }
}
