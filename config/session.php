<?php

use Illuminate\Support\Str;

return [

    // Laravel 11 changed the default to "database" (kOS has no sessions table); keep files.
    'driver' => env('SESSION_DRIVER', 'file'),

    // Laravel 13 changed the default cookie name; keep the old one so people stay logged in.
    'cookie' => env('SESSION_COOKIE', Str::slug(env('APP_NAME', 'laravel'), '_').'_session'),

];
