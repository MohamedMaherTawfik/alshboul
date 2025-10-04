<?php

use App\Http\Middleware\SetLanguage;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Console\Scheduling\Schedule;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'check_role' => \App\Http\Middleware\CheckUserRole::class,
            'setLanguage' => SetLanguage::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('cases:check-neglected')->everyMinute();
        $schedule->command('executive-cases:check-neglected')->everyMinute();
        $schedule->command('settlements:check-neglected')->everyMinute();
        $schedule->command('check:transactions')->everyMinute();
    })
    ->create();
