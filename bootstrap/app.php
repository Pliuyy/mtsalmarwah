<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

// Pastikan semua use statements berikut ADA dan BENAR:
use Illuminate\Auth\Middleware\AuthenticateWithBasicAuth;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Http\Middleware\SetCacheHeaders;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Routing\Middleware\RedirectIfAuthenticated; 
use Illuminate\Routing\Middleware\ValidateSignature;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Auth\Middleware\EnsureEmailIsVerified;
use App\Http\CheckUserRole; 
use App\Http\Middleware\Authenticate; 

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Middleware groups
        $middleware->web(append: [
            // \App\Http\Middleware\TrustProxies::class,
            // \Illuminate\Session\Middleware\AuthenticateSession::class,
        ]);

        $middleware->api(prepend: [
            // \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
            'throttle:api',
        ]);

        // Middleware aliases (alias rute)
        $middleware->alias([
            'auth' => Authenticate::class, // Using our custom Authenticate middleware
            'auth.basic' => AuthenticateWithBasicAuth::class,
            'bindings' => SubstituteBindings::class,
            'cache.headers' => SetCacheHeaders::class,
            'can' => Authorize::class,
            'guest' => Illuminate\Auth\Middleware\RedirectIfAuthenticated::class, // Menggunakan alias dari use statement
            'signed' => ValidateSignature::class,
            'throttle' => ThrottleRequests::class,
            'verified' => EnsureEmailIsVerified::class,
            'role' => CheckUserRole::class, // Middleware kustom kita
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();