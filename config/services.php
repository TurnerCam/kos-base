<?php

return [

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\Models\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'slack' => [
        'oauth_token' => env('SLACK_OAUTH_TOKEN'),
        'channels' => [
            'applicants' => env('SLACK_APPLICANTS_CHANNEL_ID'),
        ],
        'auto_invite' => [
            'enabled' => env('SLACK_AUTO_INVITE_ENABLED', false),
            'url' => env('SLACK_INVITE_URL'),
        ],
    ],

];
