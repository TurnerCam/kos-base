<?php

use Illuminate\Support\Str;

return [

    // Laravel 11 renamed CACHE_DRIVER to CACHE_STORE and changed the default to "database"
    // (kOS has no cache table). Read either name and keep the file store as the default.
    'default' => env('CACHE_STORE', env('CACHE_DRIVER', 'file')),

    // Laravel 13 changed the default key prefix; keep the old one so existing cache entries stay valid.
    'prefix' => env('CACHE_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_cache_'),

];
