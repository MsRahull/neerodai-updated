<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    | Razorpay. Read with config('services.razorpay.*') — never env() in app code,
    | because env() returns null once `php artisan config:cache` has been run.
    | RAZORPAY_KEY / RAZORPAY_SECRET are the older single-key names, kept as fallback.
    */
    'razorpay' => (function () {
        $mode = env('RAZORPAY_MODE', 'test') === 'live' ? 'live' : 'test';
        $prefix = $mode === 'live' ? 'RAZORPAY_LIVE_KEY_' : 'RAZORPAY_TEST_KEY_';

        return [
            'mode'   => $mode,
            'key'    => env($prefix . 'ID') ?: env('RAZORPAY_KEY'),
            'secret' => env($prefix . 'SECRET') ?: env('RAZORPAY_SECRET'),
        ];
    })(),

];
