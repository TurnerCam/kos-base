<?php

use Illuminate\Support\Facades\Facade;

return [

    'timezone' => 'America/Toronto',

    'deploy_secret' => env('APP_DEPLOY_SECRET'),

    'aliases' => Facade::defaultAliases()->merge([
        'Redis' => Illuminate\Support\Facades\Redis::class,
    ])->toArray(),

];
