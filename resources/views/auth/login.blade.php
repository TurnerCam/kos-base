@extends('adminlte::login')

{{--
    Outside production, show the server's environment details in a collapsible panel, so testers can
    see which Laravel, PHP and commit they are on. Production never renders it. Superusers can see the
    same details in any environment at /devinfo.

    It is pushed to the theme's script stack because adminlte's login view already fills the page
    sections; the panel is fixed to the corner of the page, so its place in the HTML doesn't matter.
--}}
@unless (app()->environment('production'))
    @push('js')
        <details id="environment-info" style="position: fixed; top: 8px; right: 8px; z-index: 9999; max-width: 480px; max-height: 90vh; overflow: auto; background: #fff; color: #212529; border: 2px solid #b00020; border-radius: 4px; padding: 4px 10px;">
            <summary style="font-weight: 600; color: #b00020;">
                {{ config('app.env') }} · Laravel {{ app()->version() }} · PHP {{ PHP_VERSION }}
            </summary>
            @include('partials.environment-info', [
                'server' => \App\Support\EnvironmentInfo::server(),
                'packages' => \App\Support\EnvironmentInfo::packages(),
                'extensions' => \App\Support\EnvironmentInfo::phpExtensions(),
            ])
        </details>
    @endpush
@endunless
