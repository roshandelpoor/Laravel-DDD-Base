<?php

declare(strict_types=1);

namespace App\Contexts\Identity\Infrastructure\Providers;

use App\Contexts\Identity\Domain\Repository\UserRepository;
use App\Contexts\Identity\Domain\Service\PasswordHasher;
use App\Contexts\Identity\Infrastructure\Hashing\LaravelPasswordHasher;
use App\Contexts\Identity\Infrastructure\Persistence\Eloquent\EloquentUserRepository;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * Registers the Identity bounded context: port bindings + routes.
 */
final class IdentityServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(UserRepository::class, EloquentUserRepository::class);
        $this->app->bind(PasswordHasher::class, LaravelPasswordHasher::class);
    }

    public function boot(): void
    {
        Route::middleware('api')
            ->prefix('api')
            ->group(base_path('app/Contexts/Identity/Interfaces/Http/routes.php'));
    }
}
