<?php

declare(strict_types=1);

namespace App\Contexts\Shared\Infrastructure\Event;

use App\Contexts\Shared\Domain\Event\DomainEvent;
use App\Contexts\Shared\Domain\Event\DomainEventDispatcher;
use Illuminate\Contracts\Events\Dispatcher;

/**
 * Adapter that forwards domain events to Laravel's event dispatcher,
 * so listeners can be registered with Event::listen() as usual.
 */
final class LaravelDomainEventDispatcher implements DomainEventDispatcher
{
    public function __construct(private readonly Dispatcher $events) {}

    public function dispatch(DomainEvent ...$events): void
    {
        foreach ($events as $event) {
            $this->events->dispatch($event);
        }
    }
}
