<?php

return [

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
