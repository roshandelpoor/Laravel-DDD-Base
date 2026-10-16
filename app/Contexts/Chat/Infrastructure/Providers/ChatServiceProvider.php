<?php

declare(strict_types=1);

namespace App\Contexts\Chat\Infrastructure\Providers;

use App\Contexts\Chat\Domain\Repository\MessageRepository;
use App\Contexts\Chat\Infrastructure\Persistence\Eloquent\EloquentMessageRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Registers the Chat bounded context: port bindings + routes.
 */
final class ChatServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MessageRepository::class, EloquentMessageRepository::class);
    }

    public function boot(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('app/Contexts/Chat/Interfaces/Http/routes.php'));
    }
}
