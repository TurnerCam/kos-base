<?php

return [

    // Laravel 11 changed the framework default to sqlite; keep kOS's MySQL default.
    'default' => env('DB_CONNECTION', 'mysql'),

    'migrations' => [
        'table' => 'migrations',
        'update_date_on_publish' => false, // disable to preserve original behavior for existing applications
    ],

];
