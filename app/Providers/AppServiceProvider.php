<?php

namespace App\Providers;

use App\Services\Slack\KosBot;
use App\Services\Slack\Slack;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * The path to your application's "home" route.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/home';

    public function boot(): void
    {
        $this->app->singleton(Slack::class, function () {
            return new Slack(
                config('services.slack.oauth_token'),
                new Client(['base_uri' => 'https://slack.com/api/']),
            );
        });

        $this->app->singleton(KosBot::class, function () {
            return new KosBot(app(Slack::class));
        });

        $this->bootAuth();
    }

    public function register(): void
    {
        //
    }

    public function bootAuth(): void
    {
        Gate::policy(\App\Models\Model::class, 'App\Policies\ModelPolicy');

        // if superuser, disregard all other gates
        Gate::before(function ($user, $ability) {
            if ($user->is_superuser()) {
                return true;
            }
        });

        Gate::define('manage-roles', function ($user) {
            return Auth::user()->is_allowed('roles', 'manage');
        });

        Gate::define('manage-keys', function ($user) {
            return Auth::user()->is_allowed('keys', 'manage');
        });

        Gate::define('manage-users', function ($user) {
            return Auth::user()->is_allowed('users', 'manage');
        });

        Gate::define('manage-teams', function ($user) {
            return Auth::user()->is_allowed('teams', 'manage');
        });

        Gate::define('manage-gatekeepers', function ($user) {
            return Auth::user()->is_allowed('gatekeepers', 'manage');
        });

        Gate::define('manage-reports', function ($user) {
            return Auth::user()->is_allowed('reports', 'manage');
        });

        Gate::define('view-user-reports', function ($user) {
            return Auth::user()->is_allowed('reports', 'users');
        });

        Gate::define('view-gatekeeper-reports', function ($user) {
            return Auth::user()->is_allowed('reports', 'gatekeepers');
        });

        Gate::define('manage-users-keys', function ($user) {
            if (Auth::user()->is_allowed('users', 'manage')) {
                return true;
            }
            if (Auth::user()->is_allowed('keys', 'manage')) {
                return true;
            }
        });

        // Returns true if user holds any of the manage- roles
        Gate::define('does-admin', function ($user) {
            if (Auth::user()->is_allowed('roles', 'manage')) {
                return true;
            }
            if (Auth::user()->is_allowed('keys', 'manage')) {
                return true;
            }
            if (Auth::user()->is_allowed('users', 'manage')) {
                return true;
            }
            if (Auth::user()->is_allowed('teams', 'manage')) {
                return true;
            }
            if (Auth::user()->is_allowed('gatekeepers', 'manage')) {
                return true;
            }
            if (Auth::user()->is_allowed('reports', 'manage')) {
                return true;
            }

            return false;
        });

        //
    }
}
