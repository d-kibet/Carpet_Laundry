<?php

namespace App\Notifications\Channels;

use App\Services\RobermsSmsService;
use Illuminate\Notifications\Notification;

class SmsChannel
{
    protected $smsService;

    public function __construct(RobermsSmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     * @return void
     */
    public function send($notifiable, Notification $notification)
    {
        // Get the phone number from the notifiable entity
        $phoneNumber = $notifiable->phone ?? $notifiable->routeNotificationFor('sms');

        if (!$phoneNumber) {
            return;
        }

        // Get the SMS message from the notification
        $message = $notification->toSms($notifiable);

        if (!$message) {
            return;
        }

        // Get unique identifier if available
        $uniqueIdentifier = method_exists($notification, 'getUniqueIdentifier')
            ? $notification->getUniqueIdentifier()
            : null;

        // Send the SMS
        $this->smsService->sendSms($phoneNumber, $message, $uniqueIdentifier);
    }
}
