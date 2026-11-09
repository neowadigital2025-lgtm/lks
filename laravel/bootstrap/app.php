<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\AuthenticationException; // HATI-HATI: Wajib import class ini di paling atas!

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Tempat konfigurasi middleware Anda
    })
    ->withExceptions(function (Exceptions $exceptions) {
        
        // JIKA ADA ERROR AUTH (TOKEN INVALID/EXPIRED), POTONG DI SINI KOSONGKAN REDIRECT NYA
        $exceptions->render(function (AuthenticationException $e, $request) {
            return response()->json([
                'status' => 'auth_fail',
                'message' => 'Invalid or expired token.'
            ], 401);
        });

    })->create();
