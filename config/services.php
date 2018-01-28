<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => C2Y\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID', '164101854134466'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET', '703ffb6018c115aa52bfbf2ce9e50380'),
        'redirect' => env('APP_URL', 'http://localhost:8000').'/callback',
    ],

    'google' => [
        'client_id' => '538077863888-o9pfhm8a6b7rle8k0hr4horur5hgmk4d.apps.googleusercontent.com',
        'client_secret' => '8Wm5rbvDBmQAllsmM0HjqSkT',
        'redirect' => env('APP_URL', 'http://localhost:8000').'/callback/google',
    ],

];
