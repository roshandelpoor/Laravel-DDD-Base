<?php

use App\Contexts\Shared\Domain\Exception\DomainException;
use App\Contexts\Shared\Domain\Exception\EntityNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );

        // Map domain exceptions to HTTP responses
        $exceptions->render(function (EntityNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        });
        $exceptions->render(function (DomainException $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        });
        $exceptions->render(function (InvalidArgumentException $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        });
    })->create();
