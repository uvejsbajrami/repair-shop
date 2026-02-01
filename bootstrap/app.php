<?php

use Illuminate\Foundation\Application;
use App\Http\Middleware\SetLocale;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckPlanStatus;
use App\Http\Middleware\EmployeeMiddleware;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'admin' => AdminMiddleware::class,
            'check.plan' => CheckPlanStatus::class,
            'employee' => EmployeeMiddleware::class,
            'locale' => SetLocale::class,
        ]);

        // Apply locale middleware to web routes
        $middleware->web(append: [
            SetLocale::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
