<?php

use App\Http\Middleware\FrameGuard;
use App\Http\Middleware\RateLimit;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // $middleware->append(RateLimit::class);
        $middleware->append(FrameGuard::class);
        $middleware->alias([
            'admin' => App\Http\Middleware\UserIsAdmin::class,
            'revisor' => App\Http\Middleware\UserIsRevisor::class,
            'writer' => App\Http\Middleware\UserIsWriter::class,
            'admin.local'=> App\Http\Middleware\OnlyLocalAdmin::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
