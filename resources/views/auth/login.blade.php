
@extends('adminlte::login')

{{-- TEMPORARY during the Laravel 9 to 13 upgrade: show which Laravel this server runs. Remove after the upgrade. --}}
@push('css')
<style>
    body::after {
        content: "Laravel {{ app()->version() }} · PHP {{ PHP_VERSION }}";
        position: fixed; top: 8px; right: 8px; z-index: 9999;
        padding: 4px 10px; border-radius: 4px;
        background: #b00020; color: #fff; font: 600 14px/1.4 sans-serif;
    }
</style>
@endpush
