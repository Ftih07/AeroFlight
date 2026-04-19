<?php

use App\Http\Middleware\HandleAppearance;
use App\Http\Middleware\HandleInertiaRequests;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Middleware\AddLinkHeadersForPreloadedAssets;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Symfony\Component\HttpFoundation\Response;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->encryptCookies(except: ['appearance', 'sidebar_state']);

        $middleware->web(append: [
            HandleAppearance::class,
            HandleInertiaRequests::class,
            AddLinkHeadersForPreloadedAssets::class,
        ]);

        $middleware->redirectUsersTo('/');

        $middleware->alias([
            'password.confirm' => \App\Http\Middleware\SmartPasswordConfirm::class,
            'no-admin' => \App\Http\Middleware\RestrictAdminAccess::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        
        // MASUKKAN LOGIKA CUSTOM ERROR DI SINI 👇
        $exceptions->respond(function (Response $response, \Throwable $exception, Request $request) {
            
            $customErrors = [403, 404, 429, 500, 503];
            
            if (in_array($response->getStatusCode(), $customErrors)) {
                return Inertia::render('Error', [
                    'status' => $response->getStatusCode(),

                    'auth' => [
                        'user' => $request->user(),
                        'is_admin' => $request->user()?->isAdmin() ?? false,
                    ],
                ])
                ->toResponse($request)
                ->setStatusCode($response->getStatusCode());
            }

            if ($response->getStatusCode() === 419) {
                return back()->with([
                    'message' => 'Sesi telah berakhir, silakan coba lagi.',
                ]);
            }

            return $response;
        });
        // 👆 SAMPAI SINI 👆

    })->create();
