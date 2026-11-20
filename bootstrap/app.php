<?php

use App\Providers\AppServiceProvider;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        // channels: __DIR__.'/../routes/channels.php',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->redirectGuestsTo(fn () => route('login'));
        $middleware->redirectUsersTo(AppServiceProvider::HOME);

        $middleware->preventRequestForgery(except: [
            'keys/*',
            'keys',
            '/deploy',
        ]);

        $middleware->web([
            \Illuminate\Session\Middleware\AuthenticateSession::class,
            \App\Http\Middleware\HttpsProtocol::class,
            \App\Http\Middleware\CheckUserStatus::class,
        ]);

        // Laravel 11 adds CORS handling by default; kOS never had it and its API has no
        // browser clients, so keep responses unchanged.
        $middleware->remove(\Illuminate\Http\Middleware\HandleCors::class);

        $middleware->throttleApi();

        $middleware->alias([
            'api_token' => \App\Http\Middleware\ApiTokenAuth::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
