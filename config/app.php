<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [

    'timezone' => 'America/Toronto',

    'deploy_secret' => env('APP_DEPLOY_SECRET'),

    'providers' => ServiceProvider::defaultProviders()->merge([
        /*
         * Package Service Providers...
         */
        Laravel\Tinker\TinkerServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        OwenIt\Auditing\AuditingServiceProvider::class,
        App\Providers\ComposerServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        Spatie\GoogleCalendar\GoogleCalendarServiceProvider::class,
    ])->toArray(),

    'aliases' => Facade::defaultAliases()->merge([
        'Image' => Intervention\Image\Facades\Image::class,
        'Redis' => Illuminate\Support\Facades\Redis::class,
    ])->toArray(),

];
