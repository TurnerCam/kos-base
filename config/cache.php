<?php

return [

    // Laravel 11 renamed CACHE_DRIVER to CACHE_STORE and changed the default to "database"
    // (kOS has no cache table). Read either name and keep the file store as the default.
    'default' => env('CACHE_STORE', env('CACHE_DRIVER', 'file')),

];
