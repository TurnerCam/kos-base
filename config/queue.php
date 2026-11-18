<?php

return [

    // Laravel 11 changed the default to "database" (kOS has no jobs table and runs no
    // queue worker); keep running queued work, such as emails, immediately.
    'default' => env('QUEUE_CONNECTION', 'sync'),

];
