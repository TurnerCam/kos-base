<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Schedule::command('process:userstatus')->dailyAt('1:00')->withoutOverlapping(10)->appendOutputTo(storage_path('logs/userstatusupdates.log'));
Schedule::command('generate:recentmembersemail')->monthlyOn(1, '00:05')->withoutOverlapping(10);
