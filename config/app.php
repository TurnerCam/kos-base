<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    'timezone' => 'America/Toronto',

    'deploy_secret' => env('APP_DEPLOY_SECRET'),


    'aliases' => Facade::defaultAliases()->merge([
        'Image' => Intervention\Image\Facades\Image::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
    ])->toArray(),

];
