<?php

return [

    /*
    |--------------------------------------------------------------------------
    | SMS Provider
    |--------------------------------------------------------------------------
    |
    | Default SMS provider to use for sending messages
    |
    */

    'default' => env('SMS_PROVIDER', 'roberms'),

    /*
    |--------------------------------------------------------------------------
    | Roberms SMS Configuration
    |--------------------------------------------------------------------------
    |
    | Configuration for Roberms SMS API
    | Get your credentials from https://roberms.co.ke
    |
    */

    'roberms' => [
        'base_url' => env('ROBERMS_BASE_URL', 'https://roberms.co.ke/sms/v1/roberms'),
        'consumer_key' => env('ROBERMS_CONSUMER_KEY'),
        'consumer_password' => env('ROBERMS_CONSUMER_PASSWORD'),
        'sender_name' => env('ROBERMS_SENDER_NAME', 'RAHA'),
    ],

    /*
    |--------------------------------------------------------------------------
    | SMS Templates
    |--------------------------------------------------------------------------
    |
    | Pre-defined message templates for different scenarios
    |
    */

    'templates' => [
        'welcome' => 'Hello, welcome to :Raha CarpetWash! We appreciate your business. For inquiries, call us at :0114440444.',

        'carpet_received' => 'Hello, we have received your carpet. It will be ready within 24Hrs. Thank you!',

        'laundry_received' => 'Hello, we have received your laundry. It will be ready within 24Hrs. Thank you!',

        'ready_for_pickup' => 'Hello, your carpet(s) is ready for pickup. Thank you!',

        'payment_reminder' => 'Hello, this is a friendly reminder about your pending payment. Kindly settle to collect your items. Thank you!',

        'overdue_reminder' => 'Hello, your :service (:uniqueid) has been ready for :days days. Kindly collect it at :location. Payment: KES :amount. Thank you!',

        'thank_you' => 'Hello, thank you for your business! We hope to serve you again soon. For future services, call us at :phone.',

        'promotional' => 'Hello! We have an offer specifically for you. Call :0114440444 to book. Thank you!',

        'birthday' => 'Happy Birthday! Enjoy :discount on your next service. Valid for 7 days. Call :0114440444. Cheers!',

        'inactive_customer' => 'Hello, we miss you! It\'s been a while since your last visit. Get :discount on your next service. Call : 0114440444. We look forward to serving you!',
    ],

    /*
    |--------------------------------------------------------------------------
    | Automated SMS Settings
    |--------------------------------------------------------------------------
    |
    | Enable/disable automatic SMS sending for different events
    |
    */

    'auto_send' => [
        'on_carpet_received' => env('SMS_AUTO_CARPET_RECEIVED', false),
        'on_laundry_received' => env('SMS_AUTO_LAUNDRY_RECEIVED', false),
        'on_ready_for_pickup' => env('SMS_AUTO_READY_PICKUP', false),
        'on_payment_received' => env('SMS_AUTO_PAYMENT_RECEIVED', false),
        'payment_reminders' => env('SMS_AUTO_PAYMENT_REMINDERS', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Business Information
    |--------------------------------------------------------------------------
    |
    | Your business details for SMS templates
    |
    */

    'business' => [
        'name' => env('BUSINESS_NAME', 'Raha Carpet & Laundry'),
        'phone' => env('BUSINESS_PHONE', '0712345678'),
        'location' => env('BUSINESS_LOCATION', 'Nairobi'),
    ],

];
