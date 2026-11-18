<?php

return [

    // Laravel 11 changed the default to "database" (kOS has no sessions table); keep files.
    'driver' => env('SESSION_DRIVER', 'file'),

];
