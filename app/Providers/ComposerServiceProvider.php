<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     */
    public function boot(): void
    {
        // Using class based composers...
        // View::composer('header', 'App\Http\ViewComposers\UserMenuComposer');
    }

    /**
     * Register the service provider.
     */
    public function register(): void
    {
        //
    }
}
