<?php

use App\Http\Middleware\EndMiddleware;
use App\Http\Middleware\StartMiddleware;
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
        // // Adicionando middleware antes de todas as rotas (global)
        // $middleware->prepend([
        //     StartMiddleware::class
        // ]);
        // // Adicionando middleware antes de todas as respostas das rotas (global)
        // $middleware->append([
        //     EndMiddleware::class
        // ]);

        // Criar grupo de middlewares
        $middleware->prependToGroup('correr_antes', [
            StartMiddleware::class
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
