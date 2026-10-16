<?php

declare(strict_types=1);

namespace App\Contexts\Shared\Infrastructure\Providers;

use App\Contexts\Shared\Domain\Event\DomainEventDispatcher;
use App\Contexts\Shared\Infrastructure\Event\LaravelDomainEventDispatcher;
use Illuminate\Support\ServiceProvider;

/**
 * Binds the shared kernel ports to their infrastructure adapters.
 */
final class SharedServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(DomainEventDispatcher::class, LaravelDomainEventDispatcher::class);
    }
}
