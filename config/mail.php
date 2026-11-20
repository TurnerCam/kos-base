<?php

return [

    // Laravel 11 changed the framework default to "log" (mail is never sent); keep SMTP.
    'default' => env('MAIL_MAILER', 'smtp'),

    'mailers' => [
        'mailgun' => [
            'transport' => 'mailgun',
            // 'client' => [
            //     'timeout' => 5,
            // ],
        ],
    ],

    'markdown' => [
        'theme' => 'kos',

        'paths' => [
            resource_path('views/vendor/mail'),
        ],
    ],

];
